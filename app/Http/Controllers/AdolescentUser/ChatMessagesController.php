<?php

namespace App\Http\Controllers\AdolescentUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatMessagesController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'body'      => 'required|string|max:65535',
            'chat_id'   => 'required|integer'
        ]);

        $me                 = \App\User::findOrFail(\Auth::id());
        $chat               = $me->chats()->findOrFail($request->input('chat_id'));
        $chatMessageStatus  = \App\ChatMessageStatus::where('name', 'Nytt')->firstOrFail();

        $chatMessage = \App\ChatMessage::create([
            'body'                      => $request->input('body'),
            'chat_message_status_id'    => $chatMessageStatus->id,
            'chat_id'                   => $chat->id
        ]);

        return response()->json($chatMessage, 200);
    }
}
