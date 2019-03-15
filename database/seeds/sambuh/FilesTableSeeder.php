<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userDetails = \App\UserDetail::get();

        factory(\App\File::class, $userDetails->count())->create()->each(function ($f) use(&$userDetails) {
            //
        });
    }
}
