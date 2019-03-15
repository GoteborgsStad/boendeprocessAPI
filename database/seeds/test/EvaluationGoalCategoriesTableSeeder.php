<?php

namespace test;
use Illuminate\Database\Seeder;

class EvaluationGoalCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\EvaluationGoalCategory::class, 5)->create()->each(function ($f) {
            //
        });
    }
}
