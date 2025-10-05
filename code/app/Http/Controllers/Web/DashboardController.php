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
    ) {}

    /**
     * Show the application dashboard.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $dashboardData = [];

        switch ($user->role) {
            case 'admin':
                $dashboardData = $this->getAdminDashboard();
                break;
            case 'lab_manager':
                $dashboardData = $this->getLabManagerDashboard();
                break;
            case 'researcher':
                $dashboardData = $this->getResearcherDashboard($user);
                break;
            case 'visitor':
                $dashboardData = $this->getVisitorDashboard();
                break;
        }

        return view('dashboard.index', compact('dashboardData', 'user'));
    }

    /**
     * Get admin dashboard data
     */
    private function getAdminDashboard(): array
    {
        return [
            'overview' => [
                'total_users' => \App\Models\User::count(),
                'active_users' => \App\Models\User::where('status', 'active')->count(),
                'total_researchers' => \App\Models\Researcher::count(),
                'total_projects' => \App\Models\Project::count(),
                'active_projects' => \App\Models\Project::where('status', 'active')->count(),
                'total_publications' => \App\Models\Publication::count(),
                'total_equipment' => \App\Models\Equipment::count(),
                'upcoming_events' => \App\Models\Event::where('start_date', '>=', now())->count(),
            ],
            'recent_activity' => [
                'new_users' => \App\Models\User::latest()->limit(5)->get(),
                'recent_projects' => \App\Models\Project::with('leader')->latest()->limit(5)->get(),
                'recent_publications' => \App\Models\Publication::latest()->limit(5)->get(),
            ],
            'charts' => [
                'users_by_role' => \App\Models\User::selectRaw('role, COUNT(*) as count')
                    ->groupBy('role')->pluck('count', 'role'),
                'projects_by_status' => \App\Models\Project::selectRaw('status, COUNT(*) as count')
                    ->groupBy('status')->pluck('count', 'status'),
            ]
        ];
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
     * Get visitor dashboard data
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
                ->latest()->limit(10)->get(),
            'upcoming_events' => \App\Models\Event::where('status', 'published')
                ->where('start_date', '>=', now())
                ->orderBy('start_date')->limit(5)->get(),
            'research_domains' => \App\Models\Researcher::selectRaw('research_domain, COUNT(*) as count')
                ->groupBy('research_domain')
                ->orderBy('count', 'desc')
                ->limit(10)->get(),
        ];
    }

    /**
     * Show user profile page
     */
    public function profile(): View
    {
        $user = auth()->user();
        $profile = $this->authService->getUserProfile($user);

        return view('dashboard.profile', compact('user', 'profile'));
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

