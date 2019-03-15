<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class GoalTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\GoalTemplate::class, 10)->create()->each(function ($f) {
            //
        });
    }
}
