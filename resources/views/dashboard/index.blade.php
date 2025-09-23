@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-2">{{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}</h1>
                            <p class="mb-0 opacity-75">{{ __('Here\'s what\'s happening in your laboratory today') }}</p>
                        </div>
                        <div class="text-end">
                            <div class="h5 mb-1">{{ now()->format('l, F j, Y') }}</div>
                            <div class="opacity-75">{{ now()->format('g:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-project-diagram fa-2x text-primary mb-2"></i>
                    <h4 class="mb-1">{{ $stats['active_projects'] ?? '8' }}</h4>
                    <p class="text-muted mb-0">{{ __('Active Projects') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-microscope fa-2x text-success mb-2"></i>
                    <h4 class="mb-1">{{ $stats['available_equipment'] ?? '15' }}</h4>
                    <p class="text-muted mb-0">{{ __('Available Equipment') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-2x text-warning mb-2"></i>
                    <h4 class="mb-1">{{ $stats['upcoming_events'] ?? '3' }}</h4>
                    <p class="text-muted mb-0">{{ __('Upcoming Events') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-file-alt fa-2x text-info mb-2"></i>
                    <h4 class="mb-1">{{ $stats['recent_publications'] ?? '12' }}</h4>
                    <p class="text-muted mb-0">{{ __('Recent Publications') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Recent Activities -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>{{ __('Recent Activities') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">{{ __('Project Update: Molecular Biology Research') }}</h6>
                                <p class="timeline-description text-muted">{{ __('New experimental results uploaded by Dr. Sarah Johnson') }}</p>
                                <small class="text-muted">{{ __('2 hours ago') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">{{ __('Equipment Reserved: High-Power Microscope') }}</h6>
                                <p class="timeline-description text-muted">{{ __('Reserved for tomorrow 9:00 AM - 12:00 PM') }}</p>
                                <small class="text-muted">{{ __('4 hours ago') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">{{ __('Event Reminder: Weekly Lab Meeting') }}</h6>
                                <p class="timeline-description text-muted">{{ __('Tomorrow at 2:00 PM in Conference Room A') }}</p>
                                <small class="text-muted">{{ __('6 hours ago') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">{{ __('New Publication: Protein Analysis Study') }}</h6>
                                <p class="timeline-description text-muted">{{ __('Published in Journal of Molecular Biology') }}</p>
                                <small class="text-muted">{{ __('1 day ago') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-secondary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">{{ __('Collaboration Request: University Partners') }}</h6>
                                <p class="timeline-description text-muted">{{ __('New collaboration proposal received') }}</p>
                                <small class="text-muted">{{ __('2 days ago') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>{{ __('Quick Actions') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('projects.create') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                <span>{{ __('New Project') }}</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('equipment.reservations') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-calendar-plus fa-2x mb-2"></i>
                                <span>{{ __('Reserve Equipment') }}</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('events.create') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                                <span>{{ __('Schedule Event') }}</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('publications.create') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-file-plus fa-2x mb-2"></i>
                                <span>{{ __('Add Publication') }}</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('researchers.index') }}" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <span>{{ __('Browse Researchers') }}</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('collaborations.create') }}" class="btn btn-outline-dark w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-handshake fa-2x mb-2"></i>
                                <span>{{ __('New Collaboration') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Today's Schedule -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-calendar-day me-2"></i>{{ __('Today\'s Schedule') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <strong>{{ __('Equipment Check') }}</strong><br>
                                <small class="text-muted">{{ __('9:00 AM - Lab A') }}</small>
                            </div>
                            <span class="badge bg-primary">{{ __('Upcoming') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <strong>{{ __('Research Meeting') }}</strong><br>
                                <small class="text-muted">{{ __('11:00 AM - Conference Room') }}</small>
                            </div>
                            <span class="badge bg-warning">{{ __('In 2 hours') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <strong>{{ __('Lab Safety Training') }}</strong><br>
                                <small class="text-muted">{{ __('2:00 PM - Training Room') }}</small>
                            </div>
                            <span class="badge bg-info">{{ __('Scheduled') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <strong>{{ __('Equipment Maintenance') }}</strong><br>
                                <small class="text-muted">{{ __('4:00 PM - Lab B') }}</small>
                            </div>
                            <span class="badge bg-secondary">{{ __('Optional') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bell me-2"></i>{{ __('Recent Notifications') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-exclamation fa-sm"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>{{ __('Maintenance Required') }}</strong><br>
                                    <small class="text-muted">{{ __('PCR Machine needs calibration') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <div class="bg-success text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-check fa-sm"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>{{ __('Project Approved') }}</strong><br>
                                    <small class="text-muted">{{ __('Funding approved for new study') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                <div class="bg-warning text-white rounded-circle p-2 me-3">
                                    <i class="fas fa-clock fa-sm"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>{{ __('Deadline Reminder') }}</strong><br>
                                    <small class="text-muted">{{ __('Report due in 3 days') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>{{ __('System Status') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>{{ __('Equipment Availability') }}</span>
                            <strong class="text-success">{{ __('85%') }}</strong>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>{{ __('Lab Utilization') }}</span>
                            <strong class="text-warning">{{ __('72%') }}</strong>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 72%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>{{ __('Project Progress') }}</span>
                            <strong class="text-info">{{ __('68%') }}</strong>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: 68%"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <small class="text-muted">{{ __('Last updated: 5 minutes ago') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-marker {
    position: absolute;
    left: -25px;
    top: 5px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    border-left: 3px solid #dee2e6;
}

.timeline-title {
    color: #333;
    margin-bottom: 5px;
}

.timeline-description {
    margin-bottom: 5px;
}

.card {
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-header {
    background: transparent;
    border-bottom: 1px solid #dee2e6;
}

.btn-outline-primary:hover,
.btn-outline-success:hover,
.btn-outline-warning:hover,
.btn-outline-info:hover,
.btn-outline-secondary:hover,
.btn-outline-dark:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
@endsection