<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adolescents = \App\User::adolescents()->get();

        factory(\App\Plan::class, $adolescents->count())->create()->each(function ($f) use(&$adolescents){
            $f->user()->associate($adolescents->shift());

            $f->save();
        });
    }
}
