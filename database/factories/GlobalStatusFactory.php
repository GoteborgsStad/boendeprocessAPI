<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\GlobalStatus::class, function (Faker $faker) {
    return [
        'key'       => $faker->name,
        'value'     => $faker->sentence(),
    ];
});
