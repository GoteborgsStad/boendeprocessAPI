<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 120;

    protected $recipientAddress;
    protected $recipientName;
    protected $subject;
    protected $view;
    protected $parameters;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipientAddress, $recipientName, $subject, $view, $parameters)
    {
        $this->recipientAddress = $recipientAddress;
        $this->recipientName = $recipientName;
        $this->subject = $subject;
        $this->view = $view;
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sendMail(
            $this->recipientAddress,
            $this->recipientName,
            $this->subject,
            $this->view,
            $this->parameters
        );
    }
}
