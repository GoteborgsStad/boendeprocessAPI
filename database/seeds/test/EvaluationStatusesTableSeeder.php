<?php

namespace test;
use Illuminate\Database\Seeder;

class EvaluationStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evaluationStatusNames = [
            'Dags för utvärdering',
            'Genomförda',
        ];

        $evaluationStatusDescription = [
            'Nu ska och kan kontaktpersonen göra månadskollen.',
            'Resultatet från månadskollen skickas ut till ungdommen.',
        ];

        factory(\App\EvaluationStatus::class, count($evaluationStatusNames))->create()->each(function ($f) use(&$evaluationStatusNames, &$evaluationStatusDescription){
            $f->name        = array_shift($evaluationStatusNames);
            $f->description = array_shift($evaluationStatusDescription);
            $f->color       = '#ffffff';

            $f->save();
        });
    }
}
