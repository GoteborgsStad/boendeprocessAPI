<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\UserDetail::class, function (Faker $faker) {
    return [
        'first_name'        => $faker->firstName(),
        'last_name'         => $faker->lastName,
        'display_name'      => $faker->word,
        'email'             => $faker->unique()->safeEmail,
        'sex'               => $faker->numberBetween($min = 1, $max = 2),
        'description'       => $faker->text,
        'street_address'    => $faker->streetAddress,
        'zip_code'          => $faker->postcode,
        'city'              => $faker->city,
        'home_phone_number' => $faker->phoneNumber,
        'cell_phone_number' => $faker->phoneNumber,
        'image_url'         => $faker->imageUrl($width = 128, $height = 128),
        'color'             => $faker->hexcolor,
        'user_id'           => null
    ];
});
