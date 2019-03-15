<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserConfiguration extends Model
{
    protected $fillable = [
        'key',
        'value',
        'user_id'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function scopeConfiguration($query, $key)
    {
        return $query->where('key', $key);
    }
}
