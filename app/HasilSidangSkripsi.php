<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilSidangSkripsi extends Model
{
    protected $table = 'hasil_sidang_skripsi';
    protected $fillable = [
        'sidang_skripsi_id_sidang',
        'dosen_id_dosen',
        'jenis_dosen_hasil_sidang_skripsi',
        'status_verifikasi_hasil_sidang_skripsi',
        'catatan_hasil_sidang_skripsi',
        'nilai_a1_hasil_sidang_skripsi',
        'nilai_a2_hasil_sidang_skripsi',
        'nilai_a3_hasil_sidang_skripsi',
        'nilai_b1_hasil_sidang_skripsi',
        'nilai_b2_hasil_sidang_skripsi',
        'nilai_b3_hasil_sidang_skripsi',
        'nilai_b4_hasil_sidang_skripsi',
        'nilai_b5_hasil_sidang_skripsi',
        'nilai_b6_hasil_sidang_skripsi',
        'nilai_b7_hasil_sidang_skripsi',
        'nilai_c1_hasil_sidang_skripsi',
        'nilai_c2_hasil_sidang_skripsi',
        'nilai_c3_hasil_sidang_skripsi',
    ];

    public function sidang_skripsi()
    {
        return $this->belongsTo('App\SidangSkripsi');
    }

    public function dosen()
    {
        return $this->belongsTo('App\Dosen');
    }
}
