<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontendserverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /*
      Change #1 removed lavel name ,ip & added protocol
      */
      Schema::create('frontend_servers', function (Blueprint $table) {
          $table->increments('id');
          $table->string('protocol');
          $table->integer('port_no');
          $table->integer('user_id');
          $table->integer('lb_id')->unsigned();
          $table->foreign('lb_id')->references('id')->on('lb');
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
        Schema::dropIfExists('frontend_servers');
    }
}
