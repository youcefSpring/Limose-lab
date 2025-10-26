@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('Lab Events Management') }}</h1>
            <p class="text-muted mb-0">{{ __('Manage laboratory events, training sessions, and meetings') }}</p>
        </div>
        <div>
            <a href="{{ route('lab-manager.events.calendar') }}" class="btn btn-info me-2">
                <i class="fas fa-calendar me-1"></i>{{ __('Calendar View') }}
            </a>
            <button class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>{{ __('Create Event') }}
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-day fa-2x text-primary mb-2"></i>
                    <h4 class="mb-1">5</h4>
                    <p class="text-muted mb-0">{{ __('This Week') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-graduation-cap fa-2x text-warning mb-2"></i>
                    <h4 class="mb-1">3</h4>
                    <p class="text-muted mb-0">{{ __('Training Sessions') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-success mb-2"></i>
                    <h4 class="mb-1">42</h4>
                    <p class="text-muted mb-0">{{ __('Total Attendees') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-info mb-2"></i>
                    <h4 class="mb-1">2</h4>
                    <p class="text-muted mb-0">{{ __('Today') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-clock me-2 text-warning"></i>{{ __('Today\'s Events') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="card border-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0">{{ __('Safety Training Session') }}</h6>
                                <span class="badge bg-warning">{{ __('Starting Soon') }}</span>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted"><i class="fas fa-clock me-1"></i>{{ __('Time:') }}</small> <strong>2:00 PM - 4:00 PM</strong><br>
                                <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ __('Location:') }}</small> <strong>Conference Room A</strong><br>
                                <small class="text-muted"><i class="fas fa-users me-1"></i>{{ __('Attendees:') }}</small> <strong>15 registered</strong>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="fas fa-eye me-1"></i>{{ __('View Details') }}
                                </button>
                                <button class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="card border-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0">{{ __('Equipment Maintenance Review') }}</h6>
                                <span class="badge bg-info">{{ __('Scheduled') }}</span>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted"><i class="fas fa-clock me-1"></i>{{ __('Time:') }}</small> <strong>4:30 PM - 5:30 PM</strong><br>
                                <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ __('Location:') }}</small> <strong>Lab A</strong><br>
                                <small class="text-muted"><i class="fas fa-users me-1"></i>{{ __('Attendees:') }}</small> <strong>8 required</strong>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="fas fa-eye me-1"></i>{{ __('View Details') }}
                                </button>
                                <button class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- All Events -->
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>{{ __('All Events') }}
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="{{ __('Search events...') }}">
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Event') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Date & Time') }}</th>
                            <th>{{ __('Location') }}</th>
                            <th>{{ __('Attendees') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ __('Safety Training Session') }}</strong><br>
                                    <small class="text-muted">{{ __('Mandatory safety protocols and procedures') }}</small>
                                </div>
                            </td>
                            <td><span class="badge bg-danger">{{ __('Training') }}</span></td>
                            <td>
                                <strong>{{ __('Today') }}</strong><br>
                                <small class="text-muted">2:00 PM - 4:00 PM</small>
                            </td>
                            <td>Conference Room A</td>
                            <td>
                                <span class="badge bg-primary">15</span>
                                <small class="text-muted">registered</small>
                            </td>
                            <td><span class="badge bg-warning">{{ __('Starting Soon') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="{{ __('Attendees') }}">
                                        <i class="fas fa-users"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ __('Equipment Maintenance Review') }}</strong><br>
                                    <small class="text-muted">{{ __('Monthly equipment status review meeting') }}</small>
                                </div>
                            </td>
                            <td><span class="badge bg-info">{{ __('Meeting') }}</span></td>
                            <td>
                                <strong>{{ __('Today') }}</strong><br>
                                <small class="text-muted">4:30 PM - 5:30 PM</small>
                            </td>
                            <td>Lab A</td>
                            <td>
                                <span class="badge bg-primary">8</span>
                                <small class="text-muted">required</small>
                            </td>
                            <td><span class="badge bg-info">{{ __('Scheduled') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="{{ __('Attendees') }}">
                                        <i class="fas fa-users"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ __('New Equipment Orientation') }}</strong><br>
                                    <small class="text-muted">{{ __('Training on new microscopy equipment') }}</small>
                                </div>
                            </td>
                            <td><span class="badge bg-success">{{ __('Orientation') }}</span></td>
                            <td>
                                <strong>{{ __('Tomorrow') }}</strong><br>
                                <small class="text-muted">10:00 AM - 12:00 PM</small>
                            </td>
                            <td>Lab B - Room 205</td>
                            <td>
                                <span class="badge bg-primary">12</span>
                                <small class="text-muted">registered</small>
                            </td>
                            <td><span class="badge bg-primary">{{ __('Confirmed') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="{{ __('Attendees') }}">
                                        <i class="fas fa-users"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ __('Lab Safety Inspection') }}</strong><br>
                                    <small class="text-muted">{{ __('Quarterly safety compliance inspection') }}</small>
                                </div>
                            </td>
                            <td><span class="badge bg-warning">{{ __('Inspection') }}</span></td>
                            <td>
                                <strong>{{ __('Next Friday') }}</strong><br>
                                <small class="text-muted">9:00 AM - 11:00 AM</small>
                            </td>
                            <td>All Labs</td>
                            <td>
                                <span class="badge bg-warning">5</span>
                                <small class="text-muted">inspectors</small>
                            </td>
                            <td><span class="badge bg-secondary">{{ __('Pending') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="{{ __('Attendees') }}">
                                        <i class="fas fa-users"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ __('Research Presentation Day') }}</strong><br>
                                    <small class="text-muted">{{ __('Monthly research progress presentations') }}</small>
                                </div>
                            </td>
                            <td><span class="badge bg-purple">{{ __('Presentation') }}</span></td>
                            <td>
                                <strong>{{ __('Next Monday') }}</strong><br>
                                <small class="text-muted">1:00 PM - 5:00 PM</small>
                            </td>
                            <td>Main Auditorium</td>
                            <td>
                                <span class="badge bg-primary">35</span>
                                <small class="text-muted">expected</small>
                            </td>
                            <td><span class="badge bg-primary">{{ __('Confirmed') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="{{ __('Attendees') }}">
                                        <i class="fas fa-users"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Event Categories -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>{{ __('Event Categories') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <i class="fas fa-graduation-cap fa-2x text-danger me-3"></i>
                                <div>
                                    <h6 class="mb-0">{{ __('Training Sessions') }}</h6>
                                    <p class="text-muted small mb-0">{{ __('5 scheduled this month') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <i class="fas fa-users fa-2x text-info me-3"></i>
                                <div>
                                    <h6 class="mb-0">{{ __('Meetings') }}</h6>
                                    <p class="text-muted small mb-0">{{ __('8 scheduled this month') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <i class="fas fa-search fa-2x text-warning me-3"></i>
                                <div>
                                    <h6 class="mb-0">{{ __('Inspections') }}</h6>
                                    <p class="text-muted small mb-0">{{ __('2 scheduled this month') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <i class="fas fa-presentation fa-2x text-success me-3"></i>
                                <div>
                                    <h6 class="mb-0">{{ __('Presentations') }}</h6>
                                    <p class="text-muted small mb-0">{{ __('3 scheduled this month') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>{{ __('Quick Actions') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>{{ __('Create Event') }}
                        </button>
                        <button class="btn btn-outline-info btn-sm">
                            <i class="fas fa-calendar me-1"></i>{{ __('View Calendar') }}
                        </button>
                        <button class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-bell me-1"></i>{{ __('Send Reminders') }}
                        </button>
                        <button class="btn btn-outline-success btn-sm">
                            <i class="fas fa-download me-1"></i>{{ __('Export Events') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-calendar-check me-2"></i>{{ __('This Week') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <small>{{ __('Today - Safety Training') }}</small>
                            <span class="badge bg-warning">2PM</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <small>{{ __('Tomorrow - Equipment Training') }}</small>
                            <span class="badge bg-success">10AM</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <small>{{ __('Friday - Safety Inspection') }}</small>
                            <span class="badge bg-info">9AM</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <small>{{ __('Monday - Presentations') }}</small>
                            <span class="badge bg-primary">1PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-purple {
    background-color: #6f42c1 !important;
}
</style>
@endsection