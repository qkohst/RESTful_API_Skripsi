<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileKrs extends Model
{
    protected $table = 'file_krs';
    protected $fillable = [
        'mahasiswa_id_mahasiswa',
        'nama_file_krs',
        'statuspersetujuan_admin_prodi_file_krs',
        'catatan_file_krs'
    ];

    public function mahasiswa()
    {
        return $this->hasOne('App\Mahasiswa');
    }
}
