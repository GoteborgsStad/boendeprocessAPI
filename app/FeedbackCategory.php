<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    protected $hidden = [];
}
