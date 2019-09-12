<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItineraryAdditional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itinerary_additional', function ($table) {
            $table->engine = 'innoDB';
            $table->integer('id');
            $table->integer('dt');
            $table->integer('additional_id');
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
        Schema::dropIfExists('itinerary_additional');
    }
}
