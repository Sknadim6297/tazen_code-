<?php

// filepath: c:\xampp\htdocs\tazen_marge_code\Tazen_multi\app\Http\Middleware\RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if user is authenticated
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Check if user has the required role
        $admin = Auth::guard('admin')->user();
        
        if ($admin->role !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}