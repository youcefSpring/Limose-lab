<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Available locales
        $availableLocales = ['en', 'fr', 'ar'];

        // Check if locale is in session
        $locale = Session::get('locale');

        // If not in session, check browser preference
        if (! $locale) {
            $locale = $request->getPreferredLanguage($availableLocales);
        }

        // Fallback to default locale
        if (! $locale || ! in_array($locale, $availableLocales)) {
            $locale = config('app.locale', 'en');
        }

        // Set the application locale
        App::setLocale($locale);

        // Set Carbon locale for date formatting
        \Carbon\Carbon::setLocale($locale);

        return $next($request);
    }
}
