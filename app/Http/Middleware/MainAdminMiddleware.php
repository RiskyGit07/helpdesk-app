<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MainAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Hanya admin dengan ID = 1 yang bisa lewat
        if (auth()->user()->user_type !== 'admin' || auth()->user()->id !== 1) {
            abort(403, 'Hanya Admin Utama yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}