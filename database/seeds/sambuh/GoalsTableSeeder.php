<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class GoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans          = \App\Plan::get();
        $goalCategories = \App\GoalCategory::get();

        factory(\App\Goal::class, $plans->count()*20)->create()->each(function ($f) use(&$plans, &$goalCategories) {
            $f->plan()->associate($plans->random());
            $f->goalCategory()->associate($goalCategories->random());

            $f->save();
        });
    }
}
