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
            $table->engine = 'MyISAM';
            $table->integer('id');
            $table->integer('dt');
            $table->string('bed');
            $table->integer('name');
            $table->integer('passport');
            $table->string('exp_date');
            $table->integer('issuing');
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->integer('room');
            $table->text('reference');
            $table->text('status_person');
            $table->string('image');
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
