<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShareDashboardData
{
    public function handle(Request $request, Closure $next)
    {
        view()->share('notifications_count', 0); // Remplacez par votre logique
        return $next($request);
    }
} 