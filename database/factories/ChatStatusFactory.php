<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\ChatStatus::class, function (Faker $faker) {
    return [
        'name'          => $faker->word,
        'description'   => $faker->text,
        'color'         => $faker->hexcolor
    ];
});
