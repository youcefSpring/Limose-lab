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
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($request->settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            if ($setting) {
                // Handle file uploads
                if ($setting->type === 'image' && $request->hasFile("settings.{$key}")) {
                    // Delete old image if exists
                    if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }

                    // Store new image
                    $path = $request->file("settings.{$key}")->store('settings', 'public');
                    $value = $path;
                }

                $setting->update(['value' => $value]);
            }
        }

        // Clear cache
        Setting::clearCache();

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }
}
