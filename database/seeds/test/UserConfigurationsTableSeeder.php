<?php

namespace test;
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
        $contacts = \App\User::contacts()->get();

        foreach ($contacts as $key => $contact) {
            $keys   = [
                'email_adolescents_finished_assignment',
                'email_adolescents_sent_message',
                'email_reminder_for_monthly_evaluation',
            ];

            $values = [
                false,
                false,
                false,
            ];

            factory(\App\UserConfiguration::class, count($keys))->create()->each(function ($f) use(&$contact, &$keys, &$values) {
                $f->key     = array_shift($keys);
                $f->value   = array_shift($values);
                $f->user_id = $contact->id;

                $f->save();
            });
        }

        $adolescents = \App\User::adolescents()->get();

        foreach ($adolescents as $key => $adolescent) {
            $keys   = [
                'notification_contact_new_assignment',
                'notification_contact_finished_assignment',
                'notification_contact_new_chat_message',
                'notification_contact_new_evaluation',
                'notification_assignment_end_date_near',
            ];

            $values = [
                false,
                false,
                false,
                false,
                false,
            ];

            factory(\App\UserConfiguration::class, count($keys))->create()->each(function ($f) use(&$adolescent, &$keys, &$values) {
                $f->key     = array_shift($keys);
                $f->value   = array_shift($values);
                $f->user_id = $adolescent->id;

                $f->save();
            });
        }
    }
}
