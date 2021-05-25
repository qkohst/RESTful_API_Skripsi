<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DosenPenguji extends Model
{
    protected $table = 'dosen_penguji';
    protected $fillable = [
        'judul_skripsi_id_judul_skripsi',
        'dosen_id_dosen',
        'jabatan_dosen_penguji',
        'persetujuan_dosen_penguji',
    ];

    public function judul_skripsi()
    {
        return $this->belongsTo('App\JudulSkripsi');
    }

    public function dosen()
    {
        return $this->belongsTo('App\Dosen');
    }
}
