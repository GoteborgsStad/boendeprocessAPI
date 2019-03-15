<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\GoalTemplate::class, function (Faker $faker) {
    return [
        'name'                      => $faker->word,
        'description'               => $faker->text,
        'start_at'                  => '2017-01-01 00:00:00',
        'end_at'                    => '2017-01-01 00:00:00',
        'color'                     => $faker->hexcolor,
        'goal_category_id'          => 1,
        'goal_status_id'            => 1
    ];
});
