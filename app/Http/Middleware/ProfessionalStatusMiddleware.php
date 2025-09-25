<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfessionalStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $professional = $request->user('professional');

        if (!$professional) {
            return redirect()->route('professional.login');
        }

        // Check if professional status is accepted
        if ($professional->status !== 'accepted') {
            if ($professional->status === 'rejected') {
                return redirect()->route('professional.rejected.view')
                    ->with('error', 'Your profile has been rejected. Please review and resubmit your details.');
            } else if ($professional->status === 'pending') {
                return redirect()->route('professional.pending.view')
                    ->with('info', 'Your profile is pending approval.');
            } else {
                return redirect()->route('professional.login')
                    ->with('error', 'Your account is not active.');
            }
        }

        return $next($request);
    }
}
