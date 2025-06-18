<?php

// filepath: c:\xampp\htdocs\tazen_marge_code\Tazen_multi\app\Http\Middleware\CheckSuperAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuperAdmin
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
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}