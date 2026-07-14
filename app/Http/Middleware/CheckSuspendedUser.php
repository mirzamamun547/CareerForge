<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspendedUser
{
    /**
     * Log out any authenticated user whose account has been suspended by
     * an admin. Runs on every authenticated request, so a user who gets
     * suspended mid-session is kicked out on their very next click/refresh
     * (not just at their next login).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->status === 'suspended') {
            Auth::logout();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Your account has been suspended. Please contact support if you believe this is a mistake.');
        }

        return $next($request);
    }
}