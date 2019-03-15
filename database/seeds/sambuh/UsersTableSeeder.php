<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operands = \App\Operand::get();
        $CUpersonalIdentityNumbers = ['9305265112', '9405265112'];
        $AUpersonalIdentityNumbers = ['9505265112'];

        factory(\App\User::class, 10)->create()->each(function ($f) use(&$operands) {
            $f->password = bcrypt('secret');

            $f->operands()->attach($operands->random()->id);

            $f->save();
        });

        factory(\App\User::class, 2)->create()->each(function ($f) use(&$operands, &$CUpersonalIdentityNumbers) {
            $f->personal_identity_number    = array_shift($CUpersonalIdentityNumbers);
            $f->password                    = bcrypt('secret');
            $f->user_role_id                = 1;

            $f->operands()->attach($operands->shift()->id);

            $f->save();
        });

        $operands = \App\Operand::get();

        factory(\App\User::class, 1)->create()->each(function ($f) use(&$operands, &$AUpersonalIdentityNumbers) {
            $f->personal_identity_number    = array_shift($AUpersonalIdentityNumbers);
            $f->password                    = bcrypt('secret');
            $f->user_role_id                = 2;

            $f->operands()->attach($operands->random()->id);

            $f->save();
        });
    }
}
