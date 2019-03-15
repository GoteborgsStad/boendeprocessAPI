<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operand extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
