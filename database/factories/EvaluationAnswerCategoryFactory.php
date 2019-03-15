<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\EvaluationAnswerCategory::class, function (Faker $faker) {
    return [
        'name'          => $faker->word,
        'description'   => $faker->text,
        'type'          => $faker->word,
        'color'         => $faker->hexcolor
    ];
});
