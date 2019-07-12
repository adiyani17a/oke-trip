<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Additional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional', function ($table) {
            $table->bigIncrements('id');
            $table->string('name'); //related to table users
            $table->string('note')->default('-');
            $table->string('image')->nullable();
            $table->double('price', 10, 2);
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('active');
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
        Schema::dropIfExists('additional');
    }
}
