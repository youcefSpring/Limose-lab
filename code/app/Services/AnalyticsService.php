<?php

namespace App\Services;

use App\Models\User;
use App\Models\Project;
use App\Models\Publication;
use App\Models\Equipment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalyticsService
{
    public function getSystemAnalytics(array $filters = []): array
    {
        $period = $filters['period'] ?? '30days';
        $type = $filters['type'] ?? 'all';

        return [
            'overview' => $this->getOverviewStats(),
            'trends' => $this->getTrendData($period),
            'charts' => $this->getChartData($type),
        ];
    }

    public function getUserAnalytics(): array
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'users_by_role' => User::selectRaw('role, COUNT(*) as count')
                ->groupBy('role')->pluck('count', 'role'),
            'registration_trends' => $this->getUserRegistrationTrends(),
        ];
    }

    public function getProjectAnalytics(): array
    {
        return [
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'active')->count(),
            'projects_by_status' => Project::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')->pluck('count', 'status'),
            'completion_rates' => $this->getProjectCompletionRates(),
        ];
    }

    public function getPublicationAnalytics(): array
    {
        return [
            'total_publications' => Publication::count(),
            'publications_by_year' => Publication::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
                ->groupBy('year')->pluck('count', 'year'),
            'publications_by_type' => Publication::selectRaw('type, COUNT(*) as count')
                ->groupBy('type')->pluck('count', 'type'),
        ];
    }

    public function getEquipmentAnalytics(): array
    {
        return [
            'total_equipment' => Equipment::count(),
            'available_equipment' => Equipment::where('status', 'available')->count(),
            'equipment_by_status' => Equipment::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')->pluck('count', 'status'),
            'usage_statistics' => $this->getEquipmentUsageStats(),
        ];
    }

    public function getSystemLogs(array $filters = []): Collection
    {
        $type = $filters['type'] ?? 'all';
        $level = $filters['level'] ?? null;
        $dateFrom = $filters['date_from'] ?? null;
        $dateeTo = $filters['date_to'] ?? null;

        // This is a placeholder implementation
        // In a real application, you would read from actual log files or database
        return collect([
            [
                'id' => 1,
                'level' => 'info',
                'message' => 'User logged in',
                'context' => ['user_id' => 1],
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'level' => 'error',
                'message' => 'Database connection failed',
                'context' => ['error' => 'Connection timeout'],
                'created_at' => now()->subHour(),
            ],
        ]);
    }

    private function getOverviewStats(): array
    {
        return [
            'total_users' => User::count(),
            'total_projects' => Project::count(),
            'total_publications' => Publication::count(),
            'total_equipment' => Equipment::count(),
        ];
    }

    private function getTrendData(string $period): array
    {
        $days = match($period) {
            '7days' => 7,
            '30days' => 30,
            '90days' => 90,
            '1year' => 365,
            default => 30,
        };

        return [
            'user_registrations' => $this->getDataTrend(User::class, $days),
            'project_creations' => $this->getDataTrend(Project::class, $days),
            'publication_additions' => $this->getDataTrend(Publication::class, $days),
        ];
    }

    private function getChartData(string $type): array
    {
        if ($type === 'users' || $type === 'all') {
            return [
                'users_by_role' => User::selectRaw('role, COUNT(*) as count')
                    ->groupBy('role')->pluck('count', 'role'),
            ];
        }

        if ($type === 'projects' || $type === 'all') {
            return [
                'projects_by_status' => Project::selectRaw('status, COUNT(*) as count')
                    ->groupBy('status')->pluck('count', 'status'),
            ];
        }

        return [];
    }

    private function getUserRegistrationTrends(): array
    {
        return User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
    }

    private function getProjectCompletionRates(): array
    {
        $total = Project::count();
        $completed = Project::where('status', 'completed')->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
        ];
    }

    private function getEquipmentUsageStats(): array
    {
        return [
            'most_used' => Equipment::withCount('reservations')
                ->orderBy('reservations_count', 'desc')
                ->limit(5)
                ->get(),
            'least_used' => Equipment::withCount('reservations')
                ->orderBy('reservations_count', 'asc')
                ->limit(5)
                ->get(),
        ];
    }

    private function getDataTrend(string $model, int $days): array
    {
        return $model::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
    }
}