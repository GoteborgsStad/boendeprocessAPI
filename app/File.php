<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'userdetails' => UserDetail::class
]);

class File extends Model
{
    const TYPE_IMAGE    = 'image';
    const TYPE_ICON     = 'icon';

    protected $fillable = [
        'uuid',
        'original_name',
        'original_extension',
        'name',
        'extension',
        'full_path',
        'user_id'
    ];

    protected $hidden = [
        'user_id'
    ];

    public static function path($name, $type = self::TYPE_IMAGE)
    {
        if (!empty($name) && file_exists(env('FILE_UPLOAD_PATH') . $type . 's/' . $name)) {
            return env('FILE_UPLOAD_URL') . $type . 's/' . $name;
        } else {
            return null;
        }

        return self::$path;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
