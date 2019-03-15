<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $appends = [
        'amount_of_goals',
        'amount_of_finished_goals',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAmountOfGoalsAttribute()
    {
        return $this->goals()->count();
    }

    public function getAmountOfFinishedGoalsAttribute()
    {
        $goalStatus = \App\GoalStatus::where('name', 'Avklarat')->firstOrFail();

        return $this->goals()->where('goal_status_id', $goalStatus->id)->count();
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }
}
