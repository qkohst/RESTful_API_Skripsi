<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDeveloper extends Model
{
    protected $table = 'user_developer';
    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'email',
        'password',
        'role',
        'status',
    ];
}
