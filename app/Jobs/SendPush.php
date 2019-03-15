<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPush implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 120;

    public $scheduledTime;
    public $title;
    public $subtitle;
    public $text;
    public $ticker;
    public $users;
    public $services;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title, $subtitle, $text, $scheduledTime, $ticker, $users, $services)
    {
        $this->title            = $title;
        $this->subtitle         = $subtitle;
        $this->text             = $text;
        $this->scheduledTime    = $scheduledTime;
        $this->ticker           = $ticker;
        $this->users            = $users;
        $this->services         = $services;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return sendPush(
            $this->title,
            $this->subtitle,
            $this->text,
            $this->scheduledTime,
            $this->ticker,
            $this->users,
            $this->services
        );
    }
}
