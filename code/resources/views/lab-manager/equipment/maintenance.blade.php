@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('Equipment Maintenance') }}</h1>
            <p class="text-muted mb-0">{{ __('Track and manage equipment maintenance schedules') }}</p>
        </div>
        <div>
            <a href="{{ route('lab-manager.equipment') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Equipment') }}
            </a>
            <button class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>{{ __('Schedule Maintenance') }}
            </button>
        </div>
    </div>

    <!-- Maintenance Overview -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                    <h4 class="mb-1">3</h4>
                    <p class="text-muted mb-0">{{ __('Overdue') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h4 class="mb-1">5</h4>
                    <p class="text-muted mb-0">{{ __('Due This Week') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-2x text-info mb-2"></i>
                    <h4 class="mb-1">8</h4>
                    <p class="text-muted mb-0">{{ __('Scheduled') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h4 class="mb-1">12</h4>
                    <p class="text-muted mb-0">{{ __('Completed This Month') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Schedule -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-wrench me-2"></i>{{ __('Maintenance Schedule') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Equipment') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Last Maintenance') }}</th>
                            <th>{{ __('Next Due') }}</th>
                            <th>{{ __('Priority') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-microscope me-2 text-primary"></i>
                                    <div>
                                        <strong>High-Power Microscope</strong><br>
                                        <small class="text-muted">Olympus BX53 - Lab A</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-info">{{ __('Routine') }}</span></td>
                            <td>{{ __('2 weeks ago') }}</td>
                            <td><span class="text-danger">{{ __('3 days overdue') }}</span></td>
                            <td><span class="badge bg-danger">{{ __('High') }}</span></td>
                            <td><span class="badge bg-danger">{{ __('Overdue') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="{{ __('Schedule') }}">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="{{ __('Complete') }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-flask me-2 text-warning"></i>
                                    <div>
                                        <strong>PCR Machine</strong><br>
                                        <small class="text-muted">Bio-Rad T100 - Lab A</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-warning">{{ __('Calibration') }}</span></td>
                            <td>{{ __('1 month ago') }}</td>
                            <td>{{ __('Tomorrow') }}</td>
                            <td><span class="badge bg-warning">{{ __('Medium') }}</span></td>
                            <td><span class="badge bg-warning">{{ __('Due Soon') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="{{ __('Schedule') }}">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="{{ __('Complete') }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-cog me-2 text-success"></i>
                                    <div>
                                        <strong>Centrifuge Unit</strong><br>
                                        <small class="text-muted">Eppendorf 5810R - Lab B</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-info">{{ __('Routine') }}</span></td>
                            <td>{{ __('1 week ago') }}</td>
                            <td>{{ __('Next week') }}</td>
                            <td><span class="badge bg-success">{{ __('Low') }}</span></td>
                            <td><span class="badge bg-info">{{ __('Scheduled') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="{{ __('Schedule') }}">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="{{ __('Complete') }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-thermometer-half me-2 text-info"></i>
                                    <div>
                                        <strong>Spectrophotometer</strong><br>
                                        <small class="text-muted">Thermo NanoDrop - Lab B</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-secondary">{{ __('Inspection') }}</span></td>
                            <td>{{ __('3 days ago') }}</td>
                            <td>{{ __('2 weeks') }}</td>
                            <td><span class="badge bg-success">{{ __('Low') }}</span></td>
                            <td><span class="badge bg-success">{{ __('Up to Date') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="{{ __('Schedule') }}">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="{{ __('Complete') }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-fire me-2 text-danger"></i>
                                    <div>
                                        <strong>Autoclave</strong><br>
                                        <small class="text-muted">Tuttnauer 3870EA - Sterilization</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-danger">{{ __('Safety Check') }}</span></td>
                            <td>{{ __('2 days ago') }}</td>
                            <td><span class="text-danger">{{ __('1 day overdue') }}</span></td>
                            <td><span class="badge bg-danger">{{ __('High') }}</span></td>
                            <td><span class="badge bg-danger">{{ __('Overdue') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="{{ __('Schedule') }}">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="{{ __('Complete') }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-seedling me-2 text-success"></i>
                                    <div>
                                        <strong>Incubator</strong><br>
                                        <small class="text-muted">Thermo Heratherm - Cell Culture</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-info">{{ __('Routine') }}</span></td>
                            <td>{{ __('1 day ago') }}</td>
                            <td>{{ __('1 month') }}</td>
                            <td><span class="badge bg-success">{{ __('Low') }}</span></td>
                            <td><span class="badge bg-success">{{ __('Up to Date') }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="{{ __('Schedule') }}">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="{{ __('Complete') }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-info" title="{{ __('Details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Maintenance Calendar Section -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-calendar me-2"></i>{{ __('Maintenance Calendar') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('Maintenance calendar will be displayed here. Click on dates to schedule maintenance activities.') }}
                    </div>
                    <!-- Calendar component would go here -->
                    <div class="bg-light rounded p-4 text-center">
                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">{{ __('Calendar Component') }}</h6>
                        <p class="text-muted small">{{ __('Interactive maintenance scheduling calendar') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>{{ __('Maintenance Statistics') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('On Schedule') }}</span>
                            <strong class="text-success">68%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-success" style="width: 68%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Due Soon') }}</span>
                            <strong class="text-warning">22%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-warning" style="width: 22%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Overdue') }}</span>
                            <strong class="text-danger">10%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-danger" style="width: 10%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-tools me-2"></i>{{ __('Quick Actions') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>{{ __('Schedule Maintenance') }}
                        </button>
                        <button class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ __('Mark Emergency') }}
                        </button>
                        <button class="btn btn-outline-info btn-sm">
                            <i class="fas fa-file-alt me-1"></i>{{ __('Generate Report') }}
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