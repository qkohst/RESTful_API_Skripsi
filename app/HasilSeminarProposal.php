<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilSeminarProposal extends Model
{
    protected $table = 'hasil_seminar_proposal';
    protected $fillable = [
        'seminar_proposal_id_seminar',
        'dosen_id_dosen',
        'jenis_dosen_hasil_seminar_proposal',
        'status_verifikasi_hasil_seminar_proposal',
        'catatan_hasil_seminar_proposal',
        'nilai_a1_hasil_seminar_proposal',
        'nilai_a2_hasil_seminar_proposal',
        'nilai_a3_hasil_seminar_proposal',
        'nilai_b1_hasil_seminar_proposal',
        'nilai_b2_hasil_seminar_proposal',
        'nilai_b3_hasil_seminar_proposal',
        'nilai_b4_hasil_seminar_proposal',
        'nilai_b5_hasil_seminar_proposal',
        'nilai_b6_hasil_seminar_proposal',
        'nilai_b7_hasil_seminar_proposal',
        'nilai_c1_hasil_seminar_proposal',
        'nilai_c2_hasil_seminar_proposal',
        'nilai_c3_hasil_seminar_proposal',
    ];

    public function seminar_proposal()
    {
        return $this->belongsTo('App\SeminarProposal');
    }

    public function dosen()
    {
        return $this->belongsTo('App\Dosen');
    }
}
