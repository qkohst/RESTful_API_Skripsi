<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJabatanFungsionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jabatan_fungsional', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan_fungsional', 45)->unique();
            $table->text('deskripsi_jabatan_fungsional', 250);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jabatan_fungsional');
    }
}
