<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\AuthenticationService;
use App\Services\ResearcherService;
use App\Services\ProjectService;
use App\Services\PublicationService;
use App\Services\EquipmentService;
use App\Services\EventService;
use App\Services\CollaborationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private AuthenticationService $authService,
        private ResearcherService $researcherService,
        private ProjectService $projectService,
        private PublicationService $publicationService,
        private EquipmentService $equipmentService,
        private EventService $eventService,
        private CollaborationService $collaborationService
    ) {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard - redirect to AdminLTE.
     */
    public function index(Request $request)
    {
        return redirect()->route('dashboard.admin-lte');
    }

    /**
     * Get admin dashboard data with comprehensive statistics
     */
    private function getAdminDashboard(): array
    {
        // Basic counts
        $totalUsers = \App\Models\User::count();
        $totalResearchers = \App\Models\Researcher::count();
        $totalProjects = \App\Models\Project::count();
        $activeProjects = \App\Models\Project::where('status', 'active')->count();
        $totalPublications = \App\Models\Publication::count();
        $totalEquipment = \App\Models\Equipment::count();
        $equipmentInUse = \App\Models\Equipment::where('status', 'in_use')->count();

        // Equipment status breakdown
        $equipmentStatus = \App\Models\Equipment::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')->pluck('count', 'status')->toArray();

        // Monthly trends (last 6 months)
        $monthlyProjects = [];
        $monthlyPublications = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyProjects[] = \App\Models\Project::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $monthlyPublications[] = \App\Models\Publication::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
        }

        return [
            'overview' => [
                'total_users' => $totalUsers,
                'active_users' => \App\Models\User::where('created_at', '>=', now()->subDays(30))->count(),
                'total_researchers' => $totalResearchers,
                'total_projects' => $totalProjects,
                'active_projects' => $activeProjects,
                'total_publications' => $totalPublications,
                'total_equipment' => $totalEquipment,
                'equipment_in_use' => $equipmentInUse,
                'upcoming_events' => \App\Models\Event::where('start_date', '>=', now())->count(),
                'pending_requests' => \App\Models\EquipmentReservation::where('status', 'pending')->count(),
                'monthly_projects' => \App\Models\Project::whereMonth('created_at', now()->month)->count(),
                'research_domains' => \App\Models\Researcher::distinct('research_domain')->count('research_domain'),
            ],
            'recent_activity' => [
                'new_users' => \App\Models\User::latest()->limit(5)->get(),
                'recent_projects' => \App\Models\Project::with('leader')->latest()->limit(5)->get(),
                'recent_publications' => \App\Models\Publication::latest()->limit(5)->get(),
            ],
            'equipment_status' => $equipmentStatus,
            'charts' => [
                'users_by_role' => \App\Models\User::selectRaw('role, COUNT(*) as count')
                    ->groupBy('role')->pluck('count', 'role'),
                'projects_by_status' => \App\Models\Project::selectRaw('status, COUNT(*) as count')
                    ->groupBy('status')->pluck('count', 'status'),
                'monthly_projects' => implode(', ', $monthlyProjects),
                'monthly_publications' => implode(', ', $monthlyPublications),
                'projects_trend' => $monthlyProjects,
                'publications_trend' => $monthlyPublications,
            ],
            'trends' => [
                'projects' => $this->calculateGrowthPercentage(\App\Models\Project::class),
                'publications' => $this->calculateGrowthPercentage(\App\Models\Publication::class),
                'researchers' => $this->calculateGrowthPercentage(\App\Models\Researcher::class),
                'equipment_utilization' => $totalEquipment > 0 ? round(($equipmentInUse / $totalEquipment) * 100) : 0,
            ]
        ];
    }

    /**
     * Calculate growth percentage for a model
     */
    private function calculateGrowthPercentage(string $model): int
    {
        $thisMonth = $model::whereMonth('created_at', now()->month)->count();
        $lastMonth = $model::whereMonth('created_at', now()->subMonth()->month)->count();

        if ($lastMonth == 0) return $thisMonth > 0 ? 100 : 0;

        return round((($thisMonth - $lastMonth) / $lastMonth) * 100);
    }

    /**
     * Get lab manager dashboard data
     */
    private function getLabManagerDashboard(): array
    {
        return [
            'overview' => [
                'total_equipment' => \App\Models\Equipment::count(),
                'available_equipment' => \App\Models\Equipment::where('status', 'available')->count(),
                'pending_reservations' => \App\Models\EquipmentReservation::where('status', 'pending')->count(),
                'maintenance_due' => \App\Models\Equipment::where('warranty_expiry', '<=', now()->addMonths(1))->count(),
            ],
            'equipment_status' => \App\Models\Equipment::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')->pluck('count', 'status'),
            'recent_reservations' => \App\Models\EquipmentReservation::with(['equipment', 'researcher'])
                ->latest()->limit(10)->get(),
            'pending_approvals' => \App\Models\EquipmentReservation::with(['equipment', 'researcher'])
                ->where('status', 'pending')->latest()->limit(5)->get(),
        ];
    }

    /**
     * Get researcher dashboard data
     */
    private function getResearcherDashboard($user): array
    {
        if (!$user->researcher) {
            return ['message' => 'Complete your researcher profile to view dashboard'];
        }

        $researcher = $user->researcher;

        return [
            'overview' => [
                'total_projects' => $researcher->leadProjects()->count() + $researcher->projects()->count(),
                'active_projects' => $researcher->leadProjects()->where('status', 'active')->count() +
                                  $researcher->projects()->where('status', 'active')->count(),
                'total_publications' => $researcher->publications()->count(),
                'total_collaborations' => $researcher->coordinatedCollaborations()->count(),
                'equipment_reservations' => $researcher->equipmentReservations()->count(),
            ],
            'my_projects' => $researcher->leadProjects()->with('members')->latest()->limit(5)->get(),
            'recent_publications' => $researcher->publications()->latest()->limit(5)->get(),
            'upcoming_reservations' => $researcher->equipmentReservations()
                ->with('equipment')
                ->where('start_datetime', '>=', now())
                ->orderBy('start_datetime')
                ->limit(5)->get(),
            'upcoming_events' => \App\Models\Event::whereHas('registrations', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('start_date', '>=', now())->orderBy('start_date')->limit(5)->get(),
        ];
    }

    /**
     * Get visitor dashboard data - limited to public information only
     */
    private function getVisitorDashboard(): array
    {
        return [
            'public_info' => [
                'total_researchers' => \App\Models\Researcher::count(),
                'total_publications' => \App\Models\Publication::where('status', 'published')->count(),
                'active_collaborations' => \App\Models\Collaboration::where('status', 'active')->count(),
                'upcoming_events' => \App\Models\Event::where('status', 'published')
                    ->where('start_date', '>=', now())->count(),
            ],
            'recent_publications' => \App\Models\Publication::with('authorResearchers')
                ->where('status', 'published')
                ->latest()->limit(6)->get(),
            'upcoming_events' => \App\Models\Event::where('status', 'published')
                ->where('start_date', '>=', now())
                ->orderBy('start_date')->limit(4)->get(),
            'research_domains' => \App\Models\Researcher::selectRaw('research_domain, COUNT(*) as count')
                ->whereNotNull('research_domain')
                ->groupBy('research_domain')
                ->orderBy('count', 'desc')
                ->limit(8)->get(),
        ];
    }

    /**
     * Get allowed actions based on user role
     */
    private function getAllowedActions(string $role): array
    {
        $actions = [
            'admin' => [
                'user_management' => true,
                'system_settings' => true,
                'analytics' => true,
                'all_projects' => true,
                'all_equipment' => true,
                'all_events' => true,
                'all_publications' => true,
                'manage_collaborations' => true,
            ],
            'lab_manager' => [
                'equipment_management' => true,
                'reservation_approval' => true,
                'lab_reports' => true,
                'schedule_events' => true,
                'view_all_reservations' => true,
                'maintenance_management' => true,
            ],
            'researcher' => [
                'create_projects' => true,
                'manage_own_projects' => true,
                'reserve_equipment' => true,
                'create_publications' => true,
                'start_collaborations' => true,
                'view_own_data' => true,
            ],
            'visitor' => [
                'view_public_info' => true,
                'browse_researchers' => true,
                'view_publications' => true,
                'view_events' => true,
                'contact_lab' => true,
            ],
        ];

        return $actions[$role] ?? $actions['visitor'];
    }

    /**
     * Redirect to AdminLTE dashboard
     */
    public function flexy()
    {
        return redirect()->route('dashboard.admin-lte');
    }

    /**
     * Redirect to AdminLTE dashboard
     */
    public function modern()
    {
        return redirect()->route('dashboard.admin-lte');
    }

    /**
     * Redirect to AdminLTE dashboard
     */
    public function admin()
    {
        return redirect()->route('dashboard.admin-lte');
    }

    /**
     * Show AdminLTE dashboard
     */
    public function adminLte(): View
    {
        $user = auth()->user();
        $dashboardData = $this->getAdminDashboard();

        return view('dashboard.admin-lte', compact('dashboardData', 'user'));
    }

    /**
     * Show user profile page
     */
    public function profile(): View
    {
        $user = auth()->user();

        return view('dashboard.profile', compact('user'));
    }

    /**
     * Show notifications page
     */
    public function notifications(): View
    {
        $user = auth()->user();

        // This would typically fetch from a notifications table
        $notifications = collect([
            [
                'id' => 1,
                'title' => 'Project Approved',
                'message' => 'Your project has been approved',
                'type' => 'project_approval',
                'is_read' => false,
                'created_at' => now()->subHours(2),
            ],
            [
                'id' => 2,
                'title' => 'Equipment Reservation Confirmed',
                'message' => 'Your equipment reservation has been confirmed',
                'type' => 'reservation_confirmed',
                'is_read' => true,
                'created_at' => now()->subDays(1),
            ]
        ]);

        return view('dashboard.notifications', compact('notifications'));
    }

    /**
     * Show settings page
     */
    public function settings(): View
    {
        $user = auth()->user();

        return view('dashboard.settings', compact('user'));
    }
}

