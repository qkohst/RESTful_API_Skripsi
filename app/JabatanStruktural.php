<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JabatanStruktural extends Model
{
    protected $table = 'jabatan_struktural';
    protected $fillable = [
        'nama_jabatan_struktural',
        'deskripsi_jabatan_struktural'
    ];

    public function dosen()
    {
        return $this->hasMany('App\Dosen');
    }
}
