<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class EvaluationAnswerCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evaluationAnswerCategories = [
            'Boende',
            'Delaktighet',
            'Uppdrag',
        ];

        $evaluationAnswerCategoryTypes = [
            'housing',
            'participation',
            'assignment',
        ];

        factory(\App\EvaluationAnswerCategory::class, count($evaluationAnswerCategories))->create()->each(function ($f) use(&$evaluationAnswerCategories, &$evaluationAnswerCategoryTypes) {
            $f->name = array_shift($evaluationAnswerCategories);
            $f->type = array_shift($evaluationAnswerCategoryTypes);

            $f->save();
        });
    }
}
