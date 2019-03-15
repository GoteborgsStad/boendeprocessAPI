<?php

namespace App\Http\Controllers\AdolescentUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Jobs\SendMail;

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

        $adolescent = $chat->users()->with('userRole')->get()->where('userRole.name', 'AU')->first();
        $contact    = $chat->users()->with('userRole')->get()->where('userRole.name', 'CU')->first();

        $globalStatuses = \App\UserRelationship::globalStatuses($contact, $adolescent);
        $globalStatus   = $globalStatuses->where('key', 'new_message_amount_from_adolescent')->first();

        $globalStatus->update([
            'value' => strval((int)$globalStatus->value + 1),
        ]);

        $chatMessage = \App\ChatMessage::with(['chatMessageStatus', 'user', 'user.userDetail'])->findOrFail($chatMessage->id);

        if ($contact->userConfigurations()->where('key', 'email_adolescents_sent_message')->firstOrFail()->value === '1') {
            SendMail::dispatch(
                $contact->userDetail->email,
                $contact->userDetail->first_name . ' ' . $contact->userDetail->last_name,
                'Notifikation',
                'newmessage',
                $args = [
                    'url'       => env('APP_URL_SERVICE_1'),
                    'firstName' => $contact->userDetail->first_name,
                    'icon'      => env('APP_URL') . '/images/icon_book.png',
                ]
            )->onConnection('database')->onQueue('email');
        }

        return response()->json($chatMessage, 200);
    }
}
