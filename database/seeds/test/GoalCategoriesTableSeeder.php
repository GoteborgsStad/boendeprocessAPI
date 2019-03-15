<?php

namespace test;
use Illuminate\Database\Seeder;

class GoalCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $goalCategoryNames = [
            'Klara sig själv',
            'Delaktighet',
            'Hälsa',
            'Sysselsättning',
            'Familj och sociala relationer',
            'Personlig utveckling'
        ];

        $goalCategoryDescription = [
            'Mål som syftar till att ungdomen blir självständig och klarar av att sköta ett hushåll.',
            'Mål som syftar till att ungdomen ska delta i de aktiviter som sambuh erbjuder som t.ex. kontaktträffar.',
            'Mål som syftar till att ungdomen ska ta hand om sin hälsa och vara fysiskt aktiv.',
            'Mål som syftar till att ungdomen får meningsfulla saker att göra som arbete, utbildning och en aktiv fritid.',
            'Mål som syftar till att ungdomen bibehåller relationen med sin familj och skapar/bibehåller andra kontakter.',
            'Mål som syftar till att ungdomen ska utvecklas känslo- eller beteendemässigt.'
        ];

        $goalCategoryColors = [
            '#B93342',
            '#F18700',
            '#88CDD0',
            '#B35593',
            '#51AA50',
            '#F2B600'
        ];

        factory(\App\GoalCategory::class, count($goalCategoryNames))->create()->each(function ($f) use(&$goalCategoryNames, &$goalCategoryDescription, &$goalCategoryColors) {
            $f->name        = array_shift($goalCategoryNames);
            $f->description = array_shift($goalCategoryDescription);
            $f->color       = array_shift($goalCategoryColors);

            $f->save();
        });
    }
}
