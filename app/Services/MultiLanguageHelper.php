<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class MultiLanguageHelper
{
    const SUPPORTED_LANGUAGES = ['ar', 'fr', 'en'];
    const DEFAULT_LANGUAGE = 'ar';
    const RTL_LANGUAGES = ['ar'];

    /**
     * Get current application language.
     */
    public static function getCurrentLanguage(): string
    {
        return App::getLocale();
    }

    /**
     * Set application language.
     */
    public static function setLanguage(string $language): void
    {
        if (in_array($language, self::SUPPORTED_LANGUAGES)) {
            App::setLocale($language);
            Session::put('language', $language);
        }
    }

    /**
     * Get language from session or default.
     */
    public static function getSessionLanguage(): string
    {
        return Session::get('language', self::DEFAULT_LANGUAGE);
    }

    /**
     * Check if language is RTL.
     */
    public static function isRTL(string $language = null): bool
    {
        $language = $language ?? self::getCurrentLanguage();
        return in_array($language, self::RTL_LANGUAGES);
    }

    /**
     * Get text direction for language.
     */
    public static function getDirection(string $language = null): string
    {
        return self::isRTL($language) ? 'rtl' : 'ltr';
    }

    /**
     * Get supported languages with display names.
     */
    public static function getSupportedLanguages(): array
    {
        return [
            'ar' => 'العربية',
            'fr' => 'Français',
            'en' => 'English',
        ];
    }

    /**
     * Get multilingual content from object.
     */
    public static function getContent($object, string $field, string $language = null): ?string
    {
        $language = $language ?? self::getCurrentLanguage();
        $fieldName = $field . '_' . $language;

        if (is_array($object)) {
            return $object[$fieldName] ?? null;
        }

        if (is_object($object) && isset($object->$fieldName)) {
            return $object->$fieldName;
        }

        // Fallback to Arabic if current language content is empty
        if ($language !== 'ar') {
            $fallbackField = $field . '_ar';
            if (is_array($object)) {
                return $object[$fallbackField] ?? null;
            }
            if (is_object($object) && isset($object->$fallbackField)) {
                return $object->$fallbackField;
            }
        }

        return null;
    }

    /**
     * Get best available content (fallback mechanism).
     */
    public static function getBestContent($object, string $field): ?string
    {
        $currentLang = self::getCurrentLanguage();

        // Try current language first
        $content = self::getContent($object, $field, $currentLang);
        if (!empty($content)) {
            return $content;
        }

        // Try fallback languages in order
        $fallbackOrder = $currentLang === 'ar' ? ['fr', 'en'] : ['ar', 'fr', 'en'];

        foreach ($fallbackOrder as $lang) {
            if ($lang === $currentLang) continue;

            $content = self::getContent($object, $field, $lang);
            if (!empty($content)) {
                return $content;
            }
        }

        return null;
    }

    /**
     * Validate multilingual data.
     */
    public static function validateMultilingualData(array $data, string $field, bool $requireArabic = true): array
    {
        $errors = [];
        $hasContent = false;

        foreach (self::SUPPORTED_LANGUAGES as $lang) {
            $fieldName = $field . '_' . $lang;
            if (!empty($data[$fieldName])) {
                $hasContent = true;
            }
        }

        if (!$hasContent) {
            $errors[] = "يجب توفير المحتوى بلغة واحدة على الأقل";
        }

        if ($requireArabic && empty($data[$field . '_ar'])) {
            $errors[] = "المحتوى باللغة العربية مطلوب";
        }

        return $errors;
    }

    /**
     * Format multilingual data for storage.
     */
    public static function formatForStorage(array $data, array $fields): array
    {
        $formatted = [];

        foreach ($fields as $field) {
            foreach (self::SUPPORTED_LANGUAGES as $lang) {
                $fieldName = $field . '_' . $lang;
                if (isset($data[$fieldName])) {
                    $formatted[$fieldName] = trim($data[$fieldName]);
                    // Set to null if empty string
                    if (empty($formatted[$fieldName])) {
                        $formatted[$fieldName] = null;
                    }
                }
            }
        }

        return $formatted;
    }

    /**
     * Get multilingual search terms.
     */
    public static function getSearchTerms(array $data, string $field): array
    {
        $terms = [];

        foreach (self::SUPPORTED_LANGUAGES as $lang) {
            $fieldName = $field . '_' . $lang;
            if (!empty($data[$fieldName])) {
                $terms[] = $data[$fieldName];
            }
        }

        return array_unique($terms);
    }

    /**
     * Generate language-specific URLs.
     */
    public static function getLocalizedUrl(string $route, array $parameters = [], string $language = null): string
    {
        $language = $language ?? self::getCurrentLanguage();
        $parameters['locale'] = $language;

        return route($route, $parameters);
    }

    /**
     * Get language flag/icon path.
     */
    public static function getLanguageFlag(string $language): string
    {
        $flags = [
            'ar' => 'flags/algeria.svg',
            'fr' => 'flags/france.svg',
            'en' => 'flags/uk.svg',
        ];

        return asset($flags[$language] ?? $flags['ar']);
    }

    /**
     * Get translated month names.
     */
    public static function getMonthNames(string $language = null): array
    {
        $language = $language ?? self::getCurrentLanguage();

        $months = [
            'ar' => [
                1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
                5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
                9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
            ],
            'fr' => [
                1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
            ],
            'en' => [
                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
            ],
        ];

        return $months[$language] ?? $months['ar'];
    }

    /**
     * Get translated day names.
     */
    public static function getDayNames(string $language = null): array
    {
        $language = $language ?? self::getCurrentLanguage();

        $days = [
            'ar' => [
                0 => 'الأحد', 1 => 'الإثنين', 2 => 'الثلاثاء', 3 => 'الأربعاء',
                4 => 'الخميس', 5 => 'الجمعة', 6 => 'السبت'
            ],
            'fr' => [
                0 => 'Dimanche', 1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi',
                4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi'
            ],
            'en' => [
                0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
                4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'
            ],
        ];

        return $days[$language] ?? $days['ar'];
    }

    /**
     * Format date according to language.
     */
    public static function formatDate(\Carbon\Carbon $date, string $language = null): string
    {
        $language = $language ?? self::getCurrentLanguage();

        $formats = [
            'ar' => 'Y/m/d',
            'fr' => 'd/m/Y',
            'en' => 'm/d/Y',
        ];

        return $date->format($formats[$language] ?? $formats['ar']);
    }

    /**
     * Format number according to language.
     */
    public static function formatNumber(float $number, int $decimals = 0, string $language = null): string
    {
        $language = $language ?? self::getCurrentLanguage();

        $separators = [
            'ar' => ['٫', '،'],  // Arabic decimal and thousands
            'fr' => [',', ' '],  // French decimal and thousands
            'en' => ['.', ','],  // English decimal and thousands
        ];

        $config = $separators[$language] ?? $separators['ar'];

        return number_format($number, $decimals, $config[0], $config[1]);
    }

    /**
     * Convert Western digits to Arabic-Indic digits.
     */
    public static function toArabicDigits(string $text): string
    {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($western, $arabic, $text);
    }

    /**
     * Convert Arabic-Indic digits to Western digits.
     */
    public static function toWesternDigits(string $text): string
    {
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($arabic, $western, $text);
    }

    /**
     * Get CSS classes for language direction.
     */
    public static function getDirectionClasses(string $language = null): string
    {
        $language = $language ?? self::getCurrentLanguage();

        $classes = [];

        if (self::isRTL($language)) {
            $classes[] = 'rtl';
            $classes[] = 'text-right';
        } else {
            $classes[] = 'ltr';
            $classes[] = 'text-left';
        }

        $classes[] = 'lang-' . $language;

        return implode(' ', $classes);
    }

    /**
     * Get language-specific font families.
     */
    public static function getFontFamily(string $language = null): string
    {
        $language = $language ?? self::getCurrentLanguage();

        $fonts = [
            'ar' => "'Noto Sans Arabic', 'Tahoma', 'Arial Unicode MS', sans-serif",
            'fr' => "'Roboto', 'Helvetica Neue', 'Arial', sans-serif",
            'en' => "'Roboto', 'Helvetica Neue', 'Arial', sans-serif",
        ];

        return $fonts[$language] ?? $fonts['ar'];
    }

    /**
     * Transliterate Arabic text to Latin.
     */
    public static function transliterate(string $arabicText): string
    {
        $arabic = [
            'ا' => 'a', 'ب' => 'b', 'ت' => 't', 'ث' => 'th', 'ج' => 'j',
            'ح' => 'h', 'خ' => 'kh', 'د' => 'd', 'ذ' => 'dh', 'ر' => 'r',
            'ز' => 'z', 'س' => 's', 'ش' => 'sh', 'ص' => 's', 'ض' => 'd',
            'ط' => 't', 'ظ' => 'z', 'ع' => 'a', 'غ' => 'gh', 'ف' => 'f',
            'ق' => 'q', 'ك' => 'k', 'ل' => 'l', 'م' => 'm', 'ن' => 'n',
            'ه' => 'h', 'و' => 'w', 'ي' => 'y', 'ى' => 'a', 'ة' => 'h',
            'أ' => 'a', 'إ' => 'i', 'آ' => 'aa', 'ؤ' => 'o', 'ئ' => 'e',
            ' ' => '-'
        ];

        $transliterated = strtr($arabicText, $arabic);

        // Clean up multiple dashes and convert to lowercase
        $transliterated = preg_replace('/[-]+/', '-', $transliterated);
        $transliterated = trim($transliterated, '-');

        return strtolower($transliterated);
    }

    /**
     * Generate slug from multilingual text.
     */
    public static function generateSlug(array $data, string $field): string
    {
        // Try to use English first, then French, then Arabic (transliterated)
        $priorities = ['en', 'fr', 'ar'];

        foreach ($priorities as $lang) {
            $fieldName = $field . '_' . $lang;
            if (!empty($data[$fieldName])) {
                $text = $data[$fieldName];

                if ($lang === 'ar') {
                    return self::transliterate($text);
                } else {
                    return \Str::slug($text);
                }
            }
        }

        return 'item-' . time();
    }

    /**
     * Get localized pagination links.
     */
    public static function getPaginationLabels(string $language = null): array
    {
        $language = $language ?? self::getCurrentLanguage();

        $labels = [
            'ar' => [
                'previous' => '« السابق',
                'next' => 'التالي »',
                'showing' => 'عرض',
                'to' => 'إلى',
                'of' => 'من',
                'results' => 'النتائج',
            ],
            'fr' => [
                'previous' => '« Précédent',
                'next' => 'Suivant »',
                'showing' => 'Affichage',
                'to' => 'à',
                'of' => 'de',
                'results' => 'résultats',
            ],
            'en' => [
                'previous' => '« Previous',
                'next' => 'Next »',
                'showing' => 'Showing',
                'to' => 'to',
                'of' => 'of',
                'results' => 'results',
            ],
        ];

        return $labels[$language] ?? $labels['ar'];
    }

    /**
     * Get language-specific text alignment.
     */
    public static function getTextAlign(string $language = null): string
    {
        return self::isRTL($language) ? 'right' : 'left';
    }

    /**
     * Get opposite direction for floating elements.
     */
    public static function getOppositeAlign(string $language = null): string
    {
        return self::isRTL($language) ? 'left' : 'right';
    }
}