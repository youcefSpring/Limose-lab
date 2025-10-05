<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Researcher;
use App\Models\Project;
use App\Models\Publication;
use App\Models\Equipment;
use App\Models\Event;
use App\Models\Collaboration;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Get dashboard analytics (Admin only)
     * GET /api/v1/analytics/dashboard
     */
    public function dashboard(): JsonResponse
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $overview = [
            'total_researchers' => Researcher::count(),
            'active_researchers' => Researcher::whereHas('user', function ($q) {
                $q->where('status', 'active');
            })->count(),
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'active')->count(),
            'total_publications' => Publication::count(),
            'published_publications' => Publication::where('status', 'published')->count(),
            'total_equipment' => Equipment::count(),
            'available_equipment' => Equipment::where('status', 'available')->count(),
            'equipment_utilization' => $this->calculateEquipmentUtilization(),
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('start_date', '>=', now())->count(),
            'total_collaborations' => Collaboration::count(),
            'active_collaborations' => Collaboration::where('status', 'active')->count(),
        ];

        $charts = [
            'projects_by_status' => Project::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),

            'publications_by_year' => Publication::selectRaw('publication_year, COUNT(*) as count')
                ->where('publication_year', '>=', now()->year - 4)
                ->groupBy('publication_year')
                ->orderBy('publication_year')
                ->pluck('count', 'publication_year'),

            'publications_by_type' => Publication::selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type'),

            'events_by_type' => Event::selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type'),

            'collaborations_by_type' => Collaboration::selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type'),

            'users_by_role' => User::selectRaw('role, COUNT(*) as count')
                ->groupBy('role')
                ->pluck('count', 'role'),
        ];

        return response()->json([
            'status' => 'success',
            'data' => [
                'overview' => $overview,
                'charts' => $charts
            ]
        ]);
    }

    /**
     * Get researchers analytics
     * GET /api/v1/analytics/researchers
     */
    public function researchers(): JsonResponse
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $analytics = [
            'total_researchers' => Researcher::count(),
            'active_researchers' => Researcher::whereHas('user', function ($q) {
                $q->where('status', 'active');
            })->count(),

            'researchers_by_domain' => Researcher::selectRaw('research_domain, COUNT(*) as count')
                ->groupBy('research_domain')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),

            'top_researchers_by_publications' => Researcher::withCount('publications')
                ->orderBy('publications_count', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($researcher) {
                    return [
                        'id' => $researcher->id,
                        'name' => $researcher->full_name,
                        'publications_count' => $researcher->publications_count,
                        'research_domain' => $researcher->research_domain,
                    ];
                }),

            'top_researchers_by_projects' => Researcher::withCount(['leadProjects', 'projects'])
                ->get()
                ->map(function ($researcher) {
                    $researcher->total_projects = $researcher->lead_projects_count + $researcher->projects_count;
                    return $researcher;
                })
                ->sortByDesc('total_projects')
                ->take(10)
                ->map(function ($researcher) {
                    return [
                        'id' => $researcher->id,
                        'name' => $researcher->full_name,
                        'total_projects' => $researcher->total_projects,
                        'research_domain' => $researcher->research_domain,
                    ];
                }),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $analytics
        ]);
    }

    /**
     * Get projects analytics
     * GET /api/v1/analytics/projects
     */
    public function projects(): JsonResponse
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $analytics = [
            'total_projects' => Project::count(),
            'projects_by_status' => Project::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),

            'projects_by_year' => Project::selectRaw('YEAR(start_date) as year, COUNT(*) as count')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->limit(5)
                ->pluck('count', 'year'),

            'average_project_duration' => Project::selectRaw('AVG(DATEDIFF(end_date, start_date)) as avg_duration')
                ->whereNotNull('end_date')
                ->value('avg_duration'),

            'total_budget' => Project::sum('budget'),
            'average_budget' => Project::avg('budget'),

            'projects_completion_rate' => $this->calculateProjectCompletionRate(),

            'largest_projects' => Project::orderBy('budget', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'title' => $project->getTitle(),
                        'budget' => $project->budget,
                        'status' => $project->status,
                        'leader' => $project->leader->full_name,
                    ];
                }),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $analytics
        ]);
    }

    /**
     * Get publications analytics
     * GET /api/v1/analytics/publications
     */
    public function publications(): JsonResponse
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $analytics = [
            'total_publications' => Publication::count(),
            'publications_by_type' => Publication::selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type'),

            'publications_by_year' => Publication::selectRaw('publication_year, COUNT(*) as count')
                ->where('publication_year', '>=', now()->year - 9)
                ->groupBy('publication_year')
                ->orderBy('publication_year')
                ->pluck('count', 'publication_year'),

            'publications_by_status' => Publication::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),

            'top_journals' => Publication::selectRaw('journal, COUNT(*) as count')
                ->whereNotNull('journal')
                ->groupBy('journal')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->pluck('count', 'journal'),

            'recent_publications' => Publication::with(['authorResearchers'])
                ->where('publication_year', '>=', now()->year - 1)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($publication) {
                    return [
                        'id' => $publication->id,
                        'title' => $publication->title,
                        'type' => $publication->type,
                        'publication_year' => $publication->publication_year,
                        'journal' => $publication->journal,
                        'authors_count' => $publication->authorResearchers->count(),
                    ];
                }),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $analytics
        ]);
    }

    /**
     * Get equipment analytics
     * GET /api/v1/analytics/equipment
     */
    public function equipment(): JsonResponse
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isLabManager()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $analytics = [
            'total_equipment' => Equipment::count(),
            'equipment_by_status' => Equipment::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),

            'equipment_by_category' => Equipment::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->orderBy('count', 'desc')
                ->pluck('count', 'category'),

            'utilization_rate' => $this->calculateEquipmentUtilization(),

            'maintenance_due' => Equipment::where('warranty_expiry', '<=', now()->addMonths(3))
                ->whereNotNull('warranty_expiry')
                ->count(),

            'most_reserved_equipment' => Equipment::withCount('reservations')
                ->orderBy('reservations_count', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($equipment) {
                    return [
                        'id' => $equipment->id,
                        'name' => $equipment->getName(),
                        'category' => $equipment->category,
                        'reservations_count' => $equipment->reservations_count,
                        'status' => $equipment->status,
                    ];
                }),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $analytics
        ]);
    }

    /**
     * Get user's personal analytics
     * GET /api/v1/analytics/personal
     */
    public function personal(): JsonResponse
    {
        $user = auth()->user();

        if (!$user->researcher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Researcher profile required',
                'code' => 'RESEARCHER_PROFILE_REQUIRED'
            ], 404);
        }

        $researcher = $user->researcher;

        $analytics = [
            'projects' => [
                'total' => $researcher->leadProjects()->count() + $researcher->projects()->count(),
                'as_leader' => $researcher->leadProjects()->count(),
                'as_member' => $researcher->projects()->count(),
                'active' => $researcher->leadProjects()->where('status', 'active')->count() +
                          $researcher->projects()->where('status', 'active')->count(),
            ],

            'publications' => [
                'total' => $researcher->publications()->count(),
                'by_year' => $researcher->publications()
                    ->selectRaw('publication_year, COUNT(*) as count')
                    ->groupBy('publication_year')
                    ->orderBy('publication_year', 'desc')
                    ->limit(5)
                    ->pluck('count', 'publication_year'),
                'by_type' => $researcher->publications()
                    ->selectRaw('type, COUNT(*) as count')
                    ->groupBy('type')
                    ->pluck('count', 'type'),
            ],

            'collaborations' => [
                'total' => $researcher->coordinatedCollaborations()->count(),
                'active' => $researcher->coordinatedCollaborations()->where('status', 'active')->count(),
                'by_type' => $researcher->coordinatedCollaborations()
                    ->selectRaw('type, COUNT(*) as count')
                    ->groupBy('type')
                    ->pluck('count', 'type'),
            ],

            'equipment_usage' => [
                'total_reservations' => $researcher->equipmentReservations()->count(),
                'recent_reservations' => $researcher->equipmentReservations()
                    ->with('equipment')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($reservation) {
                        return [
                            'equipment_name' => $reservation->equipment->getName(),
                            'start_datetime' => $reservation->start_datetime,
                            'status' => $reservation->status,
                        ];
                    }),
            ],
        ];

        return response()->json([
            'status' => 'success',
            'data' => $analytics
        ]);
    }

    /**
     * Calculate equipment utilization rate
     */
    private function calculateEquipmentUtilization(): float
    {
        $totalEquipment = Equipment::count();
        $availableEquipment = Equipment::where('status', 'available')->count();

        if ($totalEquipment === 0) {
            return 0;
        }

        return round((($totalEquipment - $availableEquipment) / $totalEquipment) * 100, 2);
    }

    /**
     * Calculate project completion rate
     */
    private function calculateProjectCompletionRate(): float
    {
        $totalProjects = Project::whereIn('status', ['active', 'completed'])->count();
        $completedProjects = Project::where('status', 'completed')->count();

        if ($totalProjects === 0) {
            return 0;
        }

        return round(($completedProjects / $totalProjects) * 100, 2);
    }
}