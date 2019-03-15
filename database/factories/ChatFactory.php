<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Chat::class, function (Faker $faker) {
    return [
        'name'              => $faker->word,
        'description'       => $faker->text,
        'chat_status_id'    => 1
    ];
});
