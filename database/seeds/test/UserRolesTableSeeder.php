<?php

namespace test;
use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleNames = ['CU', 'AU'];
        $roleDescriptions = ['Contact User', 'Adolescent User'];

        factory(\App\UserRole::class, count($roleNames))->create()->each(function ($f) use(&$roleNames, &$roleDescriptions) {
            $f->name = array_shift($roleNames);
            $f->description = array_shift($roleDescriptions);
            $f->color = '#ffffff';

            $f->save();
        });
    }
}
