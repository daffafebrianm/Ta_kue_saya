<?php

// app/Http/Middleware/IsCustomer.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsCustomer
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna sudah login dan memiliki role 'admin'
        if (auth()->check() && auth()->user()->role === 'customer') {
            return $next($request);
        }

        // Jika bukan admin, batalkan dan tampilkan pesan 403
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
