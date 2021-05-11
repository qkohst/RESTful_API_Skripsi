<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JabatanFungsional extends Model
{
    protected $table = 'jabatan_fungsional';
    protected $fillable = [
        'nama_jabatan_fungsional',
        'deskripsi_jabatan_fungsional'
    ];

    public function dosen()
    {
        return $this->hasMany('App\Dosen');
    }
}
