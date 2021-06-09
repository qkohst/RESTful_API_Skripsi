<?php

namespace App\Http\Middleware;

use Closure;

class checkRoleUserDev
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,  $role)
    {
        if ($request->user()->role == $role) {
            return $next($request);
        }
        return back()->with('toast_error', 'No Authorization');
    }
}
