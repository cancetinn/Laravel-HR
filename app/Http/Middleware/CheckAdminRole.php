<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, [1, 2, 3])) {
            return $next($request);
        }

        abort(403, 'Bu sayfaya erişim yetkiniz yok.');
    }
}


