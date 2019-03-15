<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoalTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_at',
        'end_at',
        'color',
        'goal_category_id',
        'goal_status_id',
    ];

    protected $hidden = [
        'goal_category_id',
        'goal_status_id'
    ];

    public function goalCategory()
    {
        return $this->belongsTo(GoalCategory::class);
    }
}
