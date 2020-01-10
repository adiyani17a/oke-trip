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
        $control = $this->model->system_control()->find(1);
        if ($control == 'Y') {
            $booking = $this->model->booking()
                            ->whereHas('itinerary_detail',function($q){
                                $q->where('start','>',carbon::now()->format('Y-m-d'));
                            })
                            ->get();

            foreach ($booking as $i => $d) {
                if ($d->total >= $d->payment_history->sum('total_payment')) {
                    $date = (strtotime($d->itinerary_detail->start) - strtotime(carbon::now()->format('Y-m-d')))/86400;
                    if ( $date == 3 ) {
                        $data = ['d'=>$d];
                        Mail::send('email', $data, function ($mail)
                        {
                          // Email dikirimkan ke address "momo@deviluke.com" 
                          // dengan nama penerima "Momo Velia Deviluke"
                          $mail->from('no-reply@oke-trip.com', 'SYSTEM OKE-TRIP');
                          $mail->to('adiyani17a@gmail.com','Adi Wielijarni');
                     
                          // Copy carbon dikirimkan ke address "haruna@sairenji" 
                          // dengan nama penerima "Haruna Sairenji"
                          $mail->subject('Payment Reminder');
                        });
                    }
                }
            }
            return 'Success';
        }else{
            return 'Failure';
        }
    }
}
