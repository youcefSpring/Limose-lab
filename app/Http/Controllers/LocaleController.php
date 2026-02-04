<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Switch the application locale
     *
     * @param Request $request
     * @param string $locale
     * @return RedirectResponse
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        // Available locales
        $availableLocales = ['en', 'fr', 'ar'];

        // Validate locale
        if (!in_array($locale, $availableLocales)) {
            return redirect()->back()->with('error', __('Invalid language selection.'));
        }

        // Store locale in session
        Session::put('locale', $locale);

        // Set the locale immediately for the redirect message
        app()->setLocale($locale);

        // Redirect back with full page reload (disable Turbo cache)
        return redirect()->back()
            ->with('success', __('Language changed successfully!'))
            ->header('Turbo-Visit-Control', 'reload');
    }
}
