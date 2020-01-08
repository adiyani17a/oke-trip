<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use \App\models;
use \App\booking;
class SendUserEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $model;
    protected $signature = 'notification:sendEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Email To User Who Still Have Payment To Be Pay';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->model = new models();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [];
        $booking = $this->model->booking()
                        ->whereHas('payment_history' => function($q){
                            $q->where(DB::raw(""))
                        })
                        ->get();
        Mail::send('email', $data, function ($mail)
        {
          // Email dikirimkan ke address "momo@deviluke.com" 
          // dengan nama penerima "Momo Velia Deviluke"
          $mail->from('contact@oke-trip.com', 'SYSTEM OKE-TRIP');
          $mail->to('dewa17a@gmail.com','Adi Wielijarni');
     
          // Copy carbon dikirimkan ke address "haruna@sairenji" 
          // dengan nama penerima "Haruna Sairenji"
          $mail->subject('Payment Reminder');
        });

        $this->model->tes()->create(['id'=>'1']);
    }
}
