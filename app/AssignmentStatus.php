<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentStatus extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    protected $hidden = [];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
