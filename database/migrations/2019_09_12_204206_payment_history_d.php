<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentHistoryD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_history_d', function ($table) {
            $table->engine = 'innoDB';
            $table->integer('id');
            $table->integer('dt');
            $table->integer('bank');
            $table->string('nominal');
            $table->string('account_name');
            $table->string('image');
            $table->string('date');
            $table->primary(array('id', 'dt'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_history_d');
    }
}
