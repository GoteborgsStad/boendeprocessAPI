<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class AssignmentFormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assignmentFormNames = [
            'Foto',
            'Text',
            'Bocka av'
        ];

        $assignmentFormDescriptions = [
            'Ett foto behöver bifogas för att uppdraget ska gå att lämna in.',
            'En textbeskrivning behöver bifogas för att uppdraget ska gå att lämna in.',
            'Det räcker att bara bocka av att ett uppdrag är avklarat.'
        ];

        factory(\App\AssignmentForm::class, count($assignmentFormNames))->create()->each(function ($f) use(&$assignmentFormNames, &$assignmentFormDescriptions){
            $f->name        = array_shift($assignmentFormNames);
            $f->description = array_shift($assignmentFormDescriptions);
            $f->color       = '#ffffff';

            $f->save();
        });
    }
}
