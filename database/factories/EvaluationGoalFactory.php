<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\EvaluationGoal::class, function (Faker $faker) {
    return [
        'goal_id'       => 1,
        'evaluation_id' => 1
    ];
});
