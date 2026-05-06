<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $availableLocales = ['en', 'fr', 'ar'];

        $locale = session()->get('locale');

        if (! $locale) {
            $locale = $request->cookie('locale');
        }

        if (! $locale) {
            $locale = $request->getPreferredLanguage($availableLocales);
        }

        if (! $locale || ! in_array($locale, $availableLocales)) {
            $locale = config('app.locale', 'en');
        }

        App::setLocale($locale);
        \Carbon\Carbon::setLocale($locale);

        return $next($request);
    }
}
