<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_at',
        'end_at',
        'finished_at',
        'color',
        'goal_category_id',
        'goal_status_id',
        'plan_id'
    ];

    protected $hidden = [
        'goal_category_id',
        'goal_status_id',
        'plan_id'
    ];

    public function goalCategory()
    {
        return $this->belongsTo(GoalCategory::class);
    }

    public function goalStatus()
    {
        return $this->belongsTo(GoalStatus::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
