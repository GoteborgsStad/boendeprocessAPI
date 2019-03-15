<?php

namespace sambuh;
use Illuminate\Database\Seeder;

class ChatMessageStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chatMessageStatusNames         = ['Nytt', 'Läst'];
        $chatMessageStatusDescriptions  = ['Ett nytt oläst meddelande', 'Alla meddelanden är lästa'];

        factory(\App\ChatMessageStatus::class, count($chatMessageStatusNames))->create()->each(function ($f) use(&$chatMessageStatusNames, &$chatMessageStatusDescriptions) {
            $f->name        = array_shift($chatMessageStatusNames);
            $f->description = array_shift($chatMessageStatusDescriptions);

            $f->save();
        });
    }
}
