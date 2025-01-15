<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotProfessor
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('professor')->check()) {
            return redirect()->route('professor.login');
        }

        return $next($request);
    }
} 