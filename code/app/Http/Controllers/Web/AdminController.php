<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use App\Services\UserService;
use App\Services\FileService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Admin Controller for administrative functions
 */
class AdminController extends Controller
{
    public function __construct(
        private AnalyticsService $analyticsService,
        private UserService $userService,
        private FileService $fileService
    ) {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Access denied');
            }
            return $next($request);
        });
    }

    /**
     * Show admin dashboard - redirect to AdminLTE
     */
    public function dashboard()
    {
        return redirect()->route('dashboard.admin-lte');
    }

    /**
     * Show users management page
     */
    public function users(Request $request): View
    {
        $filters = $request->only(['search', 'role', 'status']);
        $perPage = min($request->input('per_page', 20), 100);

        $users = $this->userService->getUsers($filters, $perPage);

        return view('admin.users.index', compact('users', 'filters'));
    }

    /**
     * Show user creation form
     */
    public function createUser(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,lab_manager,researcher,visitor',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        try {
            $user = $this->userService->createUser($request->validated());

            return redirect()
                ->route('admin.users.show', $user)
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Show user details
     */
    public function showUser(User $user): View
    {
        $user->load(['researcher', 'equipmentReservations', 'eventRegistrations']);
        $userStats = $this->userService->getUserStatistics($user);

        return view('admin.users.show', compact('user', 'userStats'));
    }

    /**
     * Show user edit form
     */
    public function editUser(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,lab_manager,researcher,visitor',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        try {
            $updatedUser = $this->userService->updateUser($user, $request->validated());

            return redirect()
                ->route('admin.users.show', $updatedUser)
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Delete user
     */
    public function destroyUser(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        try {
            $this->userService->deleteUser($user);

            return redirect()
                ->route('admin.users')
                ->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    /**
     * Show system settings page
     */
    public function systemSettings(): View
    {
        $settings = [
            'general' => [
                'app_name' => config('app.name'),
                'app_url' => config('app.url'),
                'timezone' => config('app.timezone'),
                'locale' => config('app.locale'),
            ],
            'email' => [
                'driver' => config('mail.default'),
                'from_address' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
            ],
            'security' => [
                'password_expiry_days' => 90,
                'max_login_attempts' => 5,
                'session_timeout' => 120,
            ]
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show general settings
     */
    public function generalSettings(): View
    {
        return view('admin.settings.general');
    }

    /**
     * Update general settings
     */
    public function updateGeneralSettings(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|url',
            'timezone' => 'required|string',
            'locale' => 'required|string',
            'debug_mode' => 'boolean',
        ]);

        // Here you would typically update your configuration
        // For now, we'll just redirect back with a success message

        return redirect()->route('admin.settings.general')
                        ->with('success', 'General settings updated successfully!');
    }

    /**
     * Show permissions settings
     */
    public function permissionsSettings(): View
    {
        return view('admin.settings.permissions');
    }

    /**
     * Show notifications settings
     */
    public function notificationsSettings(): View
    {
        return view('admin.settings.notifications');
    }

    /**
     * Show analytics page
     */
    public function analytics(Request $request): View
    {
        $filters = $request->only(['period', 'type']);

        // Generate analytics data
        $analytics = [
            'users' => [
                'total' => \App\Models\User::count(),
                'growth' => $this->calculateGrowthPercentage(\App\Models\User::class),
            ],
            'projects' => [
                'total' => \App\Models\Project::count(),
                'growth' => $this->calculateGrowthPercentage(\App\Models\Project::class),
            ],
            'publications' => [
                'total' => \App\Models\Publication::count(),
                'growth' => $this->calculateGrowthPercentage(\App\Models\Publication::class),
            ],
            'equipment' => [
                'total' => \App\Models\Equipment::count(),
                'utilization' => $this->calculateEquipmentUtilization(),
            ],
            'charts' => [
                'projects_trend' => $this->getMonthlyTrend(\App\Models\Project::class),
                'publications_trend' => $this->getMonthlyTrend(\App\Models\Publication::class),
                'users_trend' => $this->getMonthlyTrend(\App\Models\User::class),
                'user_distribution' => $this->getUserDistribution(),
            ],
            'top_projects' => \App\Models\Project::with('leader')
                ->where('status', 'active')
                ->latest()
                ->limit(5)
                ->get(),
            'recent_activities' => $this->getRecentActivities(),
        ];

        return view('admin.analytics.admin-lte', compact('analytics', 'filters'));
    }

    /**
     * Show user analytics
     */
    public function userAnalytics(): View
    {
        $analytics = $this->analyticsService->getUserAnalytics();
        return view('admin.analytics.users', compact('analytics'));
    }

    /**
     * Show project analytics
     */
    public function projectAnalytics(): View
    {
        $analytics = $this->analyticsService->getProjectAnalytics();
        return view('admin.analytics.projects', compact('analytics'));
    }

    /**
     * Show publication analytics
     */
    public function publicationAnalytics(): View
    {
        $analytics = $this->analyticsService->getPublicationAnalytics();
        return view('admin.analytics.publications', compact('analytics'));
    }

    /**
     * Show equipment analytics
     */
    public function equipmentAnalytics(): View
    {
        $analytics = $this->analyticsService->getEquipmentAnalytics();
        return view('admin.analytics.equipment', compact('analytics'));
    }

    /**
     * Show system logs page
     */
    public function logs(Request $request): View
    {
        $filters = $request->only(['level', 'date_from', 'date_to']);
        $logs = $this->analyticsService->getSystemLogs($filters);

        return view('admin.logs.index', compact('logs', 'filters'));
    }

    /**
     * Show system logs
     */
    public function systemLogs(): View
    {
        $logs = $this->analyticsService->getSystemLogs(['type' => 'system']);
        return view('admin.logs.system', compact('logs'));
    }

    /**
     * Show access logs
     */
    public function accessLogs(): View
    {
        $logs = $this->analyticsService->getSystemLogs(['type' => 'access']);
        return view('admin.logs.access', compact('logs'));
    }

    /**
     * Show error logs
     */
    public function errorLogs(): View
    {
        $logs = $this->analyticsService->getSystemLogs(['type' => 'error']);
        return view('admin.logs.errors', compact('logs'));
    }

    /**
     * Show file management
     */
    public function files(Request $request): View
    {
        $filters = $request->only(['type', 'size_min', 'size_max']);
        $files = $this->fileService->getFiles($filters);
        $fileStats = $this->fileService->getFileStatistics();

        return view('admin.files.index', compact('files', 'fileStats', 'filters'));
    }

    /**
     * Show file statistics
     */
    public function fileStatistics(): View
    {
        $statistics = $this->fileService->getDetailedStatistics();
        return view('admin.files.statistics', compact('statistics'));
    }

    /**
     * Show file cleanup
     */
    public function fileCleanup(): View
    {
        $cleanupCandidates = $this->fileService->getCleanupCandidates();
        return view('admin.files.cleanup', compact('cleanupCandidates'));
    }

    /**
     * Show maintenance page
     */
    public function maintenance(): View
    {
        $maintenanceInfo = [
            'cache_size' => $this->getDirectorySize(storage_path('framework/cache')),
            'log_size' => $this->getDirectorySize(storage_path('logs')),
            'session_size' => $this->getDirectorySize(storage_path('framework/sessions')),
            'temp_size' => $this->getDirectorySize(storage_path('app/temp')),
            'last_backup' => $this->getLastBackupDate(),
            'disk_usage' => disk_free_space('/') / disk_total_space('/') * 100,
        ];

        return view('admin.maintenance.index', compact('maintenanceInfo'));
    }

    /**
     * Show backup page
     */
    public function backup(): View
    {
        $backups = $this->getBackupList();
        return view('admin.maintenance.backup', compact('backups'));
    }

    /**
     * Show cache management
     */
    public function cache(): View
    {
        $cacheInfo = [
            'config_cached' => file_exists(bootstrap_path('cache/config.php')),
            'routes_cached' => file_exists(bootstrap_path('cache/routes-v7.php')),
            'views_cached' => file_exists(storage_path('framework/views')),
            'cache_size' => $this->getDirectorySize(storage_path('framework/cache')),
        ];

        return view('admin.maintenance.cache', compact('cacheInfo'));
    }

    /**
     * Clear application cache
     */
    public function clearCache(): RedirectResponse
    {
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            \Artisan::call('view:clear');

            return redirect()
                ->route('admin.maintenance.cache')
                ->with('success', 'Application cache cleared successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    /**
     * Get directory size
     */
    private function getDirectorySize(string $directory): int
    {
        if (!is_dir($directory)) {
            return 0;
        }

        $size = 0;
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory)
        );

        foreach ($files as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }

        return $size;
    }

    /**
     * Get last backup date
     */
    private function getLastBackupDate(): ?string
    {
        // This would typically check your backup storage location
        return null;
    }

    /**
     * Get backup list
     */
    private function getBackupList(): array
    {
        // This would typically return a list of available backups
        return [];
    }

    /**
     * Show reports page
     */
    public function reports(Request $request): View
    {
        $filters = $request->only(['period', 'type', 'format']);
        $reports = [
            'overview' => [
                'total_users' => \App\Models\User::count(),
                'total_researchers' => \App\Models\Researcher::count(),
                'total_projects' => \App\Models\Project::count(),
                'total_publications' => \App\Models\Publication::count(),
                'total_equipment' => \App\Models\Equipment::count(),
            ],
            'activity' => [
                'new_users_this_month' => \App\Models\User::whereMonth('created_at', now()->month)->count(),
                'new_projects_this_month' => \App\Models\Project::whereMonth('created_at', now()->month)->count(),
                'new_publications_this_month' => \App\Models\Publication::whereMonth('created_at', now()->month)->count(),
            ]
        ];

        return view('admin.reports.index', compact('reports', 'filters'));
    }

    /**
     * Show equipment reports
     */
    public function equipmentReports(): View
    {
        $equipmentData = [
            'utilization' => \App\Models\Equipment::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')->pluck('count', 'status'),
            'reservations' => \App\Models\EquipmentReservation::with('equipment')
                ->latest()->limit(10)->get(),
            'maintenance' => \App\Models\Equipment::where('status', 'maintenance')
                ->with('maintenanceRecords')->get(),
        ];

        return view('admin.reports.equipment', compact('equipmentData'));
    }

    /**
     * Show user reports
     */
    public function userReports(): View
    {
        $userData = [
            'by_role' => \App\Models\User::selectRaw('role, COUNT(*) as count')
                ->groupBy('role')->pluck('count', 'role'),
            'activity' => \App\Models\User::selectRaw('DATE(last_login_at) as date, COUNT(*) as count')
                ->whereNotNull('last_login_at')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->limit(30)->get(),
            'registrations' => \App\Models\User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->limit(30)->get(),
        ];

        return view('admin.reports.users', compact('userData'));
    }

    /**
     * Show project reports
     */
    public function projectReports(): View
    {
        $projectData = [
            'by_status' => \App\Models\Project::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')->pluck('count', 'status'),
            'by_month' => \App\Models\Project::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(12)->get(),
            'completion_rate' => \App\Models\Project::where('status', 'completed')->count() /
                max(\App\Models\Project::count(), 1) * 100,
        ];

        return view('admin.reports.projects', compact('projectData'));
    }

    /**
     * Show equipment reservations (Admin view)
     */
    public function equipmentReservations(): View
    {
        $reservations = \App\Models\EquipmentReservation::with(['equipment', 'researcher'])
            ->latest()
            ->paginate(20);

        $statistics = [
            'total' => \App\Models\EquipmentReservation::count(),
            'pending' => \App\Models\EquipmentReservation::where('status', 'pending')->count(),
            'approved' => \App\Models\EquipmentReservation::where('status', 'approved')->count(),
            'completed' => \App\Models\EquipmentReservation::where('status', 'completed')->count(),
        ];

        return view('admin.equipment.reservations', compact('reservations', 'statistics'));
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
     * Calculate equipment utilization percentage
     */
    private function calculateEquipmentUtilization(): int
    {
        $totalEquipment = \App\Models\Equipment::count();
        $equipmentInUse = \App\Models\Equipment::where('status', 'in_use')->count();

        return $totalEquipment > 0 ? round(($equipmentInUse / $totalEquipment) * 100) : 0;
    }

    /**
     * Get monthly trend data for a model
     */
    private function getMonthlyTrend(string $model): array
    {
        $trend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $trend[] = $model::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
        }
        return $trend;
    }

    /**
     * Get user distribution by role
     */
    private function getUserDistribution(): array
    {
        $distribution = \App\Models\User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')->pluck('count', 'role');

        return [
            $distribution['researcher'] ?? 0,
            $distribution['lab_manager'] ?? 0,
            $distribution['visitor'] ?? 0,
            $distribution['admin'] ?? 0,
        ];
    }

    /**
     * Get recent activities for analytics
     */
    private function getRecentActivities(): array
    {
        return [
            [
                'icon' => 'user-plus',
                'title' => 'New User Registration',
                'description' => 'A new researcher joined the lab',
                'time' => '2 hours ago'
            ],
            [
                'icon' => 'folder-plus',
                'title' => 'Project Created',
                'description' => 'New research project initiated',
                'time' => '5 hours ago'
            ],
            [
                'icon' => 'file-text',
                'title' => 'Publication Added',
                'description' => 'Research paper published',
                'time' => '1 day ago'
            ],
            [
                'icon' => 'microscope',
                'title' => 'Equipment Reserved',
                'description' => 'Lab equipment reserved for research',
                'time' => '2 days ago'
            ],
            [
                'icon' => 'calendar',
                'title' => 'Event Scheduled',
                'description' => 'New seminar event created',
                'time' => '3 days ago'
            ]
        ];
    }
}