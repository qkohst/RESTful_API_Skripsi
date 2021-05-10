<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $fillable = [
        'user_id_user',
        'program_studi_id_program_studi',
        'npm_mahasiswa',
        'nama_mahasiswa',
        'tempat_lahir_mahasiswa',
        'tanggal_lahir_mahasiswa',
        'jenis_kelamin_mahasiswa',
        'status_perkawinan_mahasiswa',
        'agama_mahasiswa',
        'nama_ibu_mahasiswa',
        'semester_mahasiswa',
        'alamat_mahasiswa',
        'desa_mahasiswa',
        'kecamatan_mahasiswa',
        'kabupaten_mahasiswa',
        'provinsi_mahasiswa',
        'foto_mahasiswa',
        'email_mahasiswa',
        'no_hp_mahasiswa',
        'status_mahasiswa'
    ];

    public function program_studi()
    {
        return $this->belongsTo('App\ProgramStudi');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
