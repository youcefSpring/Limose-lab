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
     * Show admin dashboard
     */
    public function dashboard(): View
    {
        $dashboardData = [
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

        return view('admin.dashboard', compact('dashboardData'));
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
        $analytics = $this->analyticsService->getSystemAnalytics($filters);

        return view('admin.analytics.index', compact('analytics', 'filters'));
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
}