<?php

namespace App\Http\Controllers\AdolescentUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function me()
    {
        $me = \App\User::with([
            'operands',
            'userConfigurations',
            'userDetail',
            'parentRelationships.parent.userDetail',
            'userRole'
        ])->findOrFail(\Auth::id());

        foreach ($me->parentRelationships as $key => $relationship) {
            $globalStatuses = \App\UserRelationship::globalStatuses($relationship->parent, \Auth::user());

            $relationship->parent->global_statuses = $globalStatuses;
        }

        $me['contacts'] = \App\User::allContacts(\Auth::user()->operands()->firstOrFail());

        return response()->json($me, 200);
    }

    public function destroyMe()
    {
        $me = \App\User::findOrFail(\Auth::id());
        $me->delete();

        return response()->json($me, 200);
    }

    public function updateUserDetails(Request $request)
    {
        $this->validate($request, [
            'image_uuid'    => 'string|max:36',
            'email'         => 'string|max:255',
        ]);

        $userDetail = \App\UserDetail::where('user_id', \Auth::id())->firstOrFail();

        $file = \App\File::where('uuid', $request->input('image_uuid'))->first();
        $fileName = null;

        if(!is_null($file)){
            $fileName = $file->name . '.' . $file->extension;
        }

        $userDetail->update($request->except(['image_uuid']) + [
            'image_url' => $fileName,
        ]);

        $userDetail = \App\UserDetail::findOrFail($userDetail->id);

        return response()->json($userDetail, 200);
    }

    public function updateUserConfigurations(Request $request)
    {
        $this->validate($request, [
            'key'   => 'required|string|max:255',
            'value' => 'required|string|max:255'
        ]);

        $userConfiguration = \App\User::findOrFail(\Auth::id())->userConfigurations()->where('key', $request->input('key'))->with('user')->firstOrFail();

        $userConfiguration->update($request->all());

        return response()->json($userConfiguration, 200);
    }

    public function chats($id)
    {
        $me             = \Auth::user();
        $operandMe      = $me->operands()->firstOrFail();
        $user           = \App\User::findOrFail($id);
        $operandUser    = $user->operands()->firstOrFail();

        if ($operandMe->id !== $operandUser->id) {
            return response()->json('not_same_operand', 403);
        }

        $chat           = \App\User::chat($user, $me);
        $users          = $chat->users()->with(['userDetail', 'userRole'])->get();
        $chat['users']  = $users;

        $adolescent = \Auth::user();
        $contact    = $user;

        $globalStatuses = \App\UserRelationship::globalStatuses($contact, $adolescent);
        $globalStatus   = $globalStatuses->where('key', 'new_message_amount_from_contact')->first();

        $globalStatus->update([
           'value' => 0,
        ]);

        return response()->json($chat, 200);
    }

    public function globalStatuses()
    {
        $contacts = \App\User::contacts()->ofOperand(\Auth::user()->operands()->firstOrFail());

        return response()->json($contacts, 200);
    }

    public function plans()
    {
        $plan = \Auth::user()->plan()->with(['goals', 'goals.goalCategory', 'goals.goalStatus'])->firstOrFail();

        return response()->json($plan, 200);
    }
}
