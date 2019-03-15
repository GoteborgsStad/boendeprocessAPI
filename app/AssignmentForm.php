<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentForm extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    protected $hidden = [];

    public function operands()
    {
        return $this->belongsToMany(Assignment::class);
    }
}
