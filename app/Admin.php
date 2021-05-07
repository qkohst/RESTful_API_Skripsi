<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $fillable = [
        'user_id_user',
        'nik_admin',
        'nidn_admin',
        'nip_admin',
        'nama_admin',
        'tempat_lahir_admin',
        'tanggal_lahir_admin',
        'jenis_kelamin_admin',
        'foto_admin',
        'email_admin',
        'no_hp_admin',
        'status_admin',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
