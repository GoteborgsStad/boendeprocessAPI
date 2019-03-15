<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationGoal extends Model
{
    protected $fillable = [
        'goal_id',
        'evaluation_id'
    ];

    protected $hidden = [
        'goal_id',
        'evaluation_id'
    ];

    public function evaluationGoalCategory()
    {
        return $this->belongsTo(EvaluationGoalCategory::class);
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
