<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class FeedbackCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feedbackCategoryNames = [
            'Security',
            'Service',
            'Contact',
            'Feedback'
        ];

        factory(\App\FeedbackCategory::class, count($feedbackCategoryNames))->create()->each(function ($f) use(&$feedbackCategoryNames) {
            $f->name = array_shift($feedbackCategoryNames);
            $f->color = '#ffffff';

            $f->save();
        });
    }
}
