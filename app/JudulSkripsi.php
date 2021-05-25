<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JudulSkripsi extends Model
{
    protected $table = 'judul_skripsi';
    protected $fillable = [
        'mahasiswa_id_mahasiswa',
        'nama_judul_skripsi',
    ];

    public function mahasiswa()
    {
        return $this->hasOne('App\Mahasiswa');
    }

    public function dosen_pembimbing()
    {
        return $this->hasMany('App\DosenPembimbing');
    }

    public function dosen_penguji()
    {
        return $this->hasMany('App\DosenPenguji');
    }

    public function seminar_proposal()
    {
        return $this->belongsTo('App\SeminarProposal');
    }
}
