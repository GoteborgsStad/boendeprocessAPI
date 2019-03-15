<?php

namespace test;
use Illuminate\Database\Seeder;

class FeedbackTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feedbackCategories = \App\FeedbackCategory::get();

        factory(\App\Feedback::class, $feedbackCategories->count()*5)->create()->each(function ($f) use(&$feedbackCategories) {
            $f->feedback_category_id = $feedbackCategories->random()->id;
            $f->color = '#ffffff';

            $f->save();
        });
    }
}
