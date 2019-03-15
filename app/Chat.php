<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'name',
        'description',
        'chat_status_id',
    ];

    protected $hidden = [
        'chat_status_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
