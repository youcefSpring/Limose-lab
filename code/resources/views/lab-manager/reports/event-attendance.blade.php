@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('Event Attendance Reports') }}</h1>
            <p class="text-muted mb-0">{{ __('Analyze event participation and attendance patterns') }}</p>
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
                        <option value="30">{{ __('Last 30 days') }}</option>
                        <option value="90" selected>{{ __('Last 3 months') }}</option>
                        <option value="180">{{ __('Last 6 months') }}</option>
                        <option value="365">{{ __('Last year') }}</option>
                        <option value="custom">{{ __('Custom range') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Event Type') }}</label>
                    <select class="form-select">
                        <option value="">{{ __('All Events') }}</option>
                        <option value="seminar">{{ __('Seminars') }}</option>
                        <option value="workshop">{{ __('Workshops') }}</option>
                        <option value="conference">{{ __('Conferences') }}</option>
                        <option value="training">{{ __('Training') }}</option>
                        <option value="meeting">{{ __('Meetings') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Organizer') }}</label>
                    <select class="form-select">
                        <option value="">{{ __('All Organizers') }}</option>
                        <option value="internal">{{ __('Internal') }}</option>
                        <option value="external">{{ __('External') }}</option>
                        <option value="collaborative">{{ __('Collaborative') }}</option>
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

    <!-- Attendance Overview -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                    <h4 class="mb-1">{{ $stats['total_events'] ?? '47' }}</h4>
                    <p class="text-muted mb-0">{{ __('Total Events') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-success mb-2"></i>
                    <h4 class="mb-1">{{ $stats['total_attendees'] ?? '1,324' }}</h4>
                    <p class="text-muted mb-0">{{ __('Total Attendees') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x text-warning mb-2"></i>
                    <h4 class="mb-1">{{ $stats['avg_attendance'] ?? '28' }}</h4>
                    <p class="text-muted mb-0">{{ __('Avg per Event') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-percent fa-2x text-info mb-2"></i>
                    <h4 class="mb-1">{{ $stats['attendance_rate'] ?? '82' }}%</h4>
                    <p class="text-muted mb-0">{{ __('Attendance Rate') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Charts -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-area me-2"></i>{{ __('Attendance Trends (Last 3 Months)') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('Attendance trend chart will be displayed here. Shows weekly attendance patterns across different event types.') }}
                    </div>
                    <div class="bg-light rounded p-4 text-center" style="height: 300px;">
                        <i class="fas fa-chart-area fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">{{ __('Attendance Trends Chart') }}</h6>
                        <p class="text-muted small">{{ __('Interactive chart showing attendance patterns over time') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-doughnut me-2"></i>{{ __('Event Type Distribution') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Seminars') }}</span>
                            <strong class="text-primary">42%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-primary" style="width: 42%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Workshops') }}</span>
                            <strong class="text-success">28%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-success" style="width: 28%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Training Sessions') }}</span>
                            <strong class="text-warning">18%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-warning" style="width: 18%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Conferences') }}</span>
                            <strong class="text-info">12%</strong>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar bg-info" style="width: 12%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Performance Table -->
    <div class="card">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-table me-2"></i>{{ __('Event Performance Details') }}
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Event') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Capacity') }}</th>
                            <th>{{ __('Registered') }}</th>
                            <th>{{ __('Attended') }}</th>
                            <th>{{ __('Attendance Rate') }}</th>
                            <th>{{ __('Rating') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ __('Advanced Microscopy Techniques') }}</strong><br>
                                    <small class="text-muted">{{ __('Dr. Sarah Johnson') }}</small>
                                </div>
                            </td>
                            <td><span class="badge bg-primary">{{ __('Seminar') }}</span></td>
                            <td>Sep 15, 2024</td>
                            <td>50</td>
                            <td>45</td>
                            <td>42</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">93%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-success" style="width: 93%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-1">4.8</span>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ __('Laboratory Safety Workshop') }}</strong><br>
                                    <small class="text-muted">{{ __('Safety Team') }}</small>
                                </div>
                            </td>
                            <td><span class="badge bg-success">{{ __('Workshop') }}</span></td>
                            <td>Sep 12, 2024</td>
                            <td>30</td>
                            <td>28</td>
                            <td>25</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">89%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-success" style="width: 89%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-1">4.6</span>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ __('PCR Techniques Training') }}</strong><br>
                                    <small class="text-muted">{{ __('Dr. Mike Chen') }}</small>
                                </div>
                            </td>
                            <td><span class="badge bg-warning">{{ __('Training') }}</span></td>
                            <td>Sep 8, 2024</td>
                            <td>20</td>
                            <td>18</td>
                            <td>15</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">83%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-warning" style="width: 83%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-1">4.7</span>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ __('Monthly Lab Meeting') }}</strong><br>
                                    <small class="text-muted">{{ __('Lab Management') }}</small>
                                </div>
                            </td>
                            <td><span class="badge bg-secondary">{{ __('Meeting') }}</span></td>
                            <td>Sep 5, 2024</td>
                            <td>40</td>
                            <td>35</td>
                            <td>32</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">91%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-success" style="width: 91%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-1">4.2</span>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ __('Equipment Maintenance Demo') }}</strong><br>
                                    <small class="text-muted">{{ __('Technical Team') }}</small>
                                </div>
                            </td>
                            <td><span class="badge bg-info">{{ __('Demo') }}</span></td>
                            <td>Sep 1, 2024</td>
                            <td>25</td>
                            <td>20</td>
                            <td>16</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">80%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-warning" style="width: 80%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-1">4.4</span>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ __('Research Presentation Day') }}</strong><br>
                                    <small class="text-muted">{{ __('Research Team') }}</small>
                                </div>
                            </td>
                            <td><span class="badge bg-danger">{{ __('Conference') }}</span></td>
                            <td>Aug 28, 2024</td>
                            <td>60</td>
                            <td>55</td>
                            <td>48</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">87%</span>
                                    <div class="progress flex-fill" style="width: 50px;">
                                        <div class="progress-bar bg-success" style="width: 87%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="me-1">4.9</span>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <nav>
                    <ul class="pagination pagination-sm">
                        <li class="page-item disabled">
                            <span class="page-link">{{ __('Previous') }}</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">{{ __('Next') }}</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Additional Insights -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>{{ __('Key Insights') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <strong>{{ __('High Engagement') }}</strong><br>
                        {{ __('Seminars have the highest attendance rate (93% average) and participant satisfaction.') }}
                    </div>
                    <div class="alert alert-warning">
                        <strong>{{ __('Improvement Opportunity') }}</strong><br>
                        {{ __('Training sessions have lower attendance. Consider scheduling flexibility.') }}
                    </div>
                    <div class="alert alert-info">
                        <strong>{{ __('Trending Topic') }}</strong><br>
                        {{ __('Microscopy and imaging events consistently show high demand and ratings.') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-trophy me-2"></i>{{ __('Top Performing Events') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <strong>{{ __('Research Presentation Day') }}</strong><br>
                                <small class="text-muted">{{ __('Rating: 4.9/5') }}</small>
                            </div>
                            <span class="badge bg-success">{{ __('Excellent') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <strong>{{ __('Advanced Microscopy Techniques') }}</strong><br>
                                <small class="text-muted">{{ __('Rating: 4.8/5') }}</small>
                            </div>
                            <span class="badge bg-success">{{ __('Excellent') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <strong>{{ __('PCR Techniques Training') }}</strong><br>
                                <small class="text-muted">{{ __('Rating: 4.7/5') }}</small>
                            </div>
                            <span class="badge bg-primary">{{ __('Great') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection