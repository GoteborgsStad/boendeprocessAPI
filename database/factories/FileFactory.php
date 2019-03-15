<?php

use Faker\Generator as Faker;

$factory->define(\App\File::class, function (Faker $faker) {
    $uuid = Uuid::generate()->string;

    return [
        'uuid'                  => $uuid,
        'original_name'         => 'file_name_example',
        'original_extension'    => '.png',
        'name'                  => $uuid,
        'extension'             => '.png',
        'full_path'             => env('FILE_UPLOAD_PATH') . $uuid . '.png',
        'user_id'               => 1,
    ];
});
