<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Faq::class, function (Faker $faker) {
    return [
        'name'              => $faker->name,
        'description'       => $faker->text,
        'color'             => $faker->hexcolor,
        'faq_category_id'   => 1,
        'operand_id'        => 1,
        'user_id'           => 1
    ];
});
