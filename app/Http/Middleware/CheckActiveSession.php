<?php

namespace App\Http\Middleware;

use App\Models\ActiveSession;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckActiveSession
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
        if (Auth::guard('user')->check()) {
            $user = Auth::guard('user')->user();
            $sessionId = Session::getId();
            
            // Check if this session is still in the active_sessions table
            $validSession = ActiveSession::where('user_id', $user->id)
                ->where('session_id', $sessionId)
                ->exists();
                
            if (!$validSession) {
                // Log the user out
                Auth::guard('user')->logout();
                
                // Invalidate the session
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                // Redirect to login with a message
                return redirect()->route('login')
                    ->with('message', 'Your session has ended because you logged in from another device.');
            }
            
            // Update the last activity time
            ActiveSession::where('user_id', $user->id)
                ->where('session_id', $sessionId)
                ->update(['last_active_at' => now()]);
        }

        return $next($request);
    }
}
