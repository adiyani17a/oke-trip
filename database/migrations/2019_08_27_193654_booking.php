<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Booking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking', function ($table) {
            $table->engine = 'innoDB';
            $table->integer('id')->primary();
            $table->string('kode');
            $table->integer('users_id');
            $table->string('telp');
            $table->string('itinerary_code');
            $table->enum('status', ['Waiting List', 'Confirm','Cancel']);
            $table->enum('payment_status', ['Waiting For Payment', 'Down Payment','Paid']);
            $table->string('name');
            $table->double('total_adult', 10, 2);
            $table->double('total_child_no_bed', 10, 2);
            $table->double('total_child_with_bed', 10, 2);
            $table->double('total_infant', 10, 2);
            $table->text('remark');
            $table->double('total_additional', 10, 2);
            $table->double('total_room', 10, 2);
            $table->double('tax', 10, 2);
            $table->double('visa', 10, 2);
            $table->double('agent_com', 10, 2);
            $table->double('tips', 10, 2);
            $table->double('total', 10, 2);
            $table->integer('handle_by');
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
        Schema::dropIfExists('booking');
    }
}
