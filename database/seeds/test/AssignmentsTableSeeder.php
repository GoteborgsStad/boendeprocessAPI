<?php

namespace test;
use Illuminate\Database\Seeder;

class AssignmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adolescents            = \App\User::adolescents()->get();
        $assignmentCategories   = \App\AssignmentCategory::get();
        $assignmentForms        = \App\AssignmentForm::get();
        $assignmentStatuses     = \App\AssignmentStatus::get();

        factory(\App\Assignment::class, 50)->create()->each(function ($f) use(&$adolescents, &$assignmentCategories, &$assignmentForms, &$assignmentStatuses) {
            (rand(0,1)) ? $f->start_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s'): $f->start_at = null;

            $f->end_at = \Carbon\Carbon::now()->addDays(rand(0,20));

            (rand(0,1)) ? $f->accepted_at = \Carbon\Carbon::now()->addDays(rand(1,20)): $f->accepted_at = null;
            (rand(0,1)) ? $f->finished_at = $f->accepted_at: $f->finished_at = null;

            if (!is_null($f->finished_at) && !is_null($f->accepted_at)) {
                $f->assignmentStatus()->associate($assignmentStatuses->where('name', 'Avslutat uppdrag')->first());
            } else if(!is_null($f->accepted_at) && is_null($f->finished_at)) {
                $f->assignmentStatus()->associate($assignmentStatuses->where('name', 'Inväntar godkännande')->first());
            } else if (is_null($f->finished_at) && is_null($f->accepted_at)) {
                if (\Carbon\Carbon::now()->diffInDays($f->end_at) <= 2 && $f->end_at > \Carbon\Carbon::now()) {
                    $f->assignmentStatus()->associate($assignmentStatuses->where('name', 'Strax deadline')->first());
                } else if (\Carbon\Carbon::now()->diffInDays($f->end_at) === 0) {
                    $f->assignmentStatus()->associate($assignmentStatuses->where('name', 'Deadline')->first());
                } else {
                    $f->assignmentStatus()->associate($assignmentStatuses->where('name', 'I fas')->first());
                }
            }

            $f->user()->associate($adolescents->random());
            $f->assignmentCategory()->associate($assignmentCategories->random());

            $f->assignmentForms()->attach($assignmentForms->random()->id);

            $f->save();
        });
    }
}
