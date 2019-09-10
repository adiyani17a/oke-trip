<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookingAdditional extends Migration
{
    public function up()
    {
        Schema::create('booking_additional', function ($table) {
            $table->engine = 'MyISAM';
            $table->integer('id');
            $table->integer('dt');
            $table->integer('id_booking_pax');
            $table->integer('additional_id');
            $table->timestamps();
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
