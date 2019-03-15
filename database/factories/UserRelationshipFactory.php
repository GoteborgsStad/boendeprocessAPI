<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\UserRelationship::class, function (Faker $faker) {
    return [
        'parent_id' => 1,
        'user_id'   => 1
    ];
});
