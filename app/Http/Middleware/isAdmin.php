<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
   if (auth()->check() && auth()->user()->role === 'admin') {
    return $next($request); // user admin boleh lanjut
}

// Kalau bukan admin
abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
