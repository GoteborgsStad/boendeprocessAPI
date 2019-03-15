<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlobalStatus extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    protected $hidden = [];
}
