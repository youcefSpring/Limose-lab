@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('Lab Manager Dashboard') }}</h1>
            <p class="text-muted mb-0">{{ __('Laboratory operations and management overview') }}</p>
        </div>
        <div>
            <button class="btn btn-primary" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i>{{ __('Refresh') }}
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-microscope fa-3x text-primary mb-2"></i>
                    <h3 class="mb-1">{{ $stats['total_equipment'] ?? '12' }}</h3>
                    <p class="text-muted mb-0">{{ __('Total Equipment') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                    <h3 class="mb-1">{{ $stats['available_equipment'] ?? '8' }}</h3>
                    <p class="text-muted mb-0">{{ __('Available') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-tools fa-3x text-warning mb-2"></i>
                    <h3 class="mb-1">{{ $stats['maintenance_due'] ?? '2' }}</h3>
                    <p class="text-muted mb-0">{{ __('Maintenance Due') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-3x text-info mb-2"></i>
                    <h3 class="mb-1">{{ $stats['upcoming_events'] ?? '5' }}</h3>
                    <p class="text-muted mb-0">{{ __('Upcoming Events') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Equipment Overview -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-microscope me-2"></i>{{ __('Equipment Overview') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('High-Power Microscope') }}
                            <span class="badge bg-success">{{ __('Available') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Centrifuge Unit') }}
                            <span class="badge bg-danger">{{ __('In Use') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('PCR Machine') }}
                            <span class="badge bg-warning">{{ __('Maintenance') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('Spectrophotometer') }}
                            <span class="badge bg-success">{{ __('Available') }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('lab-manager.equipment') }}" class="btn btn-outline-primary">
                        <i class="fas fa-cog me-1"></i>{{ __('Manage Equipment') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>{{ __('Recent Activities') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ __('Equipment Reserved') }}</h6>
                                <p class="text-muted small mb-0">{{ __('Dr. Smith reserved Microscope for 2 hours') }}</p>
                                <small class="text-muted">{{ __('2 hours ago') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ __('Maintenance Scheduled') }}</h6>
                                <p class="text-muted small mb-0">{{ __('PCR Machine maintenance scheduled for tomorrow') }}</p>
                                <small class="text-muted">{{ __('4 hours ago') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ __('Event Created') }}</h6>
                                <p class="text-muted small mb-0">{{ __('Lab Safety Training scheduled for next week') }}</p>
                                <small class="text-muted">{{ __('Yesterday') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions and Alerts -->
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>{{ __('Quick Actions') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('lab-manager.equipment') }}" class="text-decoration-none">
                                <div class="card border-0 bg-primary text-white h-100 hover-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-cog fa-2x mb-2"></i>
                                        <h6 class="card-title">{{ __('Equipment Management') }}</h6>
                                        <p class="card-text small">{{ __('Manage lab equipment') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('lab-manager.events') }}" class="text-decoration-none">
                                <div class="card border-0 bg-info text-white h-100 hover-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-calendar-plus fa-2x mb-2"></i>
                                        <h6 class="card-title">{{ __('Schedule Event') }}</h6>
                                        <p class="card-text small">{{ __('Create lab events') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('lab-manager.reports') }}" class="text-decoration-none">
                                <div class="card border-0 bg-success text-white h-100 hover-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                        <h6 class="card-title">{{ __('View Reports') }}</h6>
                                        <p class="card-text small">{{ __('Lab usage reports') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts and Notifications -->
        <div class="col-lg-4 mb-4">
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Alerts') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning py-2 mb-2">
                        <small><strong>{{ __('Maintenance Due') }}</strong></small><br>
                        <small>{{ __('PCR Machine requires maintenance') }}</small>
                    </div>
                    <div class="alert alert-info py-2 mb-2">
                        <small><strong>{{ __('Low Supplies') }}</strong></small><br>
                        <small>{{ __('Microscope slides running low') }}</small>
                    </div>
                    <div class="alert alert-success py-2 mb-0">
                        <small><strong>{{ __('All Clear') }}</strong></small><br>
                        <small>{{ __('Safety inspection complete') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}
</style>
@endsection