<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminProfileComplete
{
    public function handle(Request $request, Closure $next)
{
    if (!Auth::check()) {
        return $next($request);
    }

    $user = Auth::user();

    if (
        $user->user_type === 'admin' &&
        $user->profile_completed != 1 &&
        !$request->routeIs('admin.profile.complete') &&
        !$request->routeIs('admin.profile.complete.store')
    ) {
        return redirect()->route('admin.profile.complete');
    }

    return $next($request);
}
}