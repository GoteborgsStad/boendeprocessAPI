<?php

namespace test;
use Illuminate\Database\Seeder;

class AssignmentTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assignmentCategories   = \App\AssignmentCategory::get();
        $assignmentForms        = \App\AssignmentForm::get();
        $assignmentStatuses     = \App\AssignmentStatus::get();

        factory(\App\AssignmentTemplate::class, 10)->create()->each(function ($f) use(&$assignmentCategories, &$assignmentForms, &$assignmentStatuses) {
            $f->assignmentCategory()->associate($assignmentCategories->random());
            $f->assignmentForms()->attach($assignmentForms->random()->id);
            $f->assignmentStatus()->associate($assignmentStatuses->random());

            $f->save();
        });
    }
}
