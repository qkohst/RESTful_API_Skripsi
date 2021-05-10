<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminProdiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_prodi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id_user')->unique()->unsigned();
            $table->unsignedBigInteger('program_studi_id_program_studi')->unsigned();
            $table->string('nik_admin_prodi', 16)->unique();
            $table->string('nidn_admin_prodi', 10)->unique();
            $table->string('nip_admin_prodi', 18)->unique()->nullable();
            $table->string('nama_admin_prodi', 50);
            $table->string('tempat_lahir_admin_prodi', 20);
            $table->date('tanggal_lahir_admin_prodi');
            $table->enum('jenis_kelamin_admin_prodi', ['L', 'P']);
            $table->string('foto_admin_prodi', 100)->nullable();
            $table->string('no_surat_tugas_admin_prodi', 45)->unique();
            $table->string('email_admin_prodi', 45)->unique();
            $table->string('no_hp_admin_prodi', 13)->unique();
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
        Schema::dropIfExists('admin_prodi');
    }
}
