@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('System Settings') }}</h1>
            <p class="text-muted mb-0">{{ __('Configure system-wide settings and preferences') }}</p>
        </div>
        <div>
            <button class="btn btn-primary" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i>{{ __('Refresh') }}
            </button>
        </div>
    </div>

    <!-- Settings Cards -->
    <div class="row">
        <!-- General Settings -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2 text-primary"></i>{{ __('General Settings') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Application Name') }}</label>
                        <p class="text-muted mb-0">{{ $settings['general']['app_name'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Application URL') }}</label>
                        <p class="text-muted mb-0">{{ $settings['general']['app_url'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Timezone') }}</label>
                        <p class="text-muted mb-0">{{ $settings['general']['timezone'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Default Locale') }}</label>
                        <p class="text-muted mb-0">{{ $settings['general']['locale'] }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.settings.general') }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-1"></i>{{ __('Edit General Settings') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Email Settings -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-envelope me-2 text-info"></i>{{ __('Email Settings') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Mail Driver') }}</label>
                        <p class="text-muted mb-0">{{ $settings['email']['driver'] ?? 'Not configured' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('From Address') }}</label>
                        <p class="text-muted mb-0">{{ $settings['email']['from_address'] ?? 'Not configured' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('From Name') }}</label>
                        <p class="text-muted mb-0">{{ $settings['email']['from_name'] ?? 'Not configured' }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-info" disabled>
                        <i class="fas fa-edit me-1"></i>{{ __('Edit Email Settings') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shield-alt me-2 text-warning"></i>{{ __('Security Settings') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Password Expiry') }}</label>
                        <p class="text-muted mb-0">{{ $settings['security']['password_expiry_days'] }} {{ __('days') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Max Login Attempts') }}</label>
                        <p class="text-muted mb-0">{{ $settings['security']['max_login_attempts'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Session Timeout') }}</label>
                        <p class="text-muted mb-0">{{ $settings['security']['session_timeout'] }} {{ __('minutes') }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-warning" disabled>
                        <i class="fas fa-edit me-1"></i>{{ __('Edit Security Settings') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Permissions Settings -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users-cog me-2 text-success"></i>{{ __('Permissions Settings') }}
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ __('Manage user roles and permissions for different parts of the system.') }}</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>{{ __('Admin Role Management') }}</li>
                        <li><i class="fas fa-check text-success me-2"></i>{{ __('Lab Manager Permissions') }}</li>
                        <li><i class="fas fa-check text-success me-2"></i>{{ __('Researcher Access Control') }}</li>
                        <li><i class="fas fa-check text-success me-2"></i>{{ __('Visitor Restrictions') }}</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.settings.permissions') }}" class="btn btn-outline-success">
                        <i class="fas fa-users-cog me-1"></i>{{ __('Manage Permissions') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Settings -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>{{ __('Additional Settings') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('admin.settings.notifications') }}" class="text-decoration-none">
                                <div class="card border-0 bg-light h-100 hover-shadow">
                                    <div class="card-body text-center">
                                        <i class="fas fa-bell fa-2x text-primary mb-2"></i>
                                        <h6 class="card-title">{{ __('Notifications') }}</h6>
                                        <p class="card-text small text-muted">{{ __('Configure system notifications') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-decoration-none">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-database fa-2x text-info mb-2"></i>
                                        <h6 class="card-title">{{ __('Database') }}</h6>
                                        <p class="card-text small text-muted">{{ __('Database maintenance tools') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="text-decoration-none">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-upload fa-2x text-success mb-2"></i>
                                        <h6 class="card-title">{{ __('Backup') }}</h6>
                                        <p class="card-text small text-muted">{{ __('System backup configuration') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
</style>
@endsection