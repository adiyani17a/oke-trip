<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Reminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $d;

    public function __construct($d)
    {
        $this->d = $d;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $d = $this->d;
        return $this->view('email',compact('d'));
    }
}
