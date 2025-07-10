<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditAuthenticationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Capture login events
        if ($request->is('admin/login') && $request->isMethod('POST') && Auth::check()) {
            $this->logAuthEvent('login', Auth::user(), $request);
        }

        return $response;
    }

    public function terminate(Request $request, $response)
    {
        // Capture logout events
        if ($request->is('admin/logout') && $request->isMethod('POST')) {
            // User might already be logged out, so we need to handle this differently
            $this->logAuthEvent('logout', null, $request);
        }
    }

    private function logAuthEvent(string $event, $user, Request $request)
    {
        try {
            AuditLog::create([
                'user_id' => $user ? $user->id : null,
                'event' => $event,
                'auditable_type' => 'Authentication',
                'auditable_id' => $user ? $user->id : 0,
                'old_values' => null,
                'new_values' => [
                    'event' => $event,
                    'timestamp' => now(),
                    'user_agent' => $request->header('User-Agent'),
                    'ip_address' => $request->ip(),
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
            ]);
        } catch (\Exception $e) {
            // Silently fail to avoid breaking authentication
            \Log::error('Failed to log authentication event: ' . $e->getMessage());
        }
    }
}
