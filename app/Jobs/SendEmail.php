<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\Reminder as Reminder;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    protected $d;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$d)
    {
        $this->details = $details;
        $this->d = $d;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Reminder($this->d);
        $detail = $this->details['email'];

        Mail::to($this->details['email'])
            ->send($email);
    }
}
