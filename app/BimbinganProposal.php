<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BimbinganProposal extends Model
{
    protected $table = 'bimbingan_proposal';
    protected $fillable = [
        'dosen_pembimbing_id_dosen_pembimbing',
        'topik_bimbingan_proposal',
        'nama_file_bimbingan_proposal',
        'status_persetujuan_bimbingan_proposal',
        'catatan_bimbingan_proposal',
    ];

    public function dosen_pembimbing()
    {
        return $this->belongsTo('App\DosenPembimbing');
    }
}
