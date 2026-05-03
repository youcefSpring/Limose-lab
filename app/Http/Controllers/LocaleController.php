<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Switch the application locale
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        // Available locales
        $availableLocales = ['en', 'fr', 'ar'];

        // Validate locale
        if (! in_array($locale, $availableLocales)) {
            return redirect()->back();
        }

        // Store locale in session
        Session::put('locale', $locale);

        // Also store in cookie for persistence
        Cookie::queue('locale', $locale, 60 * 24 * 365); // 1 year

        // Redirect back - will reload with new locale
        return redirect()->back();
    }
}
