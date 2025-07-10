<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        $user = auth()->user();

        // Check if user is admin or employee
        if (!$user->isAdmin() && !$user->isEmployee()) {
            auth()->logout();
            return redirect()->route('admin.login')->with('error', 'Access denied. Admin or employee privileges required.');
        }

        return $next($request);
    }
}
