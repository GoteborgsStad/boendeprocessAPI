<?php

namespace test;
use Illuminate\Database\Seeder;

class ChatMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chats = \App\Chat::get();

        factory(\App\ChatMessage::class, $chats->count()*50)->create()->each(function ($f) use(&$chats) {
            $chat = $chats->random();

            $f->chat()->associate($chat);
            $f->user()->associate($chat->users()->with('userRole')->get()->random());

            $f->save();
        });
    }
}
