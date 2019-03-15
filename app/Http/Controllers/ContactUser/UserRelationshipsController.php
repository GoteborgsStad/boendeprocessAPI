<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRelationshipsController extends Controller
{
    public function index()
    {
        $operand    = \Auth::user()->operands()->firstOrFail();
        $users      = $operand->users()->with(['userRelationships', 'userRelationships.parent', 'userRelationships.user'])->get();

        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'parent_id' => 'required|integer',
            'user_id'   => 'required|integer'
        ]);

        $parent = \App\User::findOrFail($request->input('parent_id'));
        $child  = \App\User::findOrFail($request->input('user_id'));

        $userRelationship = \App\UserRelationship::where('parent_id', $request->input('parent_id'))->where('user_id', $request->input('user_id'))->first();

        if(!is_null($userRelationship)){
            return response()->json('already_connected', 403);
        }

        $operandMe      = \Auth::user()->operands()->firstOrFail();
        $operandParent  = $parent->operands()->firstOrFail();
        $operandChild   = $child->operands()->firstOrFail();

        if (($operandMe->id !== $operandChild->id) || ($operandMe->id !== $operandParent->id)) {
            return response()->json('not_same_operand', 403);
        }

        $userRelationship = \App\UserRelationship::create([
            'parent_id' => $parent->id,
            'user_id'   => $child->id
        ]);

        $globalStatuses = \App\GlobalStatus::distinct()->get(['key']);

        foreach ($globalStatuses as $key => $globalStatus) {
            $globalStatus = \App\GlobalStatus::create([
                'key'   => $globalStatus->key,
                'value' => 0,
            ]);

            $child->globalStatuses()->attach($globalStatus->id);
            $parent->globalStatuses()->attach($globalStatus->id);
        }

        $chat = \App\Chat::create([
            'name'              => 'Chatt',
            'description'       => 'Chatt mellan ungdom och kontaktperson.',
            'chat_status_id'    => 1,
        ]);

        $child->chats()->attach($chat->id);
        $parent->chats()->attach($chat->id);

        $userRelationship = $userRelationship->with(['parent', 'user'])->firstOrFail();

        return response()->json($userRelationship, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'parent_id' => 'required|integer',
            'user_id'   => 'required|integer'
        ]);

        $userRelationship = \App\UserRelationship::findOrFail($id);

        $userRelationship->update([
            'parent_id'     => $request->input('parent_id'),
            'user_id'       => $request->input('user_id')
        ]);

        $userRelationship = $userRelationship->with(['parent', 'user'])->firstOrFail();

        return response()->json($userRelationship, 200);
    }

    public function destroy($id)
    {
        $userRelationship = \App\UserRelationship::findOrFail($id);
        $userRelationship->delete();

        return response()->json($userRelationship, 200);
    }
}
