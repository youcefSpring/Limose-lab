<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        // Get all settings grouped by group and ordered
        $settings = Setting::getAllGrouped();

        // Get available locales for multilingual settings
        $locales = Setting::getAvailableLocales();

        return view('settings.index', compact('settings', 'locales'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'nullable|array',
        ]);

        // Handle regular settings
        if ($request->has('settings')) {
            foreach ($request->settings as $key => $value) {
                $setting = Setting::where('key', $key)->first();

                if ($setting) {
                    // Handle file uploads (image, color)
                    if ($setting->type === 'image' && $request->hasFile("settings.{$key}")) {
                        // Delete old image if exists
                        if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                            Storage::disk('public')->delete($setting->value);
                        }

                        // Store new image
                        $path = $request->file("settings.{$key}")->store('settings', 'public');
                        $value = $path;
                    }

                    // Handle boolean (checkbox might not be present if unchecked)
                    if ($setting->type === 'boolean') {
                        $value = $request->has("settings.{$key}") ? '1' : '0';
                    }

                    // Handle color type
                    if ($setting->type === 'color' && empty($value)) {
                        continue; // Don't update if color is empty
                    }

                    $setting->update(['value' => $value]);
                }
            }
        }

        // Handle file uploads separately (because they don't come through settings array)
        foreach ($request->allFiles() as $fileKey => $file) {
            if (strpos($fileKey, 'settings.') === 0) {
                $key = str_replace('settings.', '', $fileKey);
                $setting = Setting::where('key', $key)->first();

                if ($setting && $setting->type === 'image') {
                    // Delete old image
                    if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }

                    // Store new image
                    $path = $file->store('settings', 'public');
                    $setting->update(['value' => $path]);
                }
            }
        }

        // Clear cache
        Setting::clearCache();

        return redirect()->route('settings.index')
            ->with('success', __('Settings updated successfully!'));
    }
}
