<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'display_name',
        'email',
        'sex',
        'description',
        'street_address',
        'zip_code',
        'city',
        'home_phone_number',
        'cell_phone_number',
        'image_url',
        'color',
        'user_id'
    ];

    protected $hidden = [
        'user_id'
    ];

    protected $appends = [
        'full_name'
    ];

    public function getImageUrlAttribute($value)
    {
        return \App\File::path($value, \App\File::TYPE_IMAGE);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
