<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_at',
        'end_at',
        'image_url',
        'color',
        'assignment_category_id',
        'assignment_status_id',
    ];

    protected $hidden = [
        'assignment_category_id',
        'assignment_status_id'
    ];

    public function assignmentCategory()
    {
        return $this->belongsTo(AssignmentCategory::class);
    }

    public function assignmentForms()
    {
        return $this->belongsToMany(AssignmentForm::class, 'assignment_template_assignment_form', 'a_t_id', 'a_f_id');
    }

    public function assignmentStatus()
    {
        return $this->belongsTo(AssignmentStatus::class);
    }

    public function getImageUrlAttribute($value)
    {
        return \App\File::path($value, \App\File::TYPE_IMAGE);
    }
}
