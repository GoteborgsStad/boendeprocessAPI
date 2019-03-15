<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRelationship extends Model
{
    protected $fillable = [
        'parent_id',
        'user_id'
    ];

    protected $hidden = [
        'parent_id',
        'user_id'
    ];

    public static function globalStatuses($parent, $child)
    {
        $collection = collect([]);

        foreach ($parent->globalStatuses()->get() as $key => $parentGlobal) {
            foreach ($child->globalStatuses()->get() as $key => $childGlobal) {
                if ($parentGlobal->pivot->global_status_id === $childGlobal->pivot->global_status_id) {
                    $collection->push(\App\GlobalStatus::findOrFail($parentGlobal->pivot->global_status_id));
                }
            }
        }

        return $collection;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
