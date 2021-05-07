<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id_user')->unique()->unsigned();
            $table->string('nik_admin', 16)->unique();
            $table->string('nidn_admin', 10)->unique();
            $table->string('nip_admin', 18)->unique()->nullable();
            $table->string('nama_admin', 50);
            $table->string('tempat_lahir_admin', 20);
            $table->date('tanggal_lahir_admin');
            $table->enum('jenis_kelamin_admin', ['L', 'P']);
            $table->string('foto_admin', 100)->nullable();
            $table->string('email_admin', 45)->unique();
            $table->string('no_hp_admin', 13)->unique();
            $table->enum('status_admin', ['Aktif', 'Non Aktif']);
            $table->timestamps();

            $table->foreign('user_id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
