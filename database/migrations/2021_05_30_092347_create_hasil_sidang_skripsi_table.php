<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilSidangSkripsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_sidang_skripsi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sidang_skripsi_id_sidang')->unsigned();
            $table->unsignedBigInteger('dosen_id_dosen')->unsigned();
            $table->enum('jenis_dosen_hasil_sidang_skripsi', ['Pembimbing 1', 'Pembimbing 2', 'Penguji 1', 'Penguji 2']);
            $table->enum('status_verifikasi_hasil_sidang_skripsi', ['Revisi', 'Lulus Sidang']);
            $table->longText('catatan_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_a1_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_a2_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_a3_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_b1_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_b2_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_b3_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_b4_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_b5_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_b6_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_b7_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_c1_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_c2_hasil_sidang_skripsi')->nullable();
            $table->integer('nilai_c3_hasil_sidang_skripsi')->nullable();
            $table->timestamps();

            $table->foreign('sidang_skripsi_id_sidang')->references('id')->on('sidang_skripsi');
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
        Schema::dropIfExists('hasil_sidang_skripsi');
    }
}
