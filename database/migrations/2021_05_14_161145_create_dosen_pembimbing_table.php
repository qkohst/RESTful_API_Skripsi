<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenPembimbingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_pembimbing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('judul_skripsi_id_judul_skripsi')->unsigned();
            $table->unsignedBigInteger('dosen_id_dosen')->unsigned();
            $table->enum('jabatan_dosen_pembimbing', ['1', '2']);
            $table->enum('persetujuan_dosen_pembimbing', ['Antrian', 'Disetujui', 'Ditolak']);
            $table->string('catatan_dosen_pembimbing', 200)->nullable();
            $table->timestamps();

            $table->foreign('judul_skripsi_id_judul_skripsi')->references('id')->on('judul_skripsi');
            $table->foreign('dosen_id_dosen')->references('id')->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen_pembimbing');
    }
}
