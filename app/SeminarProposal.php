<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeminarProposal extends Model
{
    protected $table = 'seminar_proposal';
    protected $fillable = [
        'judul_skripsi_id_judul_skripsi',
        'file_seminar_proposal',
        'persetujuan_pembimbing1_seminar_proposal',
        'catatan_pembimbing1_seminar_proposal',
        'persetujuan_pembimbing2_seminar_proposal',
        'catatan_pembimbing2_seminar_proposal',
        'waktu_seminar_proposal',
        'tempat_seminar_proposal',
        'status_seminar_proposal',
    ];

    public function judul_skripsi()
    {
        return $this->hasOne('App\JudulSkripsi');
    }

    public function hasil_seminar_proposal()
    {
        return $this->hasMany('App\HasilSeminarProposal');
    }
}
