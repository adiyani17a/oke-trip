<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItinerarySchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itinerary_schedule', function ($table) {
            $table->integer('id')->primary();
            $table->integer('dt'); 
            $table->text('caption'); 
            $table->string('title'); 
            $table->string('eat_service'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('itinerary_schedule');
    }
}
