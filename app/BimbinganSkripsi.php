<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BimbinganSkripsi extends Model
{
    protected $table = 'bimbingan_skripsi';
    protected $fillable = [
        'dosen_pembimbing_id_dosen_pembimbing',
        'topik_bimbingan_skripsi',
        'nama_file_bimbingan_skripsi',
        'status_persetujuan_bimbingan_skripsi',
        'catatan_bimbingan_skripsi',
    ];

    public function dosen_pembimbing()
    {
        return $this->belongsTo('App\DosenPembimbing');
    }
}
