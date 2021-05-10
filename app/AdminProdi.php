<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminProdi extends Model
{
    protected $table = 'admin_prodi';
    protected $fillable = [
        'user_id_user',
        'program_studi_id_program_studi',
        'nik_admin_prodi',
        'nidn_admin_prodi',
        'nip_admin_prodi',
        'nama_admin_prodi',
        'tempat_lahir_admin_prodi',
        'tanggal_lahir_admin_prodi',
        'jenis_kelamin_admin_prodi',
        'foto_admin_prodi',
        'no_surat_tugas_admin_prodi',
        'email_admin_prodi',
        'no_hp_admin_prodi'
    ];

    public function program_studi()
    {
        return $this->belongsTo('App\ProgramStudi');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
