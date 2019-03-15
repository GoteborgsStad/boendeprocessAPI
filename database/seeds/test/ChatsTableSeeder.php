<?php

namespace test;
use Illuminate\Database\Seeder;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRelationships = \App\UserRelationship::where('parent_id', '!=', 'null')->with(['parent', 'user'])->get();

        factory(\App\Chat::class, $userRelationships->count())->create()->each(function ($f) use(&$userRelationships) {
            $userRelationship = $userRelationships->shift();

            $f->users()->attach($userRelationship->user->id);
            $f->users()->attach($userRelationship->parent->id);
        });
    }
}
