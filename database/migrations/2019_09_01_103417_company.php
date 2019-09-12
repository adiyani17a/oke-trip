<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Company extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function ($table) {
            $table->engine = 'innoDB';
            $table->integer('id')->primary();
            $table->string('name'); 
            $table->string('address'); 
            $table->string('phone'); 
            $table->string('email'); 
            $table->integer('city_id'); 
            $table->string('image'); 
            $table->string('active')->nullable(); 
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
        Schema::dropIfExists('company');
    }
}
