<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoalStatus extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    protected $hidden = [];
}
