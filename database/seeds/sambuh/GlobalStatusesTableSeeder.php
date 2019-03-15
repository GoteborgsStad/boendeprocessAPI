<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class GlobalStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adolescents    = \App\User::adolescents()->get();
        $contacts       = \App\User::contacts()->get();

        foreach ($adolescents as $key => $adolescent) {
            foreach ($contacts as $key => $contact) {
                $keys   = [
                    'new_message_amount_from_adolescent',
                    'new_message_amount_from_contact',
                    'done_assignment_amount_from_adolescent',
                    'new_assignment_amount_from_contact',
                ];

                $values = [
                    0,
                    0,
                    0,
                    0,
                ];

                factory(\App\GlobalStatus::class, count($keys))->create()->each(function ($f) use(&$adolescent, &$contact, &$keys, &$values) {
                    $f->key     = array_shift($keys);
                    $f->value   = array_shift($values);

                    $f->save();

                    $adolescent->globalStatuses()->attach($f->id);
                    $contact->globalStatuses()->attach($f->id);
                });
            }
        }
    }
}
