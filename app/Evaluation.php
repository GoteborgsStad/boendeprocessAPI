<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color',
        'user_id',
        'evaluation_status_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'user_id',
        'evaluation_status_id',
    ];

    public function evaluationStatus()
    {
        return $this->belongsTo(EvaluationStatus::class);
    }

    public function evaluationAnswers()
    {
        return $this->hasMany(EvaluationAnswer::class)->orderBy('evaluation_answer_category_id');
    }

    public function evaluationGoals()
    {
        return $this->hasMany(EvaluationGoal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
