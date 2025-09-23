@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('General Settings') }}</h1>
            <p class="text-muted mb-0">{{ __('Configure general system settings and preferences') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.settings') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Settings') }}
            </a>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>{{ __('Application Configuration') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.general') }}">
                        @csrf
                        @method('PUT')

                        <!-- Application Name -->
                        <div class="mb-3">
                            <label for="app_name" class="form-label">{{ __('Application Name') }}</label>
                            <input type="text" class="form-control" id="app_name" name="app_name"
                                   value="{{ config('app.name') }}" required>
                            <div class="form-text">{{ __('The name displayed in the application header and emails.') }}</div>
                        </div>

                        <!-- Application URL -->
                        <div class="mb-3">
                            <label for="app_url" class="form-label">{{ __('Application URL') }}</label>
                            <input type="url" class="form-control" id="app_url" name="app_url"
                                   value="{{ config('app.url') }}" required>
                            <div class="form-text">{{ __('The base URL of your application.') }}</div>
                        </div>

                        <!-- Timezone -->
                        <div class="mb-3">
                            <label for="timezone" class="form-label">{{ __('Timezone') }}</label>
                            <select class="form-select" id="timezone" name="timezone" required>
                                <option value="UTC" {{ config('app.timezone') === 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="America/New_York" {{ config('app.timezone') === 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                <option value="America/Chicago" {{ config('app.timezone') === 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                <option value="America/Denver" {{ config('app.timezone') === 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
                                <option value="America/Los_Angeles" {{ config('app.timezone') === 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                                <option value="Europe/London" {{ config('app.timezone') === 'Europe/London' ? 'selected' : '' }}>London</option>
                                <option value="Europe/Paris" {{ config('app.timezone') === 'Europe/Paris' ? 'selected' : '' }}>Paris</option>
                                <option value="Asia/Tokyo" {{ config('app.timezone') === 'Asia/Tokyo' ? 'selected' : '' }}>Tokyo</option>
                            </select>
                            <div class="form-text">{{ __('Default timezone for the application.') }}</div>
                        </div>

                        <!-- Default Locale -->
                        <div class="mb-3">
                            <label for="locale" class="form-label">{{ __('Default Language') }}</label>
                            <select class="form-select" id="locale" name="locale" required>
                                <option value="en" {{ config('app.locale') === 'en' ? 'selected' : '' }}>English</option>
                                <option value="fr" {{ config('app.locale') === 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="ar" {{ config('app.locale') === 'ar' ? 'selected' : '' }}>العربية</option>
                            </select>
                            <div class="form-text">{{ __('Default language for new users.') }}</div>
                        </div>

                        <!-- Debug Mode -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="debug_mode" name="debug_mode"
                                       {{ config('app.debug') ? 'checked' : '' }}>
                                <label class="form-check-label" for="debug_mode">
                                    {{ __('Enable Debug Mode') }}
                                </label>
                            </div>
                            <div class="form-text text-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ __('Debug mode should be disabled in production.') }}
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>{{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Help Card -->
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>{{ __('Configuration Help') }}
                    </h6>
                </div>
                <div class="card-body">
                    <h6>{{ __('Important Notes:') }}</h6>
                    <ul class="small mb-0">
                        <li>{{ __('Changes to these settings require application restart.') }}</li>
                        <li>{{ __('Backup your configuration before making changes.') }}</li>
                        <li>{{ __('Debug mode should always be disabled in production.') }}</li>
                        <li>{{ __('URL changes may affect authentication sessions.') }}</li>
                    </ul>
                </div>
            </div>

            <!-- System Info Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-server me-2"></i>{{ __('System Information') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>{{ __('Laravel Version:') }}</strong>
                        <span class="float-end">{{ app()->version() }}</span>
                    </div>
                    <div class="mb-2">
                        <strong>{{ __('PHP Version:') }}</strong>
                        <span class="float-end">{{ PHP_VERSION }}</span>
                    </div>
                    <div class="mb-2">
                        <strong>{{ __('Environment:') }}</strong>
                        <span class="badge bg-{{ config('app.env') === 'production' ? 'success' : 'warning' }} float-end">
                            {{ config('app.env') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection