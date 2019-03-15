<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'body',
        'rating',
        'color',
        'feedback_category_id'
    ];

    protected $hidden = [
        'feedback_category_id'
    ];

    public function feedbackCategory()
    {
        return $this->belongsTo(FeedbackCategory::class);
    }
}
