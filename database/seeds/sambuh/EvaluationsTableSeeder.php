<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class EvaluationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) {
            $adolescents = \App\User::adolescents()->get();

            $timestamp = \Carbon\Carbon::now()->subMonth($i);

            factory(\App\Evaluation::class, $adolescents->count())->create()->each(function ($f) use(&$adolescents, &$timestamp) {
                $f->user()->associate($adolescents->shift());
                $f->created_at = $timestamp;
                $f->updated_at = $timestamp;

                $f->save();
            });
        }
    }
}
