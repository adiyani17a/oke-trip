<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Carousel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carousel', function ($table) {
            $table->engine = 'innoDB';
            $table->integer('id')->primary();
            $table->string('carousel_1')->nullable();
            $table->string('carousel_2')->nullable();
            $table->string('carousel_3')->nullable();
            $table->text('note_1');
            $table->text('note_2');
            $table->text('note_3');
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
        Schema::dropIfExists('carousel');
    }
}
