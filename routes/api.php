<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ResearcherController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\CollaborationController;
use App\Http\Controllers\Api\FundingController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\FileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// API Version 1
Route::prefix('v1')->group(function () {

    // Authentication Routes (Public)
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum');
        Route::get('me', [AuthController::class, 'me'])->middleware('auth:sanctum');
        Route::put('profile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
        Route::put('password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::post('verify-email', [AuthController::class, 'verifyEmail']);
        Route::post('resend-verification', [AuthController::class, 'resendVerification'])->middleware('auth:sanctum');
    });

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {

        // User Management Routes (Admin only)
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('{user}', [UserController::class, 'show']);
            Route::put('{user}', [UserController::class, 'update']);
            Route::delete('{user}', [UserController::class, 'destroy']);
            Route::put('{user}/status', [UserController::class, 'updateStatus']);
            Route::put('{user}/role', [UserController::class, 'updateRole']);
            Route::get('{user}/activity', [UserController::class, 'getActivity']);
        });

        // Researcher Management Routes
        Route::prefix('researchers')->group(function () {
            Route::get('/', [ResearcherController::class, 'index']);
            Route::post('/', [ResearcherController::class, 'store']);
            Route::get('search', [ResearcherController::class, 'search']);
            Route::get('domains', [ResearcherController::class, 'domains']);
            Route::get('institutions', [ResearcherController::class, 'institutions']);
            Route::get('{researcher}', [ResearcherController::class, 'show']);
            Route::put('{researcher}', [ResearcherController::class, 'update']);
            Route::delete('{researcher}', [ResearcherController::class, 'destroy']);
            Route::post('{researcher}/sync-orcid', [ResearcherController::class, 'syncORCID']);
            Route::get('{researcher}/publications', [ResearcherController::class, 'publications']);
            Route::get('{researcher}/projects', [ResearcherController::class, 'projects']);
            Route::get('{researcher}/collaborations', [ResearcherController::class, 'collaborations']);
            Route::get('{researcher}/statistics', [ResearcherController::class, 'statistics']);
            Route::post('{researcher}/upload-photo', [ResearcherController::class, 'uploadPhoto']);
            Route::post('{researcher}/upload-cv', [ResearcherController::class, 'uploadCV']);
        });

        // Project Management Routes
        Route::prefix('projects')->group(function () {
            Route::get('/', [ProjectController::class, 'index']);
            Route::post('/', [ProjectController::class, 'store']);
            Route::get('search', [ProjectController::class, 'search']);
            Route::get('my-projects', [ProjectController::class, 'myProjects']);
            Route::get('{project}', [ProjectController::class, 'show']);
            Route::put('{project}', [ProjectController::class, 'update']);
            Route::delete('{project}', [ProjectController::class, 'destroy']);
            Route::put('{project}/status', [ProjectController::class, 'updateStatus']);
            Route::post('{project}/members', [ProjectController::class, 'addMember']);
            Route::delete('{project}/members/{researcher}', [ProjectController::class, 'removeMember']);
            Route::put('{project}/members/{researcher}/role', [ProjectController::class, 'updateMemberRole']);
            Route::get('{project}/timeline', [ProjectController::class, 'timeline']);
            Route::get('{project}/statistics', [ProjectController::class, 'statistics']);
            Route::post('{project}/documents', [ProjectController::class, 'uploadDocument']);
            Route::get('{project}/documents', [ProjectController::class, 'getDocuments']);
            Route::post('{project}/archive', [ProjectController::class, 'archive']);
        });

        // Publication Management Routes
        Route::prefix('publications')->group(function () {
            Route::get('/', [PublicationController::class, 'index']);
            Route::post('/', [PublicationController::class, 'store']);
            Route::get('search', [PublicationController::class, 'search']);
            Route::get('types', [PublicationController::class, 'types']);
            Route::get('recent', [PublicationController::class, 'recent']);
            Route::get('{publication}', [PublicationController::class, 'show']);
            Route::put('{publication}', [PublicationController::class, 'update']);
            Route::delete('{publication}', [PublicationController::class, 'destroy']);
            Route::put('{publication}/status', [PublicationController::class, 'updateStatus']);
            Route::post('{publication}/authors', [PublicationController::class, 'addAuthor']);
            Route::delete('{publication}/authors/{researcher}', [PublicationController::class, 'removeAuthor']);
            Route::get('{publication}/bibtex', [PublicationController::class, 'exportBibTeX']);
            Route::get('{publication}/citations', [PublicationController::class, 'getCitations']);
            Route::post('{publication}/upload-pdf', [PublicationController::class, 'uploadPDF']);
            Route::post('import-doi', [PublicationController::class, 'importFromDOI']);
            Route::post('import-bibtex', [PublicationController::class, 'importFromBibTeX']);
        });

        // Equipment Management Routes
        Route::prefix('equipment')->group(function () {
            Route::get('/', [EquipmentController::class, 'index']);
            Route::post('/', [EquipmentController::class, 'store']);
            Route::get('search', [EquipmentController::class, 'search']);
            Route::get('categories', [EquipmentController::class, 'categories']);
            Route::get('available', [EquipmentController::class, 'available']);
            Route::get('{equipment}', [EquipmentController::class, 'show']);
            Route::put('{equipment}', [EquipmentController::class, 'update']);
            Route::delete('{equipment}', [EquipmentController::class, 'destroy']);
            Route::put('{equipment}/status', [EquipmentController::class, 'updateStatus']);
            Route::get('{equipment}/availability', [EquipmentController::class, 'checkAvailability']);
            Route::post('{equipment}/upload-photo', [EquipmentController::class, 'uploadPhoto']);
            Route::post('{equipment}/upload-manual', [EquipmentController::class, 'uploadManual']);
            Route::get('{equipment}/maintenance-history', [EquipmentController::class, 'maintenanceHistory']);
        });

        // Equipment Reservation Routes
        Route::prefix('reservations')->group(function () {
            Route::get('/', [EquipmentController::class, 'reservations']);
            Route::post('/', [EquipmentController::class, 'createReservation']);
            Route::get('my-reservations', [EquipmentController::class, 'myReservations']);
            Route::get('{reservation}', [EquipmentController::class, 'showReservation']);
            Route::put('{reservation}', [EquipmentController::class, 'updateReservation']);
            Route::delete('{reservation}', [EquipmentController::class, 'cancelReservation']);
            Route::put('{reservation}/approve', [EquipmentController::class, 'approveReservation']);
            Route::put('{reservation}/reject', [EquipmentController::class, 'rejectReservation']);
            Route::post('{reservation}/check-in', [EquipmentController::class, 'checkIn']);
            Route::post('{reservation}/check-out', [EquipmentController::class, 'checkOut']);
        });

        // Event Management Routes
        Route::prefix('events')->group(function () {
            Route::get('/', [EventController::class, 'index']);
            Route::post('/', [EventController::class, 'store']);
            Route::get('search', [EventController::class, 'search']);
            Route::get('types', [EventController::class, 'types']);
            Route::get('upcoming', [EventController::class, 'upcoming']);
            Route::get('my-events', [EventController::class, 'myEvents']);
            Route::get('{event}', [EventController::class, 'show']);
            Route::put('{event}', [EventController::class, 'update']);
            Route::delete('{event}', [EventController::class, 'destroy']);
            Route::put('{event}/status', [EventController::class, 'updateStatus']);
            Route::post('{event}/register', [EventController::class, 'register']);
            Route::delete('{event}/register', [EventController::class, 'unregister']);
            Route::get('{event}/registrations', [EventController::class, 'registrations']);
            Route::put('{event}/registrations/{registration}/approve', [EventController::class, 'approveRegistration']);
            Route::put('{event}/registrations/{registration}/reject', [EventController::class, 'rejectRegistration']);
            Route::post('{event}/upload-attachment', [EventController::class, 'uploadAttachment']);
            Route::get('{event}/export-attendees', [EventController::class, 'exportAttendees']);
            Route::post('{event}/send-certificates', [EventController::class, 'sendCertificates']);
        });

        // Collaboration Management Routes
        Route::prefix('collaborations')->group(function () {
            Route::get('/', [CollaborationController::class, 'index']);
            Route::post('/', [CollaborationController::class, 'store']);
            Route::get('search', [CollaborationController::class, 'search']);
            Route::get('types', [CollaborationController::class, 'types']);
            Route::get('countries', [CollaborationController::class, 'countries']);
            Route::get('network', [CollaborationController::class, 'networkAnalysis']);
            Route::get('dashboard', [CollaborationController::class, 'coordinatorDashboard']);
            Route::get('{collaboration}', [CollaborationController::class, 'show']);
            Route::put('{collaboration}', [CollaborationController::class, 'update']);
            Route::delete('{collaboration}', [CollaborationController::class, 'destroy']);
            Route::put('{collaboration}/status', [CollaborationController::class, 'updateStatus']);
            Route::post('{collaboration}/invitations', [CollaborationController::class, 'sendInvitation']);
            Route::get('{collaboration}/agreement', [CollaborationController::class, 'generateAgreement']);
            Route::post('{collaboration}/documents', [CollaborationController::class, 'uploadDocument']);
            Route::post('{collaboration}/archive', [CollaborationController::class, 'archive']);
        });

        // Funding Management Routes
        Route::prefix('funding')->group(function () {
            Route::get('/', [FundingController::class, 'index']);
            Route::post('/', [FundingController::class, 'store']);
            Route::get('{funding}', [FundingController::class, 'show']);
            Route::put('{funding}', [FundingController::class, 'update']);
            Route::delete('{funding}', [FundingController::class, 'destroy']);
            Route::get('{funding}/budget', [FundingController::class, 'budget']);
        });

        // Project Funding Routes
        Route::prefix('project-funding')->group(function () {
            Route::post('/', [\App\Http\Controllers\Api\ProjectFundingController::class, 'store']);
            Route::put('{projectFunding}', [\App\Http\Controllers\Api\ProjectFundingController::class, 'update']);
            Route::delete('{projectFunding}', [\App\Http\Controllers\Api\ProjectFundingController::class, 'destroy']);
        });

        // Analytics Routes
        Route::prefix('analytics')->group(function () {
            Route::get('dashboard', [AnalyticsController::class, 'dashboard']);
            Route::get('researchers', [AnalyticsController::class, 'researchers']);
            Route::get('projects', [AnalyticsController::class, 'projects']);
            Route::get('publications', [AnalyticsController::class, 'publications']);
            Route::get('equipment', [AnalyticsController::class, 'equipment']);
            Route::get('personal', [AnalyticsController::class, 'personal']);
        });

        // File Management Routes
        Route::prefix('files')->group(function () {
            Route::post('upload', [FileController::class, 'upload']);
            Route::get('{encodedPath}/download', [FileController::class, 'download']);
            Route::get('{encodedPath}/info', [FileController::class, 'info']);
            Route::delete('{encodedPath}', [FileController::class, 'destroy']);
            Route::post('cleanup', [FileController::class, 'cleanup']);
            Route::get('statistics', [FileController::class, 'statistics']);
        });
    });
});

// Mobile App Routes (for Flutter apps)
Route::prefix('mobile')->group(function () {

    // Public mobile routes
    Route::prefix('v1')->group(function () {
        Route::post('auth/login', [AuthController::class, 'mobileLogin']);
        Route::get('public/researchers', [ResearcherController::class, 'publicList']);
        Route::get('public/publications', [PublicationController::class, 'publicList']);
        Route::get('public/events', [EventController::class, 'publicList']);

        // Mobile protected routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('dashboard', [AnalyticsController::class, 'mobileDashboard']);
            Route::get('notifications', [AuthController::class, 'notifications']);
            Route::put('notifications/{id}/read', [AuthController::class, 'markNotificationRead']);
            Route::get('profile', [AuthController::class, 'mobileProfile']);
            Route::put('profile', [AuthController::class, 'updateMobileProfile']);
        });
    });
});