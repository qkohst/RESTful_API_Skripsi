<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSidangSkripsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidang_skripsi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('judul_skripsi_id_judul_skripsi')->unsigned();
            $table->string('file_sidang_skripsi', 100);
            $table->enum('persetujuan_pembimbing1_sidang_skripsi', ['Antrian', 'Disetujui', 'Ditolak']);
            $table->string('catatan_pembimbing1_sidang_skripsi', 200)->nullable();
            $table->enum('persetujuan_pembimbing2_sidang_skripsi', ['Antrian', 'Disetujui', 'Ditolak']);
            $table->string('catatan_pembimbing2_sidang_skripsi', 200)->nullable();
            $table->timestamp('waktu_sidang_skripsi')->nullable();
            $table->string('tempat_sidang_skripsi', 45)->nullable();
            $table->enum('status_sidang_skripsi', ['Pengajuan', 'Proses', 'Selesai']);
            $table->timestamps();

            $table->foreign('judul_skripsi_id_judul_skripsi')->references('id')->on('judul_skripsi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sidang_skripsi');
    }
}
