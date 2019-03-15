<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'body',
        'chat_message_status_id',
        'chat_id',
        'user_id'
    ];

    protected $hidden = [
        'chat_message_status_id',
        'chat_id',
        'user_id'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function chatMessageStatus()
    {
        return $this->belongsTo(chatMessageStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
