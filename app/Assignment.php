<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'name',
        'description',
        'answer',
        'start_at',
        'end_at',
        'accepted_at',
        'finished_at',
        'image_description_url',
        'image_url',
        'color',
        'user_id',
        'assignment_category_id',
        'assignment_status_id'
    ];

    protected $hidden = [
        'user_id',
        'assignment_category_id',
        'assignment_status_id'
    ];

    public function assignmentCategory()
    {
        return $this->belongsTo(AssignmentCategory::class);
    }

    public function assignmentForms()
    {
        return $this->belongsToMany(AssignmentForm::class, 'assignment_assignment_form', 'a_id', 'a_form_id');
    }

    public function assignmentStatus()
    {
        return $this->belongsTo(AssignmentStatus::class);
    }

    public function getImageUrlAttribute($value)
    {
        return \App\File::path($value, \App\File::TYPE_IMAGE);
    }

    public function getImageDescriptionUrlAttribute($value)
    {
        return \App\File::path($value, \App\File::TYPE_IMAGE);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
