<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * When an admin turns on "Maintenance mode" in Settings, students and
     * employers are shown a maintenance page instead of the app. Admins are
     * never blocked (so they can always turn the setting back off), and
     * logging out is always allowed so a locked-out user isn't stuck
     * mid-session.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Setting::get('maintenance_mode', '0') !== '1') {
            return $next($request);
        }

        $user = Auth::user();

        if (! $user || $user->role === 'admin' || $request->routeIs('logout')) {
            return $next($request);
        }

        if (in_array($user->role, ['student', 'employer'], true)) {
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}