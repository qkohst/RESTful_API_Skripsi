<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBimbinganProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bimbingan_proposal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_pembimbing_id_dosen_pembimbing')->unsigned();
            $table->string('topik_bimbingan_proposal', 200);
            $table->string('nama_file_bimbingan_proposal', 100);
            $table->enum('status_persetujuan_bimbingan_proposal', ['Antrian', 'Disetujui', 'Revisi']);
            $table->longText('catatan_bimbingan_proposal')->nullable();
            $table->timestamps();

            $table->foreign('dosen_pembimbing_id_dosen_pembimbing')->references('id')->on('dosen_pembimbing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bimbingan_proposal');
    }
}
