<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name'); //related to table users
            $table->string('slug');
            $table->unsignedBigInteger('group_menu_id');
            $table->string('url')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
            $table->foreign('group_menu_id')
              ->references('id')->on('group_menu')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_list');
    }
}
