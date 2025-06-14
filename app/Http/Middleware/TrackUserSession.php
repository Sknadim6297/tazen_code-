<?php


namespace App\Http\Middleware;

use App\Models\ActiveSession;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TrackUserSession
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Update session activity for authenticated users
        if (Auth::guard('user')->check()) {
            $user = Auth::guard('user')->user();

            ActiveSession::where('user_id', $user->id)
                ->where('session_id', Session::getId())
                ->update(['last_active_at' => now()]);
        }

        return $response;
    }
}