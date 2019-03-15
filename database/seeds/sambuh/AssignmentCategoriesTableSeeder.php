<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class AssignmentCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assignmentCategoryNames = [
            'Klara sig själv',
            'Delaktighet',
            'Hälsa',
            'Sysselsättning',
            'Familj och sociala relationer'
        ];

        $assignmentCategoryDescriptions = [
            'Uppdrag som syftar till att ungdomen blir självständig och klarar av att sköta ett hushåll.',
            'Uppdrag som syftar till att ungdomen ska delta i de aktiviter som sambuh erbjuder som t.ex. kontaktträffar.',
            'Uppdrag som syftar till att ungdomen ska ta hand om sin hälsa och vara fysiskt aktiv.',
            'Uppdrag som syftar till att ungdomen får meningsfulla saker att göra som arbete, utbildning och en aktiv fritid.',
            'Uppdrag som syftar till att ungdomen bibehåller relationen med sin familj och skapar/bibehåller andra kontakter.'
        ];

        factory(\App\AssignmentCategory::class, count($assignmentCategoryNames))->create()->each(function ($f) use(&$assignmentCategoryNames, &$assignmentCategoryDescriptions) {
            $f->name        = array_shift($assignmentCategoryNames);
            $f->description = array_shift($assignmentCategoryDescriptions);
            $f->color       = '#ffffff';

            $f->save();
        });
    }
}
