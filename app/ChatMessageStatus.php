<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessageStatus extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    protected $hidden = [];
}
