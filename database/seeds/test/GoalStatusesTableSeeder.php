<?php

namespace test;
use Illuminate\Database\Seeder;

class GoalStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $goalStatusNames = [
            'Nytt',
            'I fas',
            'Strax deadline',
            'Deadline',
            'Passerad deadline',
            'Avklarat',
        ];

        $goalStatusDescriptions = [
            'Målet är skapat och ungdommen har inte sett det.',
            'Ungdomen har sett målet och det är långt kvar till deadline.',
            'Mindre än en vecka kvar till deadline och en knopp kommer upp på klätterväxten.',
            'Idag är det deadline.',
            'Deadline för målet har varit och det är inte avklarat.',
            'Kontaktpersonen har markerat målet som avklarat och nu syns det som en blomma på klätterväxten i appen.',
        ];

        $goalStatusColors = [
            '#88CCD0',
            '#88CCD0',
            '#F18700',
            '#F18700',
            '#B93342',
            '#51AA50',
        ];

        factory(\App\GoalStatus::class, count($goalStatusNames))->create()->each(function ($f) use(&$goalStatusNames, &$goalStatusDescriptions, &$goalStatusColors){
            $f->name        = array_shift($goalStatusNames);
            $f->description = array_shift($goalStatusDescriptions);
            $f->color       = array_shift($goalStatusColors);

            $f->save();
        });
    }
}
