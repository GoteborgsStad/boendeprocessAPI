<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\EvaluationAnswer::class, function (Faker $faker) {
    return [
        'body'                          => $faker->text,
        'rating'                        => $faker->numberBetween($min = 1, $max = 6),
        'evaluation_id'                 => 1,
        'evaluation_answer_category_id' => 1
    ];
});
