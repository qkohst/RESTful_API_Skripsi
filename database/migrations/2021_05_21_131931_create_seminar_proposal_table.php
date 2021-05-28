<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeminarProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seminar_proposal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('judul_skripsi_id_judul_skripsi')->unsigned();
            $table->string('file_seminar_proposal', 100);
            $table->enum('persetujuan_pembimbing1_seminar_proposal', ['Antrian', 'Disetujui', 'Ditolak']);
            $table->string('catatan_pembimbing1_seminar_proposal', 200)->nullable();
            $table->enum('persetujuan_pembimbing2_seminar_proposal', ['Antrian', 'Disetujui', 'Ditolak']);
            $table->string('catatan_pembimbing2_seminar_proposal', 200)->nullable();
            $table->timestamp('waktu_seminar_proposal')->nullable();
            $table->string('tempat_seminar_proposal', 45)->nullable();
            $table->enum('status_seminar_proposal', ['Pengajuan', 'Proses', 'Selesai']);
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
        Schema::dropIfExists('seminar_proposal');
    }
}
