@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('Notification Settings') }}</h1>
            <p class="text-muted mb-0">{{ __('Configure system notifications and alerts') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.settings') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Settings') }}
            </a>
        </div>
    </div>

    <!-- Notification Categories -->
    <div class="row">
        <!-- Email Notifications -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-envelope me-2 text-primary"></i>{{ __('Email Notifications') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="email_enabled" checked>
                                <label class="form-check-label" for="email_enabled">
                                    {{ __('Enable Email Notifications') }}
                                </label>
                            </div>
                        </div>

                        <div class="border rounded p-3 bg-light">
                            <h6 class="mb-3">{{ __('Email Types:') }}</h6>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="user_registration" checked>
                                <label class="form-check-label" for="user_registration">
                                    {{ __('User Registration') }}
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="project_updates" checked>
                                <label class="form-check-label" for="project_updates">
                                    {{ __('Project Updates') }}
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="equipment_reservations">
                                <label class="form-check-label" for="equipment_reservations">
                                    {{ __('Equipment Reservations') }}
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="funding_alerts" checked>
                                <label class="form-check-label" for="funding_alerts">
                                    {{ __('Funding Alerts') }}
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="system_maintenance">
                                <label class="form-check-label" for="system_maintenance">
                                    {{ __('System Maintenance') }}
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- In-App Notifications -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bell me-2 text-info"></i>{{ __('In-App Notifications') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="inapp_enabled" checked>
                                <label class="form-check-label" for="inapp_enabled">
                                    {{ __('Enable In-App Notifications') }}
                                </label>
                            </div>
                        </div>

                        <div class="border rounded p-3 bg-light">
                            <h6 class="mb-3">{{ __('Notification Types:') }}</h6>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="realtime_updates" checked>
                                <label class="form-check-label" for="realtime_updates">
                                    {{ __('Real-time Updates') }}
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="popup_alerts" checked>
                                <label class="form-check-label" for="popup_alerts">
                                    {{ __('Popup Alerts') }}
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="badge_counters" checked>
                                <label class="form-check-label" for="badge_counters">
                                    {{ __('Badge Counters') }}
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="sound_alerts">
                                <label class="form-check-label" for="sound_alerts">
                                    {{ __('Sound Alerts') }}
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Templates -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-file-alt me-2 text-success"></i>{{ __('Notification Templates') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Template Name') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Last Modified') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('Welcome Email') }}</td>
                            <td><span class="badge bg-primary">{{ __('Email') }}</span></td>
                            <td><span class="badge bg-success">{{ __('Active') }}</span></td>
                            <td>{{ __('2 days ago') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" disabled>
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Project Assignment') }}</td>
                            <td><span class="badge bg-info">{{ __('In-App') }}</span></td>
                            <td><span class="badge bg-success">{{ __('Active') }}</span></td>
                            <td>{{ __('1 week ago') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" disabled>
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Equipment Maintenance') }}</td>
                            <td><span class="badge bg-warning">{{ __('Both') }}</span></td>
                            <td><span class="badge bg-secondary">{{ __('Draft') }}</span></td>
                            <td>{{ __('3 weeks ago') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" disabled>
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Notification Settings -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2 text-warning"></i>{{ __('Advanced Settings') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form>
                        <!-- Notification Frequency -->
                        <div class="mb-3">
                            <label for="notification_frequency" class="form-label">{{ __('Default Notification Frequency') }}</label>
                            <select class="form-select" id="notification_frequency">
                                <option value="immediate">{{ __('Immediate') }}</option>
                                <option value="hourly">{{ __('Hourly Digest') }}</option>
                                <option value="daily" selected>{{ __('Daily Digest') }}</option>
                                <option value="weekly">{{ __('Weekly Summary') }}</option>
                            </select>
                        </div>

                        <!-- Retention Period -->
                        <div class="mb-3">
                            <label for="retention_period" class="form-label">{{ __('Notification Retention Period') }}</label>
                            <select class="form-select" id="retention_period">
                                <option value="7">{{ __('7 days') }}</option>
                                <option value="30" selected>{{ __('30 days') }}</option>
                                <option value="90">{{ __('90 days') }}</option>
                                <option value="365">{{ __('1 year') }}</option>
                            </select>
                        </div>

                        <!-- Max Notifications -->
                        <div class="mb-3">
                            <label for="max_notifications" class="form-label">{{ __('Maximum Notifications per User') }}</label>
                            <input type="number" class="form-control" id="max_notifications" value="100" min="10" max="1000">
                            <div class="form-text">{{ __('Maximum number of unread notifications to keep per user.') }}</div>
                        </div>

                        <!-- Auto-cleanup -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="auto_cleanup" checked>
                                <label class="form-check-label" for="auto_cleanup">
                                    {{ __('Enable Automatic Cleanup') }}
                                </label>
                            </div>
                            <div class="form-text">{{ __('Automatically delete old notifications based on retention period.') }}</div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>{{ __('Save Settings') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>{{ __('Notification Statistics') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Total Sent Today') }}</span>
                            <strong>247</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('This Week') }}</span>
                            <strong>1,563</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Email Delivery Rate') }}</span>
                            <strong>98.2%</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Average Open Rate') }}</span>
                            <strong>76.5%</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>{{ __('Quick Actions') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm" disabled>
                            <i class="fas fa-paper-plane me-1"></i>{{ __('Send Test Email') }}
                        </button>
                        <button class="btn btn-outline-info btn-sm" disabled>
                            <i class="fas fa-broom me-1"></i>{{ __('Clean Old Notifications') }}
                        </button>
                        <button class="btn btn-outline-warning btn-sm" disabled>
                            <i class="fas fa-download me-1"></i>{{ __('Export Logs') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection