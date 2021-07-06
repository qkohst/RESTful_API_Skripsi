<?php

namespace App\Http\Middleware;

use App\ApiClient;
use Closure;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $api_client = ApiClient::where('api_key', $request->api_key)->first();
        if (is_null($api_client)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Api Key'
            ], 401);
        } elseif ($api_client->status == 'Non Aktif') {
            return response()->json([
                'status' => 'error',
                'message' => 'Api Key is Non Aktif'
            ], 401);
        }
        return $next($request);
    }
}
