<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Feedback::class, function (Faker $faker) {
    return [
        'body'                  => $faker->text,
        'rating'                => $faker->numberBetween($min = 0, $max = 10),
        'color'                 => $faker->hexcolor,
        'feedback_category_id'  => 1
    ];
});
