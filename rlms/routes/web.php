<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialCategoryController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ExperimentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MaintenanceLogController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Materials Routes
    Route::resource('materials', MaterialController::class);
    Route::resource('material-categories', MaterialCategoryController::class);

    // Reservations Routes
    Route::resource('reservations', ReservationController::class);
    Route::get('reservations-calendar', [ReservationController::class, 'calendar'])->name('reservations.calendar');
    Route::post('reservations/{reservation}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
    Route::post('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::post('reservations/{reservation}/complete', [ReservationController::class, 'complete'])->name('reservations.complete');

    // Projects Routes
    Route::resource('projects', ProjectController::class);
    Route::get('projects/{project}/members', [ProjectController::class, 'members'])->name('projects.members');

    // Experiments Routes
    Route::resource('experiments', ExperimentController::class);
    Route::post('experiments/{experiment}/upload-file', [ExperimentController::class, 'uploadFile'])->name('experiments.upload-file');
    Route::get('experiments/{experiment}/files/{file}/download', [ExperimentController::class, 'downloadFile'])->name('experiments.download-file');
    Route::delete('experiments/{experiment}/files/{file}', [ExperimentController::class, 'deleteFile'])->name('experiments.delete-file');
    Route::post('experiments/{experiment}/comments', [ExperimentController::class, 'addComment'])->name('experiments.add-comment');

    // Events Routes
    Route::resource('events', EventController::class);
    Route::post('events/{event}/rsvp', [EventController::class, 'rsvp'])->name('events.rsvp');
    Route::delete('events/{event}/rsvp', [EventController::class, 'cancelRsvp'])->name('events.rsvp.cancel');
    Route::post('events/{event}/comments', [EventController::class, 'addComment'])->name('events.add-comment');

    // Maintenance Routes
    Route::resource('maintenance', MaintenanceLogController::class);
    Route::post('maintenance/{maintenance}/complete', [MaintenanceLogController::class, 'complete'])->name('maintenance.complete');

    // Notifications Routes
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Users Routes (Admin only)
    Route::resource('users', UserController::class)->middleware('can:viewAny,App\Models\User');
});

require __DIR__.'/auth.php';
