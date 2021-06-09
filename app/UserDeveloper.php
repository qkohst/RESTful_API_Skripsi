<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class UserDeveloper extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $guard = 'developer';

    protected $table = 'user_developer';
    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'email',
        'password',
        'role',
        'status',
    ];
    protected $hidden = [
        'password',
    ];

    public function api_client()
    {
        return $this->hasMany('App\ApiClient');
    }
}
