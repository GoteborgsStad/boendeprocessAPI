<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string|max:255',
            'type'  => 'required|string|max:255',
            'app'   => 'required|string|max:255',
        ]);

        if (\App\Device::where('token', $request->input('token'))->where('type', $request->input('type'))->where('app', $request->input('app'))->get()->count() > 0) {
            return response()->json('already_stored', 200);
        }

        $device = \App\Device::create($request->all() + [
            'user_id' => \Auth::id(),
        ]);

        return response()->json($device, 200);
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string|max:255',
            'type'  => 'required|string|max:255',
            'app'   => 'required|string|max:255',
        ]);

        $device = \App\Device::where('token', $request->input('token'))->where('type', $request->input('type'))->where('app', $request->input('app'))->firstOrFail();

        if ($device->user_id !== \Auth::id()) {
            return response()->json('not_your_token', 403);
        }

        $device->delete();

        return response()->json($device, 200);
    }
}
