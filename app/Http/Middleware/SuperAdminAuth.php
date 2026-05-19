<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class SuperAdminAuth
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('superadmin')->check()) {
            return redirect()->route('superadmin.login');
        }

        return $next($request);
    }
}
