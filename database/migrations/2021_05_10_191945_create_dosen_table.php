<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id_user')->unique()->unsigned();
            $table->unsignedBigInteger('program_studi_id_program_studi')->unsigned();
            $table->unsignedBigInteger('jabatan_struktural_id_jabatan_struktural')->unsigned()->nullable();
            $table->unsignedBigInteger('jabatan_fungsional_id_jabatan_fungsional')->unsigned()->nullable();
            $table->string('nik_dosen', 16)->unique();
            $table->string('nidn_dosen', 10)->unique();
            $table->string('nip_dosen', 18)->unique()->nullable();
            $table->string('nama_dosen', 50);
            $table->string('tempat_lahir_dosen', 20);
            $table->date('tanggal_lahir_dosen');
            $table->enum('jenis_kelamin_dosen', ['L', 'P']);
            $table->enum('status_perkawinan_dosen', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])->nullable();
            $table->enum('agama_dosen', ['Islam', 'Protestan', 'Katolik', 'Hindu', 'Budha', 'Khonghucu', 'Kepercayaan']);
            $table->string('nama_ibu_dosen', 50)->nullable();
            $table->string('gelar_dosen', 20);
            $table->enum('pendidikan_terakhir_dosen', ['S1', 'S2', 'S3']);
            $table->string('alamat_dosen', 100)->nullable();
            $table->bigInteger('desa_dosen')->nullable();
            $table->bigInteger('kecamatan_dosen')->nullable();
            $table->bigInteger('kabupaten_dosen')->nullable();
            $table->bigInteger('provinsi_dosen')->nullable();
            $table->string('foto_dosen', 100)->nullable();
            $table->string('email_dosen', 45)->unique()->nullable();
            $table->string('no_hp_dosen', 13)->unique()->nullable();
            $table->enum('status_dosen', ['Aktif', 'Non Aktif']);
            $table->timestamps();

            $table->foreign('user_id_user')->references('id')->on('users');
            $table->foreign('program_studi_id_program_studi')->references('id')->on('program_studi');
            $table->foreign('jabatan_struktural_id_jabatan_struktural')->references('id')->on('jabatan_struktural');
            $table->foreign('jabatan_fungsional_id_jabatan_fungsional')->references('id')->on('jabatan_fungsional');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen');
    }
}
