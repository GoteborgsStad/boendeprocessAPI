<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatStatus extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    protected $hidden = [];
}
