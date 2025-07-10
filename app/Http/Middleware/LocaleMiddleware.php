<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = 'en'; // default locale

        // Check if language is set in the URL query string
        if ($request->has('lang')) {
            $requestLocale = $request->lang;
            // Check if the locale is valid (only allow en and ar)
            if (in_array($requestLocale, ['en', 'ar'])) {
                $locale = $requestLocale;
                Session::put('locale', $locale);
            }
        }
        // Use session locale if available
        elseif (Session::has('locale')) {
            $sessionLocale = Session::get('locale');
            if (in_array($sessionLocale, ['en', 'ar'])) {
                $locale = $sessionLocale;
            }
        }

        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}
