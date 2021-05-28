<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilSeminarProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_seminar_proposal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seminar_proposal_id_seminar')->unsigned();
            $table->unsignedBigInteger('dosen_id_dosen')->unsigned();
            $table->enum('jenis_dosen_hasil_seminar_proposal', ['Pembimbing 1', 'Pembimbing 2', 'Penguji 1', 'Penguji 2']);
            $table->enum('status_verifikasi_hasil_seminar_proposal', ['Revisi', 'Lulus Seminar']);
            $table->longText('catatan_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_a1_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_a2_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_a3_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_b1_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_b2_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_b3_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_b4_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_b5_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_b6_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_b7_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_c1_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_c2_hasil_seminar_proposal')->nullable();
            $table->integer('nilai_c3_hasil_seminar_proposal')->nullable();
            $table->timestamps();

            $table->foreign('seminar_proposal_id_seminar')->references('id')->on('seminar_proposal');
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
        Schema::dropIfExists('hasil_seminar_proposal');
    }
}
