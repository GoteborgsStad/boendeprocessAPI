<?php

namespace test;
use Illuminate\Database\Seeder;

class UserDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::get();

        factory(\App\UserDetail::class, $users->count())->create()->each(function ($f) use(&$users) {
            $f->user_id = $users->shift()->id;

            $f->save();
        });
    }
}
