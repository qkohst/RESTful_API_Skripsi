<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiClient extends Model
{
    protected $table = 'api_client';
    protected $fillable = [
        'user_developer_id',
        'nama_project',
        'platform',
        'deskripsi',
        'api_key',
        'status',
    ];

    public function user_developer()
    {
        return $this->belongsTo('App\UserDeveloper');
    }

    public function api_client()
    {
        return $this->hasMany('App\TrafficRequest');
    }
}
