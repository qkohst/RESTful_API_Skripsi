<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SidangSkripsi extends Model
{
    protected $table = 'sidang_skripsi';
    protected $fillable = [
        'judul_skripsi_id_judul_skripsi',
        'file_sidang_skripsi',
        'persetujuan_pembimbing1_sidang_skripsi',
        'catatan_pembimbing1_sidang_skripsi',
        'persetujuan_pembimbing2_sidang_skripsi',
        'catatan_pembimbing2_sidang_skripsi',
        'waktu_sidang_skripsi',
        'tempat_sidang_skripsi',
        'status_sidang_skripsi',
    ];

    public function judul_skripsi()
    {
        return $this->hasOne('App\JudulSkripsi');
    }
}
