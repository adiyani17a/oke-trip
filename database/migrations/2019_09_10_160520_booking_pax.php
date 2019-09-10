<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookingPax extends Migration
{
    public function up()
    {
        Schema::create('booking_pax', function ($table) {
            $table->engine = 'MyISAM';
            $table->integer('id');
            $table->integer('dt');
            $table->integer('id_booking_d');
            $table->string('name');
            $table->string('passport');
            $table->string('exp_date');
            $table->string('issuing');
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->text('remark');
            $table->string('passport_image');
            $table->string('type');
            $table->primary(array('id', 'dt','id_booking_d'));
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
        Schema::dropIfExists('booking_pax');
    }
}
