<?php

namespace test;
use Illuminate\Database\Seeder;

class AssignmentStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assignmentStatusNames = [
            'Nytt',
            'I fas',
            'Strax deadline',
            'Deadline',
            'Passerad deadline',
            'Inväntar godkännande',
            'Avslutat uppdrag'
        ];

        $assignmentStatusDescriptions = [
            'Ett nytt uppdrag som ungdommen ännu inte tittat på.',
            'Det är gott om tid kvar till deadline. ',
            'Imogon/idag är det deadline.',
            'Idag är det deadline.',
            'Deadline för uppdraget har varit och det är inte avklarat.',
            'Uppdrag som ungdommen har klarat av men som kontktpersonen ännu inte godkänt.',
            'Uppdrag som ungdommen har klarat av och som är godkända.'
        ];

        $assignmentStatusColors = [
            '#88CCD0',
            '#88CCD0',
            '#F18700',
            '#F18700',
            '#B93342',
            '#F18700',
            '#51AA50',
        ];

        factory(\App\AssignmentStatus::class, count($assignmentStatusNames))->create()->each(function ($f) use(&$assignmentStatusNames, &$assignmentStatusDescriptions, &$assignmentStatusColors) {
            $f->name        = array_shift($assignmentStatusNames);
            $f->description = array_shift($assignmentStatusDescriptions);
            $f->color       = array_shift($assignmentStatusColors);

            $f->save();
        });
    }
}
