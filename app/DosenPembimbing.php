<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DosenPembimbing extends Model
{
    protected $table = 'dosen_pembimbing';
    protected $fillable = [
        'judul_skripsi_id_judul_skripsi',
        'dosen_id_dosen',
        'jabatan_dosen_pembimbing',
        'persetujuan_dosen_pembimbing',
        'catatan_dosen_pembimbing',
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
