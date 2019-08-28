<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookingAdditional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_additional', function ($table) {
            $table->engine = 'MyISAM';
            $table->integer('id');
            $table->integer('id_booking_d');
            $table->integer('dt');
            $table->integer('additional_id');
            $table->primary(array('id', 'dt','id_booking_d'));
            $table->foreign('id')
                  ->references('id')->on('booking')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_additional');
    }
}
