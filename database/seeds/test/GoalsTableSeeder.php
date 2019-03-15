<?php

namespace test;
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
        $goalStatuses   = \App\GoalStatus::get();

        $now = \Carbon\Carbon::now();

        for ($i=0; $i < $plans->count()*20; $i++) { 
            $now = $now->subDays(3);

            factory(\App\Goal::class, 1)->create()->each(function ($f) use(&$plans, &$goalCategories, &$goalStatuses, &$now) {
                $f->plan()->associate($plans->random());
                $f->goalCategory()->associate($goalCategories->random());
                $f->goalStatus()->associate($goalStatuses->random());

                if ($f->goalStatus->name === 'Avklarat') {
                    $f->finished_at = $now;
                }

                $f->save();
            });
        }
    }
}
