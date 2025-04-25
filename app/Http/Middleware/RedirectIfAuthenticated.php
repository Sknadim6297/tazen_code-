<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect admin user
                if ($guard === 'admin') {
                    return redirect('/admin/dashboard');
                }

                // Redirect regular user
                elseif ($guard === 'user') {
                    return redirect('/user/dashboard');
                }
                // Redirect professional user
                elseif ($guard === 'professional') {
                    return redirect('/professional/dashboard');
                }
            }
        }

        return $next($request);
    }
}
