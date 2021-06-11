<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_client', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_developer_id')->unsigned();
            $table->string('nama_project', 30)->unique();
            $table->enum('platform', ['Mobile', 'Web']);
            $table->string('deskripsi', 250);
            $table->string('api_key', 60)->unique();
            $table->enum('status', ['Aktif', 'Non Aktif']);
            $table->timestamps();

            $table->foreign('user_developer_id')->references('id')->on('user_developer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_client');
    }
}
