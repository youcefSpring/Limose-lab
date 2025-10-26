@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('Events Calendar') }}</h1>
            <p class="text-muted mb-0">{{ __('Calendar view of all laboratory events and activities') }}</p>
        </div>
        <div>
            <a href="{{ route('lab-manager.events') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-list me-1"></i>{{ __('List View') }}
            </a>
            <button class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>{{ __('Add Event') }}
            </button>
        </div>
    </div>

    <!-- Calendar Controls -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h5 class="mb-0">{{ __('September 2025') }}</h5>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-calendar-day me-1"></i>{{ __('Today') }}
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end gap-2">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary">{{ __('Month') }}</button>
                            <button class="btn btn-sm btn-outline-primary">{{ __('Week') }}</button>
                            <button class="btn btn-sm btn-outline-primary active">{{ __('Day') }}</button>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i>{{ __('Filter') }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><h6 class="dropdown-header">{{ __('Event Types') }}</h6></li>
                                <li>
                                    <div class="form-check dropdown-item">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">{{ __('Training') }}</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check dropdown-item">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">{{ __('Meetings') }}</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check dropdown-item">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">{{ __('Inspections') }}</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check dropdown-item">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">{{ __('Presentations') }}</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body p-0">
                    <!-- Calendar Header -->
                    <div class="calendar-header">
                        <div class="row g-0 text-center bg-light">
                            <div class="col border-end py-2">
                                <small class="fw-bold text-muted">{{ __('Sunday') }}</small>
                            </div>
                            <div class="col border-end py-2">
                                <small class="fw-bold text-muted">{{ __('Monday') }}</small>
                            </div>
                            <div class="col border-end py-2">
                                <small class="fw-bold text-muted">{{ __('Tuesday') }}</small>
                            </div>
                            <div class="col border-end py-2">
                                <small class="fw-bold text-muted">{{ __('Wednesday') }}</small>
                            </div>
                            <div class="col border-end py-2">
                                <small class="fw-bold text-muted">{{ __('Thursday') }}</small>
                            </div>
                            <div class="col border-end py-2">
                                <small class="fw-bold text-muted">{{ __('Friday') }}</small>
                            </div>
                            <div class="col py-2">
                                <small class="fw-bold text-muted">{{ __('Saturday') }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Body -->
                    <div class="calendar-body">
                        <!-- Week 1 -->
                        <div class="row g-0 border-bottom">
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">1</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">2</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">3</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">4</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">5</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">6</small>
                            </div>
                            <div class="col calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">7</small>
                            </div>
                        </div>

                        <!-- Week 2 -->
                        <div class="row g-0 border-bottom">
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">8</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">9</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">10</small>
                                <div class="event-item bg-info text-white mb-1" title="Equipment Training">
                                    <small>10AM Training</small>
                                </div>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">11</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">12</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">13</small>
                                <div class="event-item bg-warning text-dark mb-1" title="Safety Inspection">
                                    <small>9AM Inspection</small>
                                </div>
                            </div>
                            <div class="col calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">14</small>
                            </div>
                        </div>

                        <!-- Week 3 -->
                        <div class="row g-0 border-bottom">
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">15</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">16</small>
                                <div class="event-item bg-primary text-white mb-1" title="Research Presentations">
                                    <small>1PM Presentations</small>
                                </div>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">17</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">18</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">19</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">20</small>
                            </div>
                            <div class="col calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">21</small>
                            </div>
                        </div>

                        <!-- Week 4 -->
                        <div class="row g-0 border-bottom">
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">22</small>
                            </div>
                            <div class="col border-end calendar-cell p-2 bg-light" style="height: 120px;">
                                <small class="fw-bold text-primary">23</small>
                                <div class="event-item bg-danger text-white mb-1" title="Safety Training">
                                    <small>2PM Safety</small>
                                </div>
                                <div class="event-item bg-success text-white" title="Maintenance Review">
                                    <small>4:30PM Review</small>
                                </div>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">24</small>
                                <div class="event-item bg-success text-white mb-1" title="Equipment Orientation">
                                    <small>10AM Orientation</small>
                                </div>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">25</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">26</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">27</small>
                            </div>
                            <div class="col calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">28</small>
                            </div>
                        </div>

                        <!-- Week 5 -->
                        <div class="row g-0">
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">29</small>
                            </div>
                            <div class="col border-end calendar-cell p-2" style="height: 120px;">
                                <small class="text-muted">30</small>
                            </div>
                            <div class="col border-end calendar-cell p-2 text-muted" style="height: 120px;">
                                <small class="text-muted">1</small>
                            </div>
                            <div class="col border-end calendar-cell p-2 text-muted" style="height: 120px;">
                                <small class="text-muted">2</small>
                            </div>
                            <div class="col border-end calendar-cell p-2 text-muted" style="height: 120px;">
                                <small class="text-muted">3</small>
                            </div>
                            <div class="col border-end calendar-cell p-2 text-muted" style="height: 120px;">
                                <small class="text-muted">4</small>
                            </div>
                            <div class="col calendar-cell p-2 text-muted" style="height: 120px;">
                                <small class="text-muted">5</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-3">
            <!-- Today's Events -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-calendar-day me-2"></i>{{ __('Today\'s Events') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="event-list">
                        <div class="d-flex align-items-start mb-3">
                            <div class="event-time bg-danger text-white">
                                <small>2PM</small>
                            </div>
                            <div class="ms-2">
                                <h6 class="mb-0">{{ __('Safety Training') }}</h6>
                                <small class="text-muted">Conference Room A</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="event-time bg-success text-white">
                                <small>4:30PM</small>
                            </div>
                            <div class="ms-2">
                                <h6 class="mb-0">{{ __('Maintenance Review') }}</h6>
                                <small class="text-muted">Lab A</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Legend -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-palette me-2"></i>{{ __('Event Types') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="legend-item d-flex align-items-center mb-2">
                        <div class="legend-color bg-danger"></div>
                        <span class="ms-2">{{ __('Training Sessions') }}</span>
                    </div>
                    <div class="legend-item d-flex align-items-center mb-2">
                        <div class="legend-color bg-success"></div>
                        <span class="ms-2">{{ __('Meetings') }}</span>
                    </div>
                    <div class="legend-item d-flex align-items-center mb-2">
                        <div class="legend-color bg-warning"></div>
                        <span class="ms-2">{{ __('Inspections') }}</span>
                    </div>
                    <div class="legend-item d-flex align-items-center mb-2">
                        <div class="legend-color bg-primary"></div>
                        <span class="ms-2">{{ __('Presentations') }}</span>
                    </div>
                    <div class="legend-item d-flex align-items-center">
                        <div class="legend-color bg-info"></div>
                        <span class="ms-2">{{ __('Orientations') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>{{ __('Quick Actions') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>{{ __('New Event') }}
                        </button>
                        <button class="btn btn-outline-info btn-sm">
                            <i class="fas fa-eye me-1"></i>{{ __('View All Events') }}
                        </button>
                        <button class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-bell me-1"></i>{{ __('Send Reminders') }}
                        </button>
                        <button class="btn btn-outline-success btn-sm">
                            <i class="fas fa-download me-1"></i>{{ __('Export Calendar') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.calendar-cell {
    position: relative;
    cursor: pointer;
    transition: background-color 0.2s;
}

.calendar-cell:hover {
    background-color: #f8f9fa;
}

.event-item {
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 0.75rem;
    cursor: pointer;
    margin-bottom: 1px;
}

.event-item:hover {
    opacity: 0.8;
}

.event-time {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    min-width: 45px;
    text-align: center;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 3px;
}

.legend-item {
    font-size: 0.875rem;
}

.calendar-header .row > .col {
    border-bottom: 1px solid #dee2e6;
}

.calendar-body .row > .col {
    border-bottom: 1px solid #dee2e6;
}

.calendar-body .row:last-child > .col {
    border-bottom: none;
}
</style>
@endsection