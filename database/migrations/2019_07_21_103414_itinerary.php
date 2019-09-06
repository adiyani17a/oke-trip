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
            $table->string('highlight');
            $table->text('term_condition');
            $table->text('flight_by');
            $table->string('additional_id'); //related to table additional
            $table->string('carousel_1');
            $table->string('carousel_2');
            $table->string('carousel_3');
            $table->string('note_1');
            $table->string('note_2');
            $table->string('note_3');
            $table->string('pdf');
            $table->string('flayer_image');
            $table->string('summary');
            $table->enum('hot_deals',['Y','N']);
            $table->integer('book_by');
            $table->string('active');
            $table->integer('created_by');
            $table->integer('updated_by');
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
