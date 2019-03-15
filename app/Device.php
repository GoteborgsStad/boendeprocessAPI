<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'token',
        'type',
        'app',
        'user_id',
    ];

    protected $hidden = [
        'pivot',
        'user_id'
    ];

    public function notifications()
    {
        return $this->belongsToMany(Notification::class);
    }

    public function scopeOfUser($query, $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
