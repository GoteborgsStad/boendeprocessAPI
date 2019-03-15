<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationStatus extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_at',
        'end_at',
        'accepted_at',
        'finished_at',
        'color'
    ];

    protected $hidden = [
        'adolescent_id',
        'assignment_category_id',
        'assignment_form_id',
        'assignment_status_id'
    ];
}
