@extends('layouts.adminlte')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-dark font-weight-bold">Admin Dashboard</h2>
                <div class="text-muted">
                    <i class="fas fa-calendar-alt mr-2"></i>{{ date('F j, Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Main Stats Row -->
    <div class="row g-4 mb-4">
        <!-- First Row -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Total Users</p>
                            <h3 class="mb-0 text-dark font-weight-bold">{{ $dashboardData['overview']['total_users'] ?? 0 }}</h3>
                        </div>
                        <div class="icon-box bg-gradient-purple">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Researchers</p>
                            <h3 class="mb-0 text-dark font-weight-bold">{{ $dashboardData['overview']['total_researchers'] ?? 0 }}</h3>
                        </div>
                        <div class="icon-box bg-gradient-green">
                            <i class="fas fa-microscope text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Active Projects</p>
                            <h3 class="mb-0 text-dark font-weight-bold">{{ $dashboardData['overview']['active_projects'] ?? 0 }}</h3>
                        </div>
                        <div class="icon-box bg-gradient-orange">
                            <i class="fas fa-project-diagram text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Lab Equipment</p>
                            <h3 class="mb-0 text-dark font-weight-bold">{{ $dashboardData['overview']['total_equipment'] ?? 0 }}</h3>
                        </div>
                        <div class="icon-box bg-gradient-teal">
                            <i class="fas fa-tools text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 secondary-stats">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Equipment in Use</p>
                            <h4 class="mb-0 text-dark">{{ $dashboardData['overview']['equipment_in_use'] ?? 0 }}</h4>
                        </div>
                        <div class="text-gradient-purple">
                            <i class="fas fa-cog fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 secondary-stats">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Upcoming Events</p>
                            <h4 class="mb-0 text-dark">{{ $dashboardData['overview']['upcoming_events'] ?? 0 }}</h4>
                        </div>
                        <div class="text-gradient-green">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 secondary-stats">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Pending Requests</p>
                            <h4 class="mb-0 text-dark">{{ $dashboardData['overview']['pending_requests'] ?? 0 }}</h4>
                        </div>
                        <div class="text-gradient-orange">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 secondary-stats">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Active Users</p>
                            <h4 class="mb-0 text-dark">{{ $dashboardData['overview']['active_users'] ?? 19 }}</h4>
                        </div>
                        <div class="text-gradient-teal">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title text-dark font-weight-bold mb-0">Users by Role</h5>
                </div>
                <div class="card-body pt-3">
                    @if(isset($dashboardData['charts']['users_by_role']) && count($dashboardData['charts']['users_by_role']) > 0)
                        <div class="chart-data">
                            @foreach($dashboardData['charts']['users_by_role'] as $role => $count)
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="role-indicator me-3"></div>
                                        <span class="text-capitalize text-dark">{{ ucfirst(str_replace('_', ' ', $role)) }}</span>
                                    </div>
                                    <span class="badge bg-gradient-purple rounded-pill">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No user data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title text-dark font-weight-bold mb-0">Projects by Status</h5>
                </div>
                <div class="card-body pt-3">
                    @if(isset($dashboardData['charts']['projects_by_status']) && count($dashboardData['charts']['projects_by_status']) > 0)
                        <div class="chart-data">
                            @foreach($dashboardData['charts']['projects_by_status'] as $status => $count)
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="status-indicator me-3
                                            @if($status == 'active') bg-success
                                            @elseif($status == 'completed') bg-primary
                                            @elseif($status == 'pending') bg-warning
                                            @else bg-secondary @endif"></div>
                                        <span class="text-capitalize text-dark">{{ ucfirst($status) }}</span>
                                    </div>
                                    <span class="badge bg-gradient-teal rounded-pill">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No project data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title text-dark font-weight-bold mb-0">Recent Users</h5>
                </div>
                <div class="card-body pt-3">
                    @if(isset($dashboardData['recent_activity']['new_users']) && count($dashboardData['recent_activity']['new_users']) > 0)
                        <div class="activity-list">
                            @foreach($dashboardData['recent_activity']['new_users'] as $user)
                                <div class="d-flex align-items-center py-3 border-bottom">
                                    <div class="avatar-circle bg-gradient-purple me-3">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="font-weight-bold text-dark">{{ $user->name }}</div>
                                        <div class="text-muted small">{{ $user->email }}</div>
                                        <div class="text-muted small">{{ $user->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No recent users</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title text-dark font-weight-bold mb-0">Recent Projects</h5>
                </div>
                <div class="card-body pt-3">
                    @if(isset($dashboardData['recent_activity']['recent_projects']) && count($dashboardData['recent_activity']['recent_projects']) > 0)
                        <div class="activity-list">
                            @foreach($dashboardData['recent_activity']['recent_projects'] as $project)
                                <div class="d-flex align-items-center py-3 border-bottom">
                                    <div class="avatar-circle bg-gradient-teal me-3">
                                        <i class="fas fa-project-diagram text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="font-weight-bold text-dark">{{ $project->title }}</div>
                                        @if($project->leader)
                                            <div class="text-muted small">Leader: {{ $project->leader->name }}</div>
                                        @endif
                                        <div class="text-muted small">{{ $project->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No recent projects</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title text-dark font-weight-bold mb-0">Recent Publications</h5>
                </div>
                <div class="card-body pt-3">
                    @if(isset($dashboardData['recent_activity']['recent_publications']) && count($dashboardData['recent_activity']['recent_publications']) > 0)
                        <div class="activity-list">
                            @foreach($dashboardData['recent_activity']['recent_publications'] as $publication)
                                <div class="d-flex align-items-center py-3 border-bottom">
                                    <div class="avatar-circle bg-gradient-orange me-3">
                                        <i class="fas fa-book text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="font-weight-bold text-dark">{{ $publication->title }}</div>
                                        <div class="text-muted small">{{ $publication->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No recent publications</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title text-dark font-weight-bold mb-0">Quick Actions</h5>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.users') }}" class="btn btn-gradient-purple w-100 py-3 quick-action-btn text-white">
                                <i class="fas fa-users fa-lg mb-2 d-block"></i>
                                <span class="d-block">Manage Users</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.settings') }}" class="btn btn-gradient-green w-100 py-3 quick-action-btn text-white">
                                <i class="fas fa-cog fa-lg mb-2 d-block"></i>
                                <span class="d-block">System Settings</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.analytics') }}" class="btn btn-gradient-orange w-100 py-3 quick-action-btn text-white">
                                <i class="fas fa-chart-bar fa-lg mb-2 d-block"></i>
                                <span class="d-block">Analytics</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.maintenance') }}" class="btn btn-gradient-teal w-100 py-3 quick-action-btn text-white">
                                <i class="fas fa-tools fa-lg mb-2 d-block"></i>
                                <span class="d-block">Maintenance</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Stats Cards */
.stats-card {
    transition: transform 0.2s ease-in-out;
}

.stats-card:hover {
    transform: translateY(-2px);
}

.icon-box {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.secondary-stats {
    background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
}

/* Avatar Circles */
.avatar-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

/* Gradient Colors */
.bg-gradient-purple {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-green {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.bg-gradient-orange {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.bg-gradient-teal {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.text-gradient-purple {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
}

.text-gradient-green {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
}

.text-gradient-orange {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
}

.text-gradient-teal {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
}

.btn-gradient-purple {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-gradient-green {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    border: none;
}

.btn-gradient-orange {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border: none;
}

.btn-gradient-teal {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    border: none;
}

/* Chart Indicators */
.role-indicator, .status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.status-indicator.bg-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
}
.status-indicator.bg-primary {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
}
.status-indicator.bg-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
}
.status-indicator.bg-secondary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

/* Activity Lists */
.activity-list .border-bottom:last-child {
    border-bottom: none !important;
}

/* Quick Action Buttons */
.quick-action-btn {
    border-radius: 12px;
    transition: all 0.3s ease;
    text-decoration: none;
    border-width: 2px;
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Card Styling */
.card {
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    padding: 1.25rem 1.5rem 0.75rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .icon-box {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .quick-action-btn {
        padding: 1rem !important;
    }
}

/* Bootstrap 5 gap utility fallback */
.g-4 > * {
    padding-right: 1.5rem;
    padding-left: 1.5rem;
    margin-bottom: 1.5rem;
}

.g-3 > * {
    padding-right: 1rem;
    padding-left: 1rem;
    margin-bottom: 1rem;
}
</style>
@endsection