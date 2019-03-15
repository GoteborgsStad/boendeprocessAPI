<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class FaqCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faqCategoryNames = [
            'Security',
            'Service',
            'Contact',
            'Feedback'
        ];

        factory(\App\FaqCategory::class, count($faqCategoryNames))->create()->each(function ($f) use(&$faqCategoryNames) {
            $f->name = array_shift($faqCategoryNames);
            $f->color = '#ffffff';

            $f->save();
        });
    }
}
