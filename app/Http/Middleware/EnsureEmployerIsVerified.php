<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmployerIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'employer' && !$user->verified) {
            // Allow access to the pending verification page and logout
            if (!$request->is('employer/pending-verification') && !$request->routeIs('logout')) {
                return redirect()->route('employer.pending-verification');
            }
        }

        return $next($request);
    }
}
