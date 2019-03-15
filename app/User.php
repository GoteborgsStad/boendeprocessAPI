<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'personal_identity_number',
        'password',
        'user_role_id'
    ];

    protected $hidden = [
        'pivot',
        'password',
        'remember_token',
        'user_role_id'
    ];

    protected $appends = [
        'amount_of_contacts',
        'amount_of_adolescents',
        'is_me',
        'highest_assignment_status',
        'highest_goal_status'
    ];

    public function chats()
    {
        return $this->belongsToMany(Chat::class);
    }

    public static function chat($parent, $child)
    {
        $collection = collect([]);

        foreach ($parent->chats()->get() as $key => $parentChat) {
            foreach ($child->chats()->get() as $key => $childChat) {
                if ($parentChat->pivot->chat_id === $childChat->pivot->chat_id) {
                    return \App\Chat::with(['chatMessages', 'chatMessages.user'])->findOrFail($parentChat->pivot->chat_id);
                }
            }
        }

        return null;
    }

    public static function allContacts($operand)
    {
        return \App\Operand::findOrFail($operand->id)->users()->where('user_role_id', \App\UserRole::where('name', 'CU')->firstOrFail()->id)->with('userDetail')->get();
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function getAmountOfContactsAttribute()
    {
        return $this->parentRelationships()->count()-1;
    }

    public function getAmountOfAdolescentsAttribute()
    {
        return $this->childRelationships()->count();
    }

    public function getIsMeAttribute()
    {
        return ($this->id === \Auth::id()) ? true: false;
    }

    public function globalStatuses()
    {
        return $this->belongsToMany(GlobalStatus::class);
    }

    public function getHighestGoalStatusAttribute()
    {
        // $goals      = (array)\App\Plan::with('goals.goalStatus')->where('user_id', $this->id)->first()['goals'];
        // $highest    = null;

        // foreach ($goals as $key => $goal) {
        //     if ((object)$goal[0]['goalStatus']['id'] === 5) {
        //         return (object)$goal[0]['goalStatus'];
        //     }
        //     if ((object)$goal[0]['goalStatus']['id'] !== 6 && $highest === null) {
        //         $highest = (object)$goal[0]['goalStatus'];
        //     }
        //     if (is_null($highest) || $highest->id < (int)$goal[0]['goalStatus']['id']) {
        //         $highest = (object)$goal[0]['goalStatus'];
        //     }
        // }

        // return $highest;
    }

    public function getHighestAssignmentStatusAttribute()
    {
        $assignments    = \App\Assignment::with('assignmentStatus')->where('user_id', $this->id)->get();
        $highest        = \App\Assignment::findOrFail(1);

        foreach ($assignments as $key => $assignment) {
            if ($assignment->assignmentStatus->id === 5) {
                return $assignment->assignmentStatus;
            }
            if ((is_null($highest) && ($assignment->assignmentStatus->id < 6)) || (($highest->id < $assignment->assignmentStatus->id) && ($assignment->assignmentStatus->id < 6))) {
                $highest = $assignment->assignmentStatus;
            }
        }

        return $highest;
    }

    public function operands()
    {
        return $this->belongsToMany(Operand::class);
    }

    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function userConfigurations()
    {
        return $this->hasMany(UserConfiguration::class);
    }

    public function parentRelationships()
    {
        return $this->hasMany(UserRelationship::class, 'user_id', 'id');
    }

    public function childRelationships()
    {
        return $this->hasMany(UserRelationship::class, 'parent_id');
    }

    public function userRelationships()
    {
        return $this->hasMany(UserRelationship::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function plan()
    {
        return $this->hasOne(Plan::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public static function scopeAdolescents($query)
    {
        return $query->where('user_role_id', \App\UserRole::where('name', 'AU')->firstOrFail()->id);
    }

    public static function scopeContacts($query)
    {
        return $query->where('user_role_id', \App\UserRole::where('name', 'CU')->firstOrFail()->id);
    }

    public function scopeOfOperand($query, $operand)
    {
        $users = $query->with(['operands'])->get();
        $collection = collect([]);

        foreach ($users as $key => $user) {
            if (is_object($operand)) {
                if ($user->operands->first()->id === $operand->id) {
                    $globalStatuses = \App\UserRelationship::globalStatuses($user, \Auth::user());
                    $user->global_statuses = $globalStatuses;

                    unset($user->created_at);
                    unset($user->updated_at);
                    unset($user->personal_identity_number);
                    unset($user->operands);

                    $collection->push($user);
                }
            }
            
        }

        return $collection;
    }
}
