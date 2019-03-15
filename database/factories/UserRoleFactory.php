<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\UserRole::class, function (Faker $faker) {
    return [
        'name'          => $faker->name,
        'description'   => $faker->text,
        'color'         => $faker->hexcolor
    ];
});
