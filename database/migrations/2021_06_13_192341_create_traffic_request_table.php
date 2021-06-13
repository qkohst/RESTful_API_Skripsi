<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrafficRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traffic_request', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_client_id')->unsigned();
            $table->enum('status', ['1', '0']);
            $table->timestamps();

            $table->foreign('api_client_id')->references('id')->on('api_client');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traffic_request');
    }
}
