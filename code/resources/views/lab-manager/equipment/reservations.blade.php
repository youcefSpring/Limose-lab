@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('Equipment Reservations') }}</h1>
            <p class="text-muted mb-0">{{ __('Manage equipment booking and reservations') }}</p>
        </div>
        <div>
            <a href="{{ route('lab-manager.equipment') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Equipment') }}
            </a>
            <button class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>{{ __('New Reservation') }}
            </button>
        </div>
    </div>

    <!-- Reservation Overview -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-2x text-info mb-2"></i>
                    <h4 class="mb-1">8</h4>
                    <p class="text-muted mb-0">{{ __('Today') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h4 class="mb-1">3</h4>
                    <p class="text-muted mb-0">{{ __('Active Now') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-plus fa-2x text-primary mb-2"></i>
                    <h4 class="mb-1">15</h4>
                    <p class="text-muted mb-0">{{ __('This Week') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-percentage fa-2x text-success mb-2"></i>
                    <h4 class="mb-1">87%</h4>
                    <p class="text-muted mb-0">{{ __('Utilization') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Reservations -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-clock me-2 text-warning"></i>{{ __('Active Reservations') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="card border-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0">{{ __('High-Power Microscope') }}</h6>
                                <span class="badge bg-warning">{{ __('In Use') }}</span>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">{{ __('User:') }}</small> <strong>Dr. Smith</strong><br>
                                <small class="text-muted">{{ __('Time:') }}</small> <strong>10:00 AM - 2:00 PM</strong><br>
                                <small class="text-muted">{{ __('Remaining:') }}</small> <strong>1h 30m</strong>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-warning" style="width: 75%"></div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="fas fa-bell me-1"></i>{{ __('Notify') }}
                                </button>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-stop"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card border-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0">{{ __('Centrifuge Unit') }}</h6>
                                <span class="badge bg-info">{{ __('Starting Soon') }}</span>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">{{ __('User:') }}</small> <strong>Dr. Johnson</strong><br>
                                <small class="text-muted">{{ __('Time:') }}</small> <strong>2:00 PM - 4:00 PM</strong><br>
                                <small class="text-muted">{{ __('Starts in:') }}</small> <strong>25 minutes</strong>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-info" style="width: 20%"></div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="fas fa-bell me-1"></i>{{ __('Notify') }}
                                </button>
                                <button class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card border-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0">{{ __('Spectrophotometer') }}</h6>
                                <span class="badge bg-success">{{ __('Just Started') }}</span>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">{{ __('User:') }}</small> <strong>Dr. Lee</strong><br>
                                <small class="text-muted">{{ __('Time:') }}</small> <strong>12:30 PM - 1:30 PM</strong><br>
                                <small class="text-muted">{{ __('Remaining:') }}</strong> <strong>55 minutes</strong>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-success" style="width: 10%"></div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="fas fa-bell me-1"></i>{{ __('Notify') }}
                                </button>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-stop"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- All Reservations -->
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>{{ __('All Reservations') }}
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary active">{{ __('Today') }}</button>
                        <button class="btn btn-sm btn-outline-primary">{{ __('Week') }}</button>
                        <button class="btn btn-sm btn-outline-primary">{{ __('Month') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Equipment') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Time Slot') }}</th>
                            <th>{{ __('Duration') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-microscope me-2 text-primary"></i>
                                    <strong>High-Power Microscope</strong>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>Dr. Smith</strong><br>
                                    <small class="text-muted">Biology Department</small>
                                </div>
                            </td>
                            <td>{{ __('Today') }}</td>
                            <td>10:00 AM - 2:00 PM</td>
                            <td>4 hours</td>
                            <td><span class="badge bg-warning">{{ __('In Progress') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-primary" title="{{ __('Extend') }}">
                                        <i class="fas fa-clock"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" title="{{ __('Cancel') }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-cog me-2 text-success"></i>
                                    <strong>Centrifuge Unit</strong>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>Dr. Johnson</strong><br>
                                    <small class="text-muted">Chemistry Department</small>
                                </div>
                            </td>
                            <td>{{ __('Today') }}</td>
                            <td>2:00 PM - 4:00 PM</td>
                            <td>2 hours</td>
                            <td><span class="badge bg-info">{{ __('Upcoming') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" title="{{ __('Cancel') }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-thermometer-half me-2 text-info"></i>
                                    <strong>Spectrophotometer</strong>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>Dr. Lee</strong><br>
                                    <small class="text-muted">Physics Department</small>
                                </div>
                            </td>
                            <td>{{ __('Today') }}</td>
                            <td>12:30 PM - 1:30 PM</td>
                            <td>1 hour</td>
                            <td><span class="badge bg-success">{{ __('Active') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-primary" title="{{ __('Extend') }}">
                                        <i class="fas fa-clock"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" title="{{ __('End Early') }}">
                                        <i class="fas fa-stop"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-fire me-2 text-danger"></i>
                                    <strong>Autoclave</strong>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>Dr. Brown</strong><br>
                                    <small class="text-muted">Microbiology Department</small>
                                </div>
                            </td>
                            <td>{{ __('Today') }}</td>
                            <td>4:00 PM - 5:00 PM</td>
                            <td>1 hour</td>
                            <td><span class="badge bg-secondary">{{ __('Scheduled') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" title="{{ __('Cancel') }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-seedling me-2 text-success"></i>
                                    <strong>Incubator</strong>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>Dr. Garcia</strong><br>
                                    <small class="text-muted">Genetics Department</small>
                                </div>
                            </td>
                            <td>{{ __('Tomorrow') }}</td>
                            <td>9:00 AM - 12:00 PM</td>
                            <td>3 hours</td>
                            <td><span class="badge bg-primary">{{ __('Confirmed') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" title="{{ __('Cancel') }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Equipment Availability -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-calendar-week me-2"></i>{{ __('Weekly Equipment Schedule') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('Weekly schedule view showing equipment availability and reservations across all days.') }}
                    </div>
                    <!-- Schedule grid would go here -->
                    <div class="bg-light rounded p-4 text-center">
                        <i class="fas fa-calendar-week fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">{{ __('Schedule Grid Component') }}</h6>
                        <p class="text-muted small">{{ __('Interactive weekly equipment booking calendar') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>{{ __('Usage Statistics') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Microscopes') }}</span>
                            <strong>85%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-primary" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Centrifuges') }}</span>
                            <strong>72%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-success" style="width: 72%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Analyzers') }}</span>
                            <strong>68%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-info" style="width: 68%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Others') }}</span>
                            <strong>45%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-warning" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>{{ __('Quick Actions') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>{{ __('New Reservation') }}
                        </button>
                        <button class="btn btn-outline-info btn-sm">
                            <i class="fas fa-calendar-check me-1"></i>{{ __('Check Availability') }}
                        </button>
                        <button class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ __('Emergency Access') }}
                        </button>
                        <button class="btn btn-outline-success btn-sm">
                            <i class="fas fa-download me-1"></i>{{ __('Export Schedule') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection