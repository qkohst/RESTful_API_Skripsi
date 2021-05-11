<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileKrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_krs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id_mahasiswa')->unique()->unsigned();
            $table->string('nama_file_krs', 100);
            $table->enum('statuspersetujuan_admin_prodi_file_krs', ['Antrian', 'Disetujui', 'Ditolak']);
            $table->string('catatan_file_krs', 200)->nullable();
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
        Schema::dropIfExists('file_krs');
    }
}
