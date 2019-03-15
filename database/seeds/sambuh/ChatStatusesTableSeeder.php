<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class ChatStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\ChatStatus::class, 5)->create()->each(function ($f) {
            //
        });
    }
}
