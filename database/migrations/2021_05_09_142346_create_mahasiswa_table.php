<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id_user')->unique()->unsigned();
            $table->unsignedBigInteger('program_studi_id_program_studi')->unsigned();
            $table->string('npm_mahasiswa', 10)->unique();
            $table->string('nama_mahasiswa', 50);
            $table->string('tempat_lahir_mahasiswa', 20);
            $table->date('tanggal_lahir_mahasiswa');
            $table->enum('jenis_kelamin_mahasiswa', ['L', 'P']);
            $table->enum('status_perkawinan_mahasiswa', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $table->enum('agama_mahasiswa', ['Islam', 'Protestan', 'Katolik', 'Hindu', 'Budha', 'Khonghucu', 'Kepercayaan']);
            $table->string('nama_ibu_mahasiswa', 50);
            $table->integer('semester_mahasiswa');
            $table->string('alamat_mahasiswa', 100)->nullable();
            $table->string('desa_mahasiswa', 45);
            $table->string('kecamatan_mahasiswa', 45);
            $table->string('kabupaten_mahasiswa', 45);
            $table->string('provinsi_mahasiswa', 45);
            $table->string('foto_mahasiswa', 100)->nullable();
            $table->string('email_mahasiswa', 45)->unique()->nullable();
            $table->string('no_hp_mahasiswa', 13)->unique()->nullable();
            $table->enum('status_mahasiswa', ['Aktif', 'Non Aktif', 'Drop Out', 'Lulus']);
            $table->timestamps();

            $table->foreign('user_id_user')->references('id')->on('users');
            $table->foreign('program_studi_id_program_studi')->references('id')->on('program_studi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
