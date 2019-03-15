<?php

namespace test;
use Illuminate\Database\Seeder;

class GoalTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Hälsa',
            'Hälsa',
            'Klara sig själv',
            'Klara sig själv',
            'Klara sig själv',
            'Sysselsättning',
            'Klara sig själv',
            'Klara sig själv',
            'Klara sig själv',
            'Hälsa',
            'Hälsa',
            'Utbildning',
            'Sysselsättning',
            'Personlig utveckling',
            'Personlig utveckling',
            'Familj och sociala relationer',
            'Klara sig själv',
            'Personlig utveckling',
            'Delaktighet',
            'Delaktighet',
            'Delaktighet'
        ];

        $names = [
            'Hälsoundersökning',
            'Regelbunden fritid',
            'Kosthållning/planering',
            'Lägenhetsunderhåll',
            'Sök x antal lägenheter på Boplats',
            'Transport',
            'Skriv ett personligt brev',
            'Ansök om ekonomiskt bistånd',
            'Skaffa en slutskattesedel',
            'Brandsäkerhet',
            'Kosthållning',
            'Hälsofrämjande självbild',
            'Gör en skoluppgift',
            'Sök jobb',
            'Självbild',
            'Självbild/identitet',
            'Umgänge',
            'Gör en månadsbudget',
        ];

        $description = [

        ];

        factory(\App\GoalTemplate::class, 10)->create()->each(function ($f) {
            //
        });
    }
}
