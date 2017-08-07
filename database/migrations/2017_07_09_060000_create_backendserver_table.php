<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackendserverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('backend_servers', function (Blueprint $table) {
          $table->increments('id');
          $table->string('ip_address');
          $table->string('server_label_name');
          $table->integer('port_no');
          $table->integer('user_id');
          $table->integer('frontend_id')->unsigned();
          $table->foreign('frontend_id')->references('id')->on('frontendserver');
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
        Schema::dropIfExists('backend_servers');
    }
}
