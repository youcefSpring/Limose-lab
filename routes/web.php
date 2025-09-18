<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\ResearcherController;
use App\Http\Controllers\Web\ProjectController;
use App\Http\Controllers\Web\PublicationController;
use App\Http\Controllers\Web\EquipmentController;
use App\Http\Controllers\Web\EventController;
use App\Http\Controllers\Web\CollaborationController;
use App\Http\Controllers\Web\FundingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard.index');
    }
    return view('landing');
})->name('home');

// Public Frontend Routes
Route::prefix('frontend')->name('frontend.')->group(function () {
    Route::get('/about', function () { return view('frontend.about'); })->name('about');
    Route::get('/services', function () { return view('frontend.services'); })->name('services');
    Route::get('/research', function () { return view('frontend.research'); })->name('research');
    Route::get('/news', function () { return view('frontend.news'); })->name('news');
    Route::get('/contact', function () { return view('frontend.contact'); })->name('contact');
    Route::post('/contact', function () {
        // Handle contact form submission
        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    })->name('contact.submit');
    Route::get('/publications', function () { return view('frontend.publications'); })->name('publications');
    Route::get('/team', function () { return view('frontend.team'); })->name('team');
    Route::get('/careers', function () { return view('frontend.careers'); })->name('careers');
    Route::get('/privacy', function () { return view('frontend.privacy'); })->name('privacy');
    Route::get('/terms', function () { return view('frontend.terms'); })->name('terms');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function () {
        // Handle login logic
        return redirect()->route('dashboard.index');
    });

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function () {
        // Handle registration logic
        return redirect()->route('dashboard.index');
    });

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        auth()->logout();
        return redirect()->route('home');
    })->name('logout');
});

// Protected Web Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    });

    // Researcher Web Interface
    Route::prefix('researchers')->name('researchers.')->group(function () {
        Route::get('/', [ResearcherController::class, 'index'])->name('index');
        Route::get('/create', [ResearcherController::class, 'create'])->name('create');
        Route::post('/', [ResearcherController::class, 'store'])->name('store');
        Route::get('/search', [ResearcherController::class, 'search'])->name('search');
        Route::get('/{researcher}', [ResearcherController::class, 'show'])->name('show');
        Route::get('/{researcher}/edit', [ResearcherController::class, 'edit'])->name('edit');
        Route::put('/{researcher}', [ResearcherController::class, 'update'])->name('update');
        Route::delete('/{researcher}', [ResearcherController::class, 'destroy'])->name('destroy');
        Route::get('/{researcher}/projects', [ResearcherController::class, 'projects'])->name('projects');
        Route::get('/{researcher}/publications', [ResearcherController::class, 'publications'])->name('publications');
        Route::get('/{researcher}/collaborations', [ResearcherController::class, 'collaborations'])->name('collaborations');
    });

    // Project Web Interface
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('/search', [ProjectController::class, 'search'])->name('search');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
        Route::get('/{project}/members', [ProjectController::class, 'members'])->name('members');
        Route::get('/{project}/publications', [ProjectController::class, 'publications'])->name('publications');
        Route::get('/{project}/timeline', [ProjectController::class, 'timeline'])->name('timeline');
        Route::get('/{project}/reports', [ProjectController::class, 'reports'])->name('reports');
    });

    // Publication Web Interface
    Route::prefix('publications')->name('publications.')->group(function () {
        Route::get('/', [PublicationController::class, 'index'])->name('index');
        Route::get('/create', [PublicationController::class, 'create'])->name('create');
        Route::post('/', [PublicationController::class, 'store'])->name('store');
        Route::get('/search', [PublicationController::class, 'search'])->name('search');
        Route::get('/export', [PublicationController::class, 'export'])->name('export');
        Route::get('/{publication}', [PublicationController::class, 'show'])->name('show');
        Route::get('/{publication}/edit', [PublicationController::class, 'edit'])->name('edit');
        Route::put('/{publication}', [PublicationController::class, 'update'])->name('update');
        Route::delete('/{publication}', [PublicationController::class, 'destroy'])->name('destroy');
        Route::get('/{publication}/authors', [PublicationController::class, 'authors'])->name('authors');
        Route::get('/{publication}/files', [PublicationController::class, 'files'])->name('files');
        Route::get('/{publication}/metrics', [PublicationController::class, 'metrics'])->name('metrics');
        Route::get('/{publication}/citations', [PublicationController::class, 'citations'])->name('citations');
    });

    // Equipment Web Interface
    Route::prefix('equipment')->name('equipment.')->group(function () {
        Route::get('/', [EquipmentController::class, 'index'])->name('index');
        Route::get('/create', [EquipmentController::class, 'create'])->name('create');
        Route::post('/', [EquipmentController::class, 'store'])->name('store');
        Route::get('/search', [EquipmentController::class, 'search'])->name('search');
        Route::get('/reservations', [EquipmentController::class, 'reservations'])->name('reservations');
        Route::get('/calendar', [EquipmentController::class, 'calendar'])->name('calendar');
        Route::get('/{equipment}', [EquipmentController::class, 'show'])->name('show');
        Route::get('/{equipment}/edit', [EquipmentController::class, 'edit'])->name('edit');
        Route::put('/{equipment}', [EquipmentController::class, 'update'])->name('update');
        Route::delete('/{equipment}', [EquipmentController::class, 'destroy'])->name('destroy');
        Route::get('/{equipment}/reserve', [EquipmentController::class, 'reserve'])->name('reserve');
        Route::post('/{equipment}/reserve', [EquipmentController::class, 'storeReservation'])->name('store-reservation');
        Route::get('/{equipment}/maintenance', [EquipmentController::class, 'maintenance'])->name('maintenance');
        Route::get('/{equipment}/usage', [EquipmentController::class, 'usage'])->name('usage');
        Route::get('/{equipment}/availability', [EquipmentController::class, 'checkAvailability'])->name('check-availability');
    });

    // Event Web Interface
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/search', [EventController::class, 'search'])->name('search');
        Route::get('/calendar', [EventController::class, 'calendar'])->name('calendar');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
        Route::post('/{event}/register', [EventController::class, 'register'])->name('register');
        Route::delete('/{event}/unregister', [EventController::class, 'unregister'])->name('unregister');
        Route::get('/{event}/registrations', [EventController::class, 'registrations'])->name('registrations');
        Route::get('/{event}/speakers', [EventController::class, 'speakers'])->name('speakers');
        Route::get('/{event}/agenda', [EventController::class, 'agenda'])->name('agenda');
        Route::get('/{event}/materials', [EventController::class, 'materials'])->name('materials');
        Route::get('/{event}/attendance', [EventController::class, 'attendance'])->name('attendance');
        Route::post('/{event}/attendance', [EventController::class, 'markAttendance'])->name('mark-attendance');
        Route::get('/{event}/export', [EventController::class, 'export'])->name('export');
    });

    // Collaboration Web Interface
    Route::prefix('collaborations')->name('collaborations.')->group(function () {
        Route::get('/', [CollaborationController::class, 'index'])->name('index');
        Route::get('/create', [CollaborationController::class, 'create'])->name('create');
        Route::post('/', [CollaborationController::class, 'store'])->name('store');
        Route::get('/search', [CollaborationController::class, 'search'])->name('search');
        Route::get('/export', [CollaborationController::class, 'export'])->name('export');
        Route::get('/map', [CollaborationController::class, 'map'])->name('map');
        Route::get('/{collaboration}', [CollaborationController::class, 'show'])->name('show');
        Route::get('/{collaboration}/edit', [CollaborationController::class, 'edit'])->name('edit');
        Route::put('/{collaboration}', [CollaborationController::class, 'update'])->name('update');
        Route::delete('/{collaboration}', [CollaborationController::class, 'destroy'])->name('destroy');
        Route::get('/{collaboration}/participants', [CollaborationController::class, 'participants'])->name('participants');
        Route::post('/{collaboration}/participants', [CollaborationController::class, 'addParticipant'])->name('add-participant');
        Route::delete('/{collaboration}/participants/{participantId}', [CollaborationController::class, 'removeParticipant'])->name('remove-participant');
        Route::get('/{collaboration}/projects', [CollaborationController::class, 'projects'])->name('projects');
        Route::get('/{collaboration}/publications', [CollaborationController::class, 'publications'])->name('publications');
        Route::get('/{collaboration}/timeline', [CollaborationController::class, 'timeline'])->name('timeline');
        Route::get('/{collaboration}/agreements', [CollaborationController::class, 'agreements'])->name('agreements');
        Route::get('/{collaboration}/reports', [CollaborationController::class, 'reports'])->name('reports');
    });

    // Funding Web Interface
    Route::prefix('funding')->name('funding.')->group(function () {
        Route::get('/', [FundingController::class, 'index'])->name('index');
        Route::get('/create', [FundingController::class, 'create'])->name('create');
        Route::post('/', [FundingController::class, 'store'])->name('store');
        Route::get('/search', [FundingController::class, 'search'])->name('search');
        Route::get('/export', [FundingController::class, 'export'])->name('export');
        Route::get('/opportunities', [FundingController::class, 'opportunities'])->name('opportunities');
        Route::get('/analytics', [FundingController::class, 'analytics'])->name('analytics');
        Route::get('/dashboard', [FundingController::class, 'dashboard'])->name('dashboard');
        Route::get('/{funding}', [FundingController::class, 'show'])->name('show');
        Route::get('/{funding}/edit', [FundingController::class, 'edit'])->name('edit');
        Route::put('/{funding}', [FundingController::class, 'update'])->name('update');
        Route::delete('/{funding}', [FundingController::class, 'destroy'])->name('destroy');
        Route::get('/{funding}/budget', [FundingController::class, 'budget'])->name('budget');
        Route::get('/{funding}/reports', [FundingController::class, 'reports'])->name('reports');
        Route::get('/{funding}/reports/create', [FundingController::class, 'createReport'])->name('create-report');
        Route::post('/{funding}/reports', [FundingController::class, 'storeReport'])->name('store-report');
        Route::get('/{funding}/expenditures', [FundingController::class, 'expenditures'])->name('expenditures');
        Route::get('/{funding}/timeline', [FundingController::class, 'timeline'])->name('timeline');
    });
});

// Admin Routes (Admin only access)
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // System Settings
    Route::get('/settings', [AdminController::class, 'systemSettings'])->name('settings');
    Route::get('/settings/general', [AdminController::class, 'generalSettings'])->name('settings.general');
    Route::get('/settings/permissions', [AdminController::class, 'permissionsSettings'])->name('settings.permissions');
    Route::get('/settings/notifications', [AdminController::class, 'notificationsSettings'])->name('settings.notifications');

    // Analytics and Reports
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/analytics/users', [AdminController::class, 'userAnalytics'])->name('analytics.users');
    Route::get('/analytics/projects', [AdminController::class, 'projectAnalytics'])->name('analytics.projects');
    Route::get('/analytics/publications', [AdminController::class, 'publicationAnalytics'])->name('analytics.publications');
    Route::get('/analytics/equipment', [AdminController::class, 'equipmentAnalytics'])->name('analytics.equipment');

    // System Logs
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
    Route::get('/logs/system', [AdminController::class, 'systemLogs'])->name('logs.system');
    Route::get('/logs/access', [AdminController::class, 'accessLogs'])->name('logs.access');
    Route::get('/logs/errors', [AdminController::class, 'errorLogs'])->name('logs.errors');

    // File Management
    Route::get('/files', [AdminController::class, 'files'])->name('files');
    Route::get('/files/statistics', [AdminController::class, 'fileStatistics'])->name('files.statistics');
    Route::get('/files/cleanup', [AdminController::class, 'fileCleanup'])->name('files.cleanup');

    // Backup and Maintenance
    Route::get('/maintenance', [AdminController::class, 'maintenance'])->name('maintenance');
    Route::get('/maintenance/backup', [AdminController::class, 'backup'])->name('maintenance.backup');
    Route::get('/maintenance/cache', [AdminController::class, 'cache'])->name('maintenance.cache');
    Route::post('/maintenance/cache/clear', [AdminController::class, 'clearCache'])->name('maintenance.cache.clear');
});

// Lab Manager Routes (Lab Manager access)
Route::middleware(['auth', 'verified', 'role:lab_manager'])->prefix('lab-manager')->name('lab-manager.')->group(function () {

    // Lab Manager Dashboard
    Route::get('/', function () {
        return view('lab-manager.dashboard');
    })->name('dashboard');

    // Equipment Management
    Route::get('/equipment', function () {
        return view('lab-manager.equipment.index');
    })->name('equipment');
    Route::get('/equipment/reservations', function () {
        return view('lab-manager.equipment.reservations');
    })->name('equipment.reservations');
    Route::get('/equipment/maintenance', function () {
        return view('lab-manager.equipment.maintenance');
    })->name('equipment.maintenance');

    // Event Management
    Route::get('/events', function () {
        return view('lab-manager.events.index');
    })->name('events');
    Route::get('/events/calendar', function () {
        return view('lab-manager.events.calendar');
    })->name('events.calendar');

    // Reports
    Route::get('/reports', function () {
        return view('lab-manager.reports.index');
    })->name('reports');
    Route::get('/reports/equipment-usage', function () {
        return view('lab-manager.reports.equipment-usage');
    })->name('reports.equipment-usage');
    Route::get('/reports/event-attendance', function () {
        return view('lab-manager.reports.event-attendance');
    })->name('reports.event-attendance');
});

// Public API Documentation (if needed)
Route::get('/api-docs', function () {
    return view('api-docs.index');
})->name('api-docs');

// Public Frontend Routes
Route::prefix('frontend')->name('frontend.')->group(function () {
    Route::get('/about', function () { return view('frontend.about'); })->name('about');
    Route::get('/services', function () { return view('frontend.services'); })->name('services');
    Route::get('/research', function () { return view('frontend.research'); })->name('research');
    Route::get('/news', function () { return view('frontend.news'); })->name('news');
    Route::get('/contact', function () { return view('frontend.contact'); })->name('contact');
    Route::post('/contact', function () { /* handle contact form */ })->name('contact.submit');
    Route::get('/publications', function () { return view('frontend.publications'); })->name('publications');
    Route::get('/team', function () { return view('frontend.team'); })->name('team');
    Route::get('/careers', function () { return view('frontend.careers'); })->name('careers');
    Route::get('/privacy', function () { return view('frontend.privacy'); })->name('privacy');
    Route::get('/terms', function () { return view('frontend.terms'); })->name('terms');
});

// Language Switching Routes
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'fr', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');
