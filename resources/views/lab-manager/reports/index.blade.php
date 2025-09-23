@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('Reports & Analytics') }}</h1>
            <p class="text-muted mb-0">{{ __('Generate and view laboratory reports and analytics') }}</p>
        </div>
        <div>
            <button class="btn btn-success me-2">
                <i class="fas fa-download me-1"></i>{{ __('Export All') }}
            </button>
            <button class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>{{ __('Custom Report') }}
            </button>
        </div>
    </div>

    <!-- Report Categories -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-microscope fa-3x text-primary mb-3"></i>
                    <h5>{{ __('Equipment Reports') }}</h5>
                    <p class="text-muted">{{ __('Usage statistics, maintenance logs, and availability reports') }}</p>
                    <a href="{{ route('lab-manager.reports.equipment-usage') }}" class="btn btn-primary">
                        {{ __('View Reports') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-success">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                    <h5>{{ __('Event Reports') }}</h5>
                    <p class="text-muted">{{ __('Attendance tracking, event analysis, and participation metrics') }}</p>
                    <a href="{{ route('lab-manager.reports.event-attendance') }}" class="btn btn-success">
                        {{ __('View Reports') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-info">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-3x text-info mb-3"></i>
                    <h5>{{ __('Analytics Dashboard') }}</h5>
                    <p class="text-muted">{{ __('Performance metrics, trends, and detailed insights') }}</p>
                    <button class="btn btn-info">
                        {{ __('View Analytics') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-tachometer-alt me-2"></i>{{ __('Quick Statistics') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $stats['total_users'] ?? '45' }}</h4>
                            <small class="text-muted">{{ __('Active Users') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle p-3 me-3">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $stats['total_experiments'] ?? '128' }}</h4>
                            <small class="text-muted">{{ __('Experiments This Month') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white rounded-circle p-3 me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $stats['avg_usage_hours'] ?? '6.5' }}</h4>
                            <small class="text-muted">{{ __('Avg Daily Usage (hrs)') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-info text-white rounded-circle p-3 me-3">
                            <i class="fas fa-percent"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $stats['efficiency_rate'] ?? '92' }}%</h4>
                            <small class="text-muted">{{ __('Lab Efficiency') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reports -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>{{ __('Recent Reports') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Report Name') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Generated') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>{{ __('Monthly Equipment Usage') }}</strong><br>
                                        <small class="text-muted">{{ __('September 2024 Summary') }}</small>
                                    </td>
                                    <td><span class="badge bg-primary">{{ __('Equipment') }}</span></td>
                                    <td>{{ __('2 hours ago') }}</td>
                                    <td><span class="badge bg-success">{{ __('Ready') }}</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="{{ __('View') }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-success" title="{{ __('Download') }}">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>{{ __('Event Attendance Report') }}</strong><br>
                                        <small class="text-muted">{{ __('Seminar Series Q3') }}</small>
                                    </td>
                                    <td><span class="badge bg-success">{{ __('Events') }}</span></td>
                                    <td>{{ __('1 day ago') }}</td>
                                    <td><span class="badge bg-success">{{ __('Ready') }}</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="{{ __('View') }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-success" title="{{ __('Download') }}">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>{{ __('Maintenance Schedule') }}</strong><br>
                                        <small class="text-muted">{{ __('Quarterly Review') }}</small>
                                    </td>
                                    <td><span class="badge bg-warning">{{ __('Maintenance') }}</span></td>
                                    <td>{{ __('3 days ago') }}</td>
                                    <td><span class="badge bg-warning">{{ __('Processing') }}</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-secondary" disabled>
                                                <i class="fas fa-clock"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>{{ __('User Activity Summary') }}</strong><br>
                                        <small class="text-muted">{{ __('Weekly Overview') }}</small>
                                    </td>
                                    <td><span class="badge bg-info">{{ __('Analytics') }}</span></td>
                                    <td>{{ __('1 week ago') }}</td>
                                    <td><span class="badge bg-success">{{ __('Ready') }}</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="{{ __('View') }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-success" title="{{ __('Download') }}">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>{{ __('Report Settings') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Auto-Generate Reports') }}</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label">{{ __('Monthly Reports') }}</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label">{{ __('Weekly Summaries') }}</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label">{{ __('Daily Alerts') }}</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Email Recipients') }}</label>
                        <input type="email" class="form-control" placeholder="{{ __('admin@lab.com') }}">
                    </div>
                    <button class="btn btn-primary btn-sm w-100">
                        {{ __('Save Settings') }}
                    </button>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-calendar-check me-2"></i>{{ __('Scheduled Reports') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <small class="fw-bold">{{ __('Equipment Usage') }}</small><br>
                                <small class="text-muted">{{ __('Every Monday at 9 AM') }}</small>
                            </div>
                            <span class="badge bg-primary">{{ __('Active') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <small class="fw-bold">{{ __('Monthly Summary') }}</small><br>
                                <small class="text-muted">{{ __('1st of each month') }}</small>
                            </div>
                            <span class="badge bg-primary">{{ __('Active') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <small class="fw-bold">{{ __('Maintenance Alerts') }}</small><br>
                                <small class="text-muted">{{ __('As needed') }}</small>
                            </div>
                            <span class="badge bg-warning">{{ __('Paused') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection