<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class UserRelationshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operands = \App\Operand::get();

        foreach ($operands as $key => $operand) {
            $adolescents    = $operand->users()->adolescents()->get();
            $contacts       = $operand->users()->contacts()->get();

            factory(\App\UserRelationship::class, $adolescents->count())->create()->each(function ($f) use(&$adolescents, &$contacts) {
                $f->user()->associate($adolescents->shift());
                $f->parent_id = $contacts->random()->id;

                $f->save();
            });

            factory(\App\UserRelationship::class, $contacts->count())->create()->each(function ($f) use(&$contacts) {
                $f->user()->associate($contacts->shift());
                $f->parent_id = null;

                $f->save();
            });
        }
    }
}
