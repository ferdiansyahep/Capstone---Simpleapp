<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->isAdmin()) {
            return redirect()->route('beranda'); // Ganti dengan nama rute yang sesuai untuk beranda
        }

        return $next($request);
    }
}
