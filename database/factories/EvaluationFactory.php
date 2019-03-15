<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Evaluation::class, function (Faker $faker) {
    return [
        'name'                  => $faker->word,
        'description'           => $faker->text,
        'user_id'               => 1,
        'evaluation_status_id'  => 1
    ];
});
