<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationAnswer extends Model
{
    protected $fillable = [
        'body',
        'rating',
        'evaluation_id',
        'evaluation_answer_category_id'
    ];

    protected $hidden = [
        'evaluation_id',
        'evaluation_answer_category_id'
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function evaluationAnswerCategory()
    {
        return $this->belongsTo(EvaluationAnswerCategory::class);
    }
}
