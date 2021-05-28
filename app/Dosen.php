<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';
    protected $fillable = [
        'user_id_user',
        'program_studi_id_program_studi',
        'jabatan_struktural_id_jabatan_struktural',
        'jabatan_fungsional_id_jabatan_fungsional',
        'nik_dosen',
        'nidn_dosen',
        'nip_dosen',
        'nama_dosen',
        'tempat_lahir_dosen',
        'tanggal_lahir_dosen',
        'jenis_kelamin_dosen',
        'status_perkawinan_dosen',
        'agama_dosen',
        'nama_ibu_dosen',
        'gelar_dosen',
        'pendidikan_terakhir_dosen',
        'alamat_dosen',
        'desa_dosen',
        'kecamatan_dosen',
        'kabupaten_dosen',
        'provinsi_dosen',
        'foto_dosen',
        'email_dosen',
        'no_hp_dosen',
        'status_dosen'
    ];

    public function program_studi()
    {
        return $this->belongsTo('App\ProgramStudi');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function jabatan_struktural()
    {
        return $this->belongsTo('App\JabatanStruktural');
    }

    public function jabatan_fungsional()
    {
        return $this->belongsTo('App\JabatanFungsional');
    }

    public function dosen_pembimbing()
    {
        return $this->hasMany('App\DosenPembimbing');
    }

    public function dosen_penguji()
    {
        return $this->hasMany('App\DosenPenguji');
    }

    public function hasil_seminar_proposal()
    {
        return $this->hasMany('App\HasilSeminarProposal');
    }
}
