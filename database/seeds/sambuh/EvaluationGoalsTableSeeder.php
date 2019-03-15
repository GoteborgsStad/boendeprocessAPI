<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class EvaluationGoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\EvaluationGoal::class, 8)->create()->each(function ($f) {
            //
        });
    }
}
