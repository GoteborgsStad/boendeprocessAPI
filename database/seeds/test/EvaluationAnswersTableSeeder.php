<?php

namespace test;
use Illuminate\Database\Seeder;

class EvaluationAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evaluations = \App\Evaluation::get()->shuffle();

        foreach ($evaluations as $key => $evaluation) {
            $evaluationAnswerCategories = \App\EvaluationAnswerCategory::get();

            if (rand(0,1)) {
                factory(\App\EvaluationAnswer::class, $evaluationAnswerCategories->count())->create()->each(function ($f) use(&$evaluation, $evaluationAnswerCategories) {
                    $f->evaluation()->associate($evaluation);

                    $evaluation->evaluation_status_id = 2;
                    $evaluation->save();

                    $f->evaluationAnswerCategory()->associate($evaluationAnswerCategories->shift());

                    $f->save();
                });
            }
        }
    }
}
