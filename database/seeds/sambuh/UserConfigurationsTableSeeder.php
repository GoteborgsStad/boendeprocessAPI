<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class UserConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::get();

        foreach ($users as $key => $user) {
            $keys   = [
                'email_adolescents_finished_assignment',
                'email_adolescents_sent_message',
                'email_reminder_for_monthly_evaluation'
            ];
            $values = [true,true,true];

            factory(\App\UserConfiguration::class, count($keys))->create()->each(function ($f) use(&$user, &$keys, &$values) {
                $f->key     = array_shift($keys);
                $f->value   = array_shift($values);
                $f->user_id = $user->id;

                $f->save();
            });
        }
    }
}
