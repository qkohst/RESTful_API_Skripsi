<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJudulSkripsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judul_skripsi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id_mahasiswa')->unique()->unsigned();
            $table->string('nama_judul_skripsi', 200)->unique();
            $table->timestamps();

            $table->foreign('mahasiswa_id_mahasiswa')->references('id')->on('mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('judul_skripsi');
    }
}
