<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramStudiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_studi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fakultas_id_fakultas')->unsigned();
            $table->integer('kode_program_studi')->unsigned()->unique();
            $table->string('nama_program_studi', 100)->unique();
            $table->string('singkatan_program_studi', 10)->unique();
            $table->enum('status_program_studi', ['Aktif', 'Non Aktif']);
            $table->timestamps();

            $table->foreign('fakultas_id_fakultas')->references('id')->on('fakultas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_studi');
    }
}
