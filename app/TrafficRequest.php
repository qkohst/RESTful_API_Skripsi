<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrafficRequest extends Model
{
    protected $table = 'traffic_request';
    protected $fillable = [
        'api_client_id',
        'status',
    ];

    public function api_client()
    {
        return $this->belongsTo('App\ApiClient');
    }
}
