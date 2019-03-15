<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\AssignmentTemplate::class, function (Faker $faker) {
    return [
        'name'                      => $faker->word,
        'description'               => $faker->text,
        'start_at'                  => '2017-01-01 00:00:00',
        'end_at'                    => '2017-01-01 00:00:00',
        'image_url'                 => $faker->imageUrl($width = 128, $height = 128),
        'color'                     => $faker->hexcolor,
        'assignment_category_id'    => 1,
        'assignment_status_id'      => 1,
    ];
});
