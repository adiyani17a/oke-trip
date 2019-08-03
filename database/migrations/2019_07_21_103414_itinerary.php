<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Itinerary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itinerary', function ($table) {
            $table->integer('id')->primary();
            $table->string('code')->unique(); 
            $table->string('name'); 
            $table->string('destination_id'); //related to table destination
            $table->string('highlight');
            $table->text('term_condition');
            $table->text('flight_by');
            $table->string('additional_id'); //related to table additional
            $table->string('bg_image');
            $table->string('pdf');
            $table->string('flayer_image');
            $table->text('schedule');
            $table->text('flight_detail');
            $table->integer('book_by');
            $table->string('active');
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::dropIfExists('itinerary');
    }
}