<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Jobs\SendPush;

class ChatsController extends Controller
{
    public function index()
    {
        $chats = \App\User::findOrFail(\Auth::id())->chats()->with(['users', 'users.userDetail', 'users.userRole'])->get();

        return response()->json($chats, 200);
    }

    public function chatMessages($id)
    {
        $chatAnswers = \App\Chat::findOrFail($id)->chatMessages()->with(['chatMessageStatus', 'user', 'user.userDetail'])->get();

        return response()->json($chatAnswers, 200);
    }

    public function storeChatMessages(Request $request, $id)
    {
        $this->validate($request, [
            'body'                      => 'required|string|max:65535',
            'chat_message_status_id'    => 'integer'
        ]);

        $chat               = \App\Chat::findOrFail($id);
        $chatMessageStatus  = \App\ChatMessageStatus::findOrFail($request->input('chat_message_status_id', 1));

        if (!\Auth::user()->chats()->find($chat->id)) {
            return response()->json('not_attached_to_chat', 403);
        }

        $chatMessage = \App\ChatMessage::create([
            'body'                      => $request->input('body'),
            'chat_message_status_id'    => $chatMessageStatus->id,
            'chat_id'                   => $chat->id,
            'user_id'                   => \Auth::id()
        ]);

        $users = $chat->users()->with(['userRole', 'userConfigurations'])->get();

        foreach ($users as $key => $user) {
            if ($user->userRole->name === 'AU') {
                $adolescent = $user;
            }
        }

        $contact = \Auth::user();

        $globalStatuses = \App\UserRelationship::globalStatuses($contact, $adolescent);
        $globalStatus   = $globalStatuses->where('key', 'new_message_amount_from_contact')->first();

        $globalStatus->update([
            'value' => strval((int)$globalStatus->value + 1),
        ]);

        if ($adolescent->userConfigurations()->where('key', 'notification_contact_new_chat_message')->firstOrFail()->value === '1') {
            SendPush::dispatch(
                'Nytt Meddelande',
                'Något 1',
                'Du har ett oläst meddelande',
                true,
                1,
                collect([$adolescent]),
                ['Sambuh']
            )->onConnection('database')->onQueue('push');    
        }

        $chatMessage = \App\ChatMessage::with(['chatMessageStatus', 'user', 'user.userDetail'])->findOrFail($chatMessage->id);

        return response()->json($chatMessage, 200);
    }
}
