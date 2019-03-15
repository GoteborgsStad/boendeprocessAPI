<?php

namespace sambuh;
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
            $f->start_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $f->end_at = \Carbon\Carbon::now()->addDays(rand(1,20))->format('Y-m-d H:i:s');
            $f->user()->associate($adolescents->random());
            $f->assignmentCategory()->associate($assignmentCategories->random());
            $f->assignmentForm()->associate($assignmentForms->random());
            $f->assignmentStatus()->associate($assignmentStatuses->random());

            $f->save();
        });
    }
}
