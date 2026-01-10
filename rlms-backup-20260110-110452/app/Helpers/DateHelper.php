<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Format date according to user locale.
     *
     * @param Carbon|string $date
     * @param string $locale
     * @return string
     */
    public static function formatDate($date, string $locale = 'en'): string
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return match ($locale) {
            'ar' => $date->locale('ar')->isoFormat('D MMMM YYYY'),
            'fr' => $date->locale('fr')->isoFormat('D MMMM YYYY'),
            default => $date->format('F d, Y'),
        };
    }

    /**
     * Format datetime according to user locale.
     *
     * @param Carbon|string $datetime
     * @param string $locale
     * @return string
     */
    public static function formatDateTime($datetime, string $locale = 'en'): string
    {
        if (is_string($datetime)) {
            $datetime = Carbon::parse($datetime);
        }

        return match ($locale) {
            'ar' => $datetime->locale('ar')->isoFormat('D MMMM YYYY، HH:mm'),
            'fr' => $datetime->locale('fr')->isoFormat('D MMMM YYYY à HH:mm'),
            default => $datetime->format('F d, Y at g:i A'),
        };
    }

    /**
     * Get human-readable time difference.
     *
     * @param Carbon|string $date
     * @param string $locale
     * @return string
     */
    public static function diffForHumans($date, string $locale = 'en'): string
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->locale($locale)->diffForHumans();
    }

    /**
     * Check if date is in the past.
     *
     * @param Carbon|string $date
     * @return bool
     */
    public static function isPast($date): bool
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->isPast();
    }

    /**
     * Check if date is in the future.
     *
     * @param Carbon|string $date
     * @return bool
     */
    public static function isFuture($date): bool
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->isFuture();
    }

    /**
     * Get days between two dates.
     *
     * @param Carbon|string $startDate
     * @param Carbon|string $endDate
     * @return int
     */
    public static function daysBetween($startDate, $endDate): int
    {
        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        return $startDate->diffInDays($endDate);
    }

    /**
     * Get working days between two dates (excluding weekends).
     *
     * @param Carbon|string $startDate
     * @param Carbon|string $endDate
     * @return int
     */
    public static function workingDaysBetween($startDate, $endDate): int
    {
        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        return $startDate->diffInWeekdays($endDate);
    }

    /**
     * Check if two date ranges overlap.
     *
     * @param Carbon|string $start1
     * @param Carbon|string $end1
     * @param Carbon|string $start2
     * @param Carbon|string $end2
     * @return bool
     */
    public static function datesOverlap($start1, $end1, $start2, $end2): bool
    {
        if (is_string($start1)) $start1 = Carbon::parse($start1);
        if (is_string($end1)) $end1 = Carbon::parse($end1);
        if (is_string($start2)) $start2 = Carbon::parse($start2);
        if (is_string($end2)) $end2 = Carbon::parse($end2);

        return $start1->lte($end2) && $end1->gte($start2);
    }
}
