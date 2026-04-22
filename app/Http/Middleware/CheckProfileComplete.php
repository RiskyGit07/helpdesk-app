<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProfileComplete
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // ✅ hanya untuk USER (bukan admin)
        if (
            $user->user_type !== 'admin' &&
            $user->profile_completed != 1 &&
            !$request->routeIs('user.profile.complete') &&
            !$request->routeIs('user.profile.complete.store')
        ) {
            return redirect()->route('user.profile.complete');
        }

        return $next($request);
    }
}