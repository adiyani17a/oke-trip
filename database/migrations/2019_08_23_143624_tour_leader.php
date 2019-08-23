<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TourLeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_leader', function ($table) {
            $table->integer('id')->primary();
            $table->string('name'); 
            $table->string('address'); 
            $table->string('phone'); 
            $table->string('passport'); 
            $table->date('passport_exp_date'); 
            $table->string('issuing'); 
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date'); 
            $table->string('birth_place'); 
            $table->string('image'); 
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
        Schema::dropIfExists('tour_leader');
    }
}
