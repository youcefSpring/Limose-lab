@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('Equipment Usage Reports') }}</h1>
            <p class="text-muted mb-0">{{ __('Detailed analysis of equipment utilization and performance') }}</p>
        </div>
        <div>
            <a href="{{ route('lab-manager.reports') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Reports') }}
            </a>
            <button class="btn btn-success me-2">
                <i class="fas fa-download me-1"></i>{{ __('Export Report') }}
            </button>
            <button class="btn btn-primary">
                <i class="fas fa-print me-1"></i>{{ __('Print') }}
            </button>
        </div>
    </div>

    <!-- Filter Controls -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">{{ __('Date Range') }}</label>
                    <select class="form-select">
                        <option value="7">{{ __('Last 7 days') }}</option>
                        <option value="30" selected>{{ __('Last 30 days') }}</option>
                        <option value="90">{{ __('Last 3 months') }}</option>
                        <option value="365">{{ __('Last year') }}</option>
                        <option value="custom">{{ __('Custom range') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Equipment Type') }}</label>
                    <select class="form-select">
                        <option value="">{{ __('All Equipment') }}</option>
                        <option value="microscopes">{{ __('Microscopes') }}</option>
                        <option value="centrifuges">{{ __('Centrifuges') }}</option>
                        <option value="analyzers">{{ __('Analyzers') }}</option>
                        <option value="other">{{ __('Other') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Location') }}</label>
                    <select class="form-select">
                        <option value="">{{ __('All Locations') }}</option>
                        <option value="lab_a">{{ __('Lab A') }}</option>
                        <option value="lab_b">{{ __('Lab B') }}</option>
                        <option value="storage">{{ __('Storage') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i>{{ __('Apply Filters') }}
                        </button>
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-1"></i>{{ __('Reset') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Usage Overview -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                    <h4 class="mb-1">{{ $stats['total_hours'] ?? '1,247' }}</h4>
                    <p class="text-muted mb-0">{{ __('Total Usage Hours') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-success mb-2"></i>
                    <h4 class="mb-1">{{ $stats['unique_users'] ?? '42' }}</h4>
                    <p class="text-muted mb-0">{{ __('Unique Users') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-2x text-warning mb-2"></i>
                    <h4 class="mb-1">{{ $stats['total_sessions'] ?? '328' }}</h4>
                    <p class="text-muted mb-0">{{ __('Total Sessions') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-percent fa-2x text-info mb-2"></i>
                    <h4 class="mb-1">{{ $stats['utilization_rate'] ?? '78' }}%</h4>
                    <p class="text-muted mb-0">{{ __('Utilization Rate') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Usage Charts -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>{{ __('Usage Trends (Last 30 Days)') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('Usage trend chart will be displayed here. Shows daily equipment usage patterns.') }}
                    </div>
                    <div class="bg-light rounded p-4 text-center" style="height: 300px;">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">{{ __('Usage Trends Chart') }}</h6>
                        <p class="text-muted small">{{ __('Interactive chart showing equipment usage over time') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>{{ __('Equipment Distribution') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Microscopes') }}</span>
                            <strong class="text-primary">35%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-primary" style="width: 35%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Centrifuges') }}</span>
                            <strong class="text-success">28%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-success" style="width: 28%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Analyzers') }}</span>
                            <strong class="text-warning">22%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-warning" style="width: 22%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Other Equipment') }}</span>
                            <strong class="text-info">15%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-info" style="width: 15%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Equipment Usage Table -->
    <div class="card">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-table me-2"></i>{{ __('Detailed Equipment Usage') }}
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Equipment') }}</th>
                            <th>{{ __('Location') }}</th>
                            <th>{{ __('Total Hours') }}</th>
                            <th>{{ __('Sessions') }}</th>
                            <th>{{ __('Avg Session') }}</th>
                            <th>{{ __('Utilization') }}</th>
                            <th>{{ __('Last Used') }}</th>
                            <th>{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-microscope me-2 text-primary"></i>
                                    <div>
                                        <strong>High-Power Microscope</strong><br>
                                        <small class="text-muted">Olympus BX53</small>
                                    </div>
                                </div>
                            </td>
                            <td>Lab A - Room 101</td>
                            <td><strong>156.5h</strong></td>
                            <td>43</td>
                            <td>3.6h</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">87%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-success" style="width: 87%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>2 hours ago</td>
                            <td><span class="badge bg-success">{{ __('Available') }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-cog me-2 text-warning"></i>
                                    <div>
                                        <strong>Centrifuge Unit</strong><br>
                                        <small class="text-muted">Eppendorf 5810R</small>
                                    </div>
                                </div>
                            </td>
                            <td>Lab B - Room 205</td>
                            <td><strong>142.3h</strong></td>
                            <td>67</td>
                            <td>2.1h</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">78%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-warning" style="width: 78%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>Currently in use</td>
                            <td><span class="badge bg-danger">{{ __('In Use') }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-flask me-2 text-info"></i>
                                    <div>
                                        <strong>PCR Machine</strong><br>
                                        <small class="text-muted">Bio-Rad T100</small>
                                    </div>
                                </div>
                            </td>
                            <td>Lab A - Room 103</td>
                            <td><strong>98.7h</strong></td>
                            <td>34</td>
                            <td>2.9h</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">54%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-info" style="width: 54%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>1 day ago</td>
                            <td><span class="badge bg-warning">{{ __('Maintenance') }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-thermometer-half me-2 text-success"></i>
                                    <div>
                                        <strong>Spectrophotometer</strong><br>
                                        <small class="text-muted">Thermo NanoDrop</small>
                                    </div>
                                </div>
                            </td>
                            <td>Lab B - Room 210</td>
                            <td><strong>124.1h</strong></td>
                            <td>56</td>
                            <td>2.2h</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">68%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-success" style="width: 68%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>5 hours ago</td>
                            <td><span class="badge bg-success">{{ __('Available') }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-fire me-2 text-danger"></i>
                                    <div>
                                        <strong>Autoclave</strong><br>
                                        <small class="text-muted">Tuttnauer 3870EA</small>
                                    </div>
                                </div>
                            </td>
                            <td>Sterilization Room</td>
                            <td><strong>89.2h</strong></td>
                            <td>28</td>
                            <td>3.2h</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">49%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-warning" style="width: 49%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>3 hours ago</td>
                            <td><span class="badge bg-success">{{ __('Available') }}</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-seedling me-2 text-success"></i>
                                    <div>
                                        <strong>Incubator</strong><br>
                                        <small class="text-muted">Thermo Heratherm</small>
                                    </div>
                                </div>
                            </td>
                            <td>Cell Culture Room</td>
                            <td><strong>336.8h</strong></td>
                            <td>12</td>
                            <td>28.1h</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">93%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-success" style="width: 93%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>Currently running</td>
                            <td><span class="badge bg-info">{{ __('Occupied') }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection