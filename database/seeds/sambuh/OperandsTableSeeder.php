<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class OperandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operandNames = ['Hisingen', 'Sambuh'];
        $operandDescriptions = [];

        factory(\App\Operand::class, count($operandNames))->create()->each(function ($f) use(&$operandNames) {
            $f->name = array_shift($operandNames);
            $f->color = '#ffffff';

            $f->save();
        });
    }
}
