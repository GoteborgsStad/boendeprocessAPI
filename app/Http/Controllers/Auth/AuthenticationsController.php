<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthenticationsController extends Controller
{
    public function login(Request $request)
    {
        $validator = $this->validate($request, [
            'personal_identity_number'  => 'required|string|max:13',
        ]);

        if ($request->only('login_key') !== env('LOGIN_KEY')) {
            return response()->json('login_not_allowed', 405);
        }

        $personalIdentityNumber = $request->input('personal_identity_number');

        if (!\App\User::where('personal_identity_number', $personalIdentityNumber)->get()->count()) {
            if (in_array(strlen($personalIdentityNumber), [12, 13])) {
                $personalIdentityNumber = substr($personalIdentityNumber, 2);
            }

            if (strlen($personalIdentityNumber) === 11) {
                $personalIdentityNumber = str_replace('-', '', $personalIdentityNumber);
            }
        }

        $user = \App\User::where('personal_identity_number', $personalIdentityNumber)->with('userRole')->firstOrFail();

        try {
            $credentials                                = $request->only('personal_identity_number', 'password');
            $credentials['personal_identity_number']    = $personalIdentityNumber;
            $credentials['password']                    = 'secret';

            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials, ['role' => $user->userRole->name])) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function logout(Request $request)
    {
        $token = JWTAuth::getToken();

        if ($token) {
            JWTAuth::invalidate($token);
        }

        return response()->json(true, 200);
    }

    public function refreshToken()
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            throw new BadRequestHtttpException('token_not_provided');
        }
        try {
            $token = JWTAuth::refresh($token);
        } catch (TokenInvalidException $e) {
            throw new AccessDeniedHttpException('invalid_token');
        }

        return response()->json($token, 200);
    }
}
