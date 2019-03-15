<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Debug\Exception\FatalErrorException;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try
        {
            $data = env('SEED_DATA', null);
            $json = json_decode(file_get_contents(database_path().'/seeds/'.$data.'.json'));

            $this->seedData($data, $json->seeds);
        }
        catch (\Exception $e)
        {
            $message = "ERROR:\n" . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . "\n";
                throw new FatalErrorException(
                    $message . ". \n(Tip: Try 'composer dump-autoload'.)",
                    $e->getCode(),
                    -1,
                    $e->getFile(),
                    $e->getLine(),
                    null,
                    true,
                    $e->getTrace()
                );
        }
    }

    private function seedData($data, Array $seeds)
    {
        foreach ($seeds as $seed)
        {
            $this->call($data . "\\" . $seed);
        }
    }
}
