<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group', 'options', 'is_multilingual', 'order', 'category'];

    protected $casts = [
        'is_multilingual' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            return self::where('key', $key)->first();
        });

        return $setting ? $setting->value : $default;
    }

    /**
     * Get a localized setting value
     * If the setting is multilingual, it will append the locale to the key
     */
    public static function getLocalized($key, $locale = null, $default = null)
    {
        $locale = $locale ?? app()->getLocale();

        // First check if a localized version exists
        $localizedKey = "{$key}_{$locale}";
        $value = self::get($localizedKey);

        if ($value !== null) {
            return $value;
        }

        // Fall back to the base key
        return self::get($key, $default);
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'text', $group = 'general')
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group]
        );

        Cache::forget("setting_{$key}");
        Cache::forget('all_settings');
        Cache::forget("settings_group_{$group}");
        Cache::forget('settings_all_grouped');

        return $setting;
    }

    /**
     * Get settings by group
     */
    public static function getByGroup($group)
    {
        return Cache::remember("settings_group_{$group}", 3600, function () use ($group) {
            return self::where('group', $group)
                ->orderBy('order')
                ->get()
                ->pluck('value', 'key');
        });
    }

    /**
     * Get all settings grouped by their group
     */
    public static function getAllGrouped()
    {
        return Cache::remember('settings_all_grouped', 3600, function () {
            return self::orderBy('group')
                ->orderBy('order')
                ->get()
                ->groupBy('group');
        });
    }

    /**
     * Get all settings as key-value pairs
     * For multilingual settings, returns the value for the current locale
     */
    public static function getAllSettings($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $cacheKey = "all_settings_{$locale}";

        return Cache::remember($cacheKey, 3600, function () use ($locale) {
            $settings = self::pluck('value', 'key')->toArray();
            $multilingualKeys = self::where('is_multilingual', true)->pluck('key');

            foreach ($multilingualKeys as $key) {
                $localizedKey = "{$key}_{$locale}";
                if (isset($settings[$localizedKey]) && ! empty($settings[$localizedKey])) {
                    $settings[$key] = $settings[$localizedKey];
                }
            }

            return $settings;
        });
    }

    /**
     * Get all multilingual settings for a given group
     */
    public static function getMultilingualByGroup($group)
    {
        return Cache::remember("settings_multilingual_{$group}", 3600, function () use ($group) {
            return self::where('group', $group)
                ->where('is_multilingual', true)
                ->orderBy('order')
                ->get();
        });
    }

    /**
     * Get available locales from settings
     */
    public static function getAvailableLocales()
    {
        $locales = self::get('available_locales', 'en,fr,ar');

        return explode(',', $locales);
    }

    /**
     * Get default locale from settings
     */
    public static function getDefaultLocale()
    {
        return self::get('default_locale', 'en');
    }

    /**
     * Clear settings cache
     */
    public static function clearCache()
    {
        Cache::forget('all_settings');
        Cache::forget('settings_all_grouped');

        // Clear locale-specific caches
        foreach (['en', 'fr', 'ar'] as $locale) {
            Cache::forget("all_settings_{$locale}");
        }

        // Clear group caches
        $groups = self::distinct()->pluck('group');
        foreach ($groups as $group) {
            Cache::forget("settings_group_{$group}");
            Cache::forget("settings_multilingual_{$group}");
        }

        // Clear individual setting caches
        self::all()->each(function ($setting) {
            Cache::forget("setting_{$setting->key}");
        });
    }
}
