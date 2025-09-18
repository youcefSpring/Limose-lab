<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->configureRouteModelBinding();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('uploads', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Configure route model binding for the application.
     */
    protected function configureRouteModelBinding(): void
    {
        // User model binding
        Route::bind('user', function ($value) {
            return \App\Models\User::where('id', $value)
                ->orWhere('email', $value)
                ->firstOrFail();
        });

        // Researcher model binding
        Route::bind('researcher', function ($value) {
            return \App\Models\Researcher::findOrFail($value);
        });

        // Project model binding with slug support
        Route::bind('project', function ($value) {
            return \App\Models\Project::where('id', $value)
                ->orWhere('slug', $value)
                ->firstOrFail();
        });

        // Publication model binding with DOI support
        Route::bind('publication', function ($value) {
            return \App\Models\Publication::where('id', $value)
                ->orWhere('doi', $value)
                ->firstOrFail();
        });

        // Equipment model binding
        Route::bind('equipment', function ($value) {
            return \App\Models\Equipment::findOrFail($value);
        });

        // Equipment Reservation model binding
        Route::bind('reservation', function ($value) {
            return \App\Models\EquipmentReservation::findOrFail($value);
        });

        // Event model binding with slug support
        Route::bind('event', function ($value) {
            return \App\Models\Event::where('id', $value)
                ->orWhere('slug', $value)
                ->firstOrFail();
        });

        // Event Registration model binding
        Route::bind('registration', function ($value) {
            return \App\Models\EventRegistration::findOrFail($value);
        });

        // Collaboration model binding
        Route::bind('collaboration', function ($value) {
            return \App\Models\Collaboration::findOrFail($value);
        });

        // Funding Source model binding
        Route::bind('funding', function ($value) {
            return \App\Models\FundingSource::findOrFail($value);
        });

        // Project Funding model binding
        Route::bind('projectFunding', function ($value) {
            return \App\Models\ProjectFunding::findOrFail($value);
        });

        // File path encoding for secure file access
        Route::bind('encodedPath', function ($value) {
            $decodedPath = base64_decode($value);

            // Validate that the decoded path is safe
            if (strpos($decodedPath, '..') !== false ||
                strpos($decodedPath, '/') === 0 ||
                empty($decodedPath)) {
                abort(404);
            }

            return $decodedPath;
        });
    }
}