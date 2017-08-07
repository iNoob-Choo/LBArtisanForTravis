<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /*
      Change #1 , removed protocol and port
      */
      Schema::create('lb', function (Blueprint $table) {
          $table->increments('id');
          $table->string('ip_address');
          $table->string('provider');
          $table->string('label_name');
          $table->string('location');
          $table->integer('vm_id');
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users');
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
          Schema::dropIfExists('lb');
    }
}
