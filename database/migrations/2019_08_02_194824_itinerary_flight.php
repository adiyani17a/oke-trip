<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItineraryFlight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itinerary_flight', function ($table) {
            $table->integer('id')->primary();
            $table->integer('dt'); 
            $table->string('flight_number'); 
            $table->string('route'); 
            $table->string('departure'); 
            $table->string('arrival'); 
            $table->string('departure_airport_code'); 
            $table->string('arrival_airport_code'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itinerary_flight');
    }
}
