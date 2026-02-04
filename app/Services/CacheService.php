<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Publication;
use App\Models\Project;
use App\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache duration in seconds (1 hour)
     */
    protected int $duration = 3600;

    /**
     * Get dashboard statistics with caching
     */
    public function getDashboardStats(): array
    {
        return Cache::remember('dashboard_stats', $this->duration, function () {
            return [
                'total_publications' => Publication::count(),
                'total_projects' => Project::count(),
                'total_events' => Event::count(),
                'total_materials' => Material::count(),
                'total_users' => User::count(),
                'active_projects' => Project::where('status', 'active')->count(),
                'upcoming_events' => Event::upcoming()->count(),
                'pending_publications' => Publication::where('visibility', 'pending')->count(),
            ];
        });
    }

    /**
     * Get publications by year with caching
     */
    public function getPublicationsByYear(): array
    {
        return Cache::remember('publications_by_year', $this->duration, function () {
            return Publication::selectRaw('year, count(*) as count')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->limit(10)
                ->pluck('count', 'year')
                ->toArray();
        });
    }

    /**
     * Get publications by type with caching
     */
    public function getPublicationsByType(): array
    {
        return Cache::remember('publications_by_type', $this->duration, function () {
            return Publication::selectRaw('type, count(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type')
                ->toArray();
        });
    }

    /**
     * Get featured publications with caching
     */
    public function getFeaturedPublications()
    {
        return Cache::remember('featured_publications', $this->duration, function () {
            return Publication::with('user')
                ->where('is_featured', true)
                ->where('visibility', 'public')
                ->latest('publication_date')
                ->limit(5)
                ->get();
        });
    }

    /**
     * Get upcoming events with caching
     */
    public function getUpcomingEvents()
    {
        return Cache::remember('upcoming_events', 1800, function () { // 30 minutes
            return Event::upcoming()
                ->with('creator')
                ->withCount('attendees')
                ->limit(5)
                ->get();
        });
    }

    /**
     * Get active projects with caching
     */
    public function getActiveProjects()
    {
        return Cache::remember('active_projects', $this->duration, function () {
            return Project::where('status', 'active')
                ->with('user')
                ->latest()
                ->limit(5)
                ->get();
        });
    }

    /**
     * Clear all cached data
     */
    public function clearAll(): void
    {
        $keys = [
            'dashboard_stats',
            'publications_by_year',
            'publications_by_type',
            'featured_publications',
            'upcoming_events',
            'active_projects',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Clear publication-related caches
     */
    public function clearPublicationCaches(): void
    {
        Cache::forget('dashboard_stats');
        Cache::forget('publications_by_year');
        Cache::forget('publications_by_type');
        Cache::forget('featured_publications');
    }

    /**
     * Clear event-related caches
     */
    public function clearEventCaches(): void
    {
        Cache::forget('dashboard_stats');
        Cache::forget('upcoming_events');
    }

    /**
     * Clear project-related caches
     */
    public function clearProjectCaches(): void
    {
        Cache::forget('dashboard_stats');
        Cache::forget('active_projects');
    }

    /**
     * Get user activity stats with caching
     */
    public function getUserActivityStats(int $userId): array
    {
        return Cache::remember("user_activity_{$userId}", $this->duration, function () use ($userId) {
            return [
                'publications_count' => Publication::where('user_id', $userId)->count(),
                'projects_count' => Project::where('user_id', $userId)->count(),
                'events_created' => Event::where('created_by', $userId)->count(),
                'events_attending' => Event::whereHas('attendees', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->count(),
            ];
        });
    }

    /**
     * Clear user-specific caches
     */
    public function clearUserCaches(int $userId): void
    {
        Cache::forget("user_activity_{$userId}");
    }

    /**
     * Clear material-related caches
     */
    public function clearMaterialCaches(): void
    {
        Cache::forget('dashboard_stats');
    }
}
