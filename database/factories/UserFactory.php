<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\User::class, function (Faker $faker) {
    $au = \App\UserRole::where('name', 'au')->firstOrFail();

    return [
        'personal_identity_number'  => str_replace('-', '', $faker->personalIdentityNumber()),
        'password'                  => bcrypt('secret'),
        'remember_token'            => str_random(10),
        'user_role_id'              => $au->id
    ];
});
