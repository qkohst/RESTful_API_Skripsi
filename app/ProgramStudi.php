<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';
    protected $fillable = [
        'fakultas_id_fakultas',
        'kode_program_studi',
        'nama_program_studi',
        'singkatan_program_studi',
        'status_program_studi'
    ];

    public function fakultas()
    {
        return $this->belongsTo('App\Fakultas');
    }

    public function mahasiswa()
    {
        return $this->hasMany('App\Mahasiswa');
    }

    public function dosen()
    {
        return $this->hasMany('App\Dosen');
    }
}
