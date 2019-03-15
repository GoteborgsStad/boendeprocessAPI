<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\ChatMessage::class, function (Faker $faker) {
    return [
        'body'                      => $faker->text,
        'chat_id'                   => 1,
        'chat_message_status_id'    => 1,
        'user_id'                   => 1
    ];
});
