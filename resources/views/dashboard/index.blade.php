@extends('layouts.app')

@section('content')
<div id="dashboard-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark">{{ __('Dashboard') }}</h1>
            <p class="text-muted mb-0">{{ __('Welcome back, :name', ['name' => auth()->user()->name]) }}</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary" id="refreshDashboard">
                <i class="fas fa-sync-alt me-2"></i>{{ __('Refresh') }}
            </button>
            <button type="button" class="btn btn-outline-secondary" id="exportDashboard">
                <i class="fas fa-download me-2"></i>{{ __('Export') }}
            </button>
        </div>
    </div>

    <!-- Role-based Dashboard Content -->
    @if(auth()->user()->isAdmin())
        @include('dashboard.partials.admin-dashboard')
    @elseif(auth()->user()->isLabManager())
        @include('dashboard.partials.lab-manager-dashboard')
    @elseif(auth()->user()->isResearcher())
        @include('dashboard.partials.researcher-dashboard')
    @else
        @include('dashboard.partials.visitor-dashboard')
    @endif

    <!-- System Activity Chart -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2 text-primary"></i>{{ __('System Activity') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="activityChart" style="height: 300px;"></div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">{{ __('Recent Activities') }}</h6>
                            <div id="recentActivitiesList" class="list-group list-group-flush">
                                <div class="text-center text-muted py-3">
                                    <i class="fas fa-spinner fa-spin me-2"></i>{{ __('Loading...') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    let dashboardData = @json($dashboardData ?? []);
    let activityChart = null;

    // Initialize dashboard
    initializeDashboard();

    // Refresh button handler
    $('#refreshDashboard').on('click', function() {
        refreshDashboardData();
    });

    // Export button handler
    $('#exportDashboard').on('click', function() {
        exportDashboard();
    });

    function initializeDashboard() {
        loadRecentActivities();
        initializeActivityChart();
    }

    function refreshDashboardData() {
        const btn = $('#refreshDashboard');
        const originalHtml = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __("Refreshing...") }}').prop('disabled', true);

        showLoading();

        $.get('/api/v1/analytics/dashboard')
            .done(function(response) {
                if (response.status === 'success') {
                    dashboardData = response.data;
                    updateDashboardStats();
                    loadRecentActivities();
                    updateActivityChart();

                    // Show success message
                    showAlert('success', '{{ __("Dashboard data refreshed successfully") }}');
                }
            })
            .fail(function(xhr) {
                console.error('Failed to refresh dashboard:', xhr);
                showAlert('danger', '{{ __("Failed to refresh dashboard data") }}');
            })
            .always(function() {
                btn.html(originalHtml).prop('disabled', false);
                hideLoading();
            });
    }

    function loadRecentActivities() {
        const container = $('#recentActivitiesList');

        $.get('/api/v1/analytics/recent-activities')
            .done(function(response) {
                container.empty();

                if (response.status === 'success' && response.data.activities) {
                    const activities = response.data.activities;

                    if (activities.length === 0) {
                        container.html('<div class="text-center text-muted py-3">{{ __("No recent activities") }}</div>');
                        return;
                    }

                    activities.forEach(function(activity) {
                        const activityItem = $(`
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 32px; height: 32px; background-color: ${getActivityColor(activity.type)};">
                                            <i class="${getActivityIcon(activity.type)} text-white" style="font-size: 12px;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium">${activity.description}</div>
                                        <small class="text-muted">${formatDateTime(activity.created_at)}</small>
                                    </div>
                                </div>
                            </div>
                        `);
                        container.append(activityItem);
                    });
                } else {
                    container.html('<div class="text-center text-muted py-3">{{ __("No recent activities") }}</div>');
                }
            })
            .fail(function(xhr) {
                console.error('Failed to load activities:', xhr);
                container.html('<div class="text-center text-danger py-3">{{ __("Failed to load activities") }}</div>');
            });
    }

    function initializeActivityChart() {
        const ctx = document.getElementById('activityChart');
        if (!ctx) return;

        const chartData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: '{{ __("Activities") }}',
                data: [12, 19, 3, 5, 2, 3],
                borderColor: '#1976d2',
                backgroundColor: 'rgba(25, 118, 210, 0.1)',
                tension: 0.4,
                fill: true
            }]
        };

        activityChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    function updateActivityChart() {
        if (activityChart) {
            // Update chart with new data
            activityChart.update();
        }
    }

    function updateDashboardStats() {
        // Update stats cards with new data
        if (dashboardData.overview) {
            Object.keys(dashboardData.overview).forEach(function(key) {
                const element = $(`[data-stat="${key}"]`);
                if (element.length) {
                    element.text(dashboardData.overview[key]);
                }
            });
        }
    }

    function exportDashboard() {
        const btn = $('#exportDashboard');
        const originalHtml = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __("Exporting...") }}').prop('disabled', true);

        $.get('/api/v1/analytics/export', {
                format: 'pdf'
            })
            .done(function(response, status, xhr) {
                // Create download link
                const blob = new Blob([response], { type: 'application/pdf' });
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `dashboard-export-${new Date().toISOString().split('T')[0]}.pdf`);
                document.body.appendChild(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);

                showAlert('success', '{{ __("Dashboard exported successfully") }}');
            })
            .fail(function(xhr) {
                console.error('Export failed:', xhr);
                showAlert('danger', '{{ __("Failed to export dashboard") }}');
            })
            .always(function() {
                btn.html(originalHtml).prop('disabled', false);
            });
    }

    function getActivityIcon(type) {
        const icons = {
            'project_created': 'fas fa-folder-plus',
            'publication_added': 'fas fa-book-plus',
            'equipment_reserved': 'fas fa-calendar-plus',
            'user_registered': 'fas fa-user-plus',
            'event_created': 'fas fa-calendar-star',
            'collaboration_started': 'fas fa-handshake'
        };
        return icons[type] || 'fas fa-info-circle';
    }

    function getActivityColor(type) {
        const colors = {
            'project_created': '#1976d2',
            'publication_added': '#4caf50',
            'equipment_reserved': '#ff9800',
            'user_registered': '#2196f3',
            'event_created': '#9c27b0',
            'collaboration_started': '#009688'
        };
        return colors[type] || '#757575';
    }

    function formatDateTime(dateTime) {
        const date = new Date(dateTime);
        return date.toLocaleString('{{ app()->getLocale() }}', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';

        const alert = $(`
            <div class="alert ${alertClass} alert-dismissible fade show alert-slide" role="alert">
                <i class="${iconClass} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

        $('#dashboard-container').prepend(alert);

        // Auto dismiss after 5 seconds
        setTimeout(function() {
            alert.alert('close');
        }, 5000);
    }
});
</script>
@endpush