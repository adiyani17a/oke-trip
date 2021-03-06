<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookingD extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_d', function ($table) {
            $table->engine = 'innoDB';
            $table->integer('id');
            $table->integer('dt');
            $table->string('bed');
            $table->integer('total_bed');
            $table->primary(array('id', 'dt'));
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
        Schema::dropIfExists('booking_d');
    }
}
