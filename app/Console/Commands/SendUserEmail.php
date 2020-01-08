<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use \App\models;
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
        $this->model->tes()->create(['id'=>'1'])
    }
}
