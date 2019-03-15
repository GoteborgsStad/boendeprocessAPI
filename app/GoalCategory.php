<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoalCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    protected $hidden = [];
}
