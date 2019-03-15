<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationAnswerCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'color'
    ];

    protected $hidden = [];
}
