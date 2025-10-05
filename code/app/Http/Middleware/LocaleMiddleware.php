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
        // Available locales
        $availableLocales = ['ar', 'fr', 'en'];

        // Get locale from various sources
        $locale = $this->getLocale($request, $availableLocales);

        // Set the application locale
        App::setLocale($locale);

        // Store in session for persistence
        Session::put('locale', $locale);

        return $next($request);
    }

    /**
     * Determine the locale from various sources
     */
    private function getLocale(Request $request, array $availableLocales): string
    {
        // 1. Check URL parameter
        if ($request->has('lang') && in_array($request->get('lang'), $availableLocales)) {
            return $request->get('lang');
        }

        // 2. Check session
        if (Session::has('locale') && in_array(Session::get('locale'), $availableLocales)) {
            return Session::get('locale');
        }

        // 3. Check user preference (if authenticated)
        if (auth()->check() && auth()->user()->locale && in_array(auth()->user()->locale, $availableLocales)) {
            return auth()->user()->locale;
        }

        // 4. Check Accept-Language header
        $preferredLanguage = $request->getPreferredLanguage($availableLocales);
        if ($preferredLanguage) {
            return $preferredLanguage;
        }

        // 5. Default to Arabic (primary language for SGLR)
        return 'ar';
    }
}