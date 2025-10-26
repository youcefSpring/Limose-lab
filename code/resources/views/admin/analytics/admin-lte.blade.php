@extends('layouts.adminlte')

@section('title', 'Analytics')
@section('page-title', 'Analytics Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item active">Analytics</li>
@endsection

@section('content')
<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Users</span>
        <span class="info-box-number">
          {{ $analytics['users']['total'] ?? 0 }}
          <small class="text-success">+{{ $analytics['users']['growth'] ?? 0 }}%</small>
        </span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-folder"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Projects</span>
        <span class="info-box-number">
          {{ $analytics['projects']['total'] ?? 0 }}
          <small class="text-success">+{{ $analytics['projects']['growth'] ?? 0 }}%</small>
        </span>
      </div>
    </div>
  </div>

  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-alt"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Publications</span>
        <span class="info-box-number">
          {{ $analytics['publications']['total'] ?? 0 }}
          <small class="text-success">+{{ $analytics['publications']['growth'] ?? 0 }}%</small>
        </span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-microscope"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Equipment</span>
        <span class="info-box-number">
          {{ $analytics['equipment']['total'] ?? 0 }}
          <small class="text-info">{{ $analytics['equipment']['utilization'] ?? 0 }}% in use</small>
        </span>
      </div>
    </div>
  </div>
</div>

<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-7 connectedSortable">
    <!-- Activity Trends Chart -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-chart-pie mr-1"></i>
          Activity Trends
        </h3>
        <div class="card-tools">
          <ul class="nav nav-pills ml-auto">
            <li class="nav-item">
              <a class="nav-link active" href="#activity-chart" data-toggle="tab">Line</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#distribution-chart" data-toggle="tab">Distribution</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="card-body">
        <div class="tab-content p-0">
          <div class="chart tab-pane active" id="activity-chart" style="position: relative; height: 300px;">
            <canvas id="activity-trends-chart" height="300" style="height: 300px;"></canvas>
          </div>
          <div class="chart tab-pane" id="distribution-chart" style="position: relative; height: 300px;">
            <canvas id="user-distribution-chart" height="300" style="height: 300px;"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Top Performing Projects -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Top Performing Projects</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Project</th>
                <th>Leader</th>
                <th>Progress</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($analytics['top_projects']))
                @foreach($analytics['top_projects'] as $project)
                <tr>
                  <td>{{ Str::limit($project->title ?? 'N/A', 30) }}</td>
                  <td>{{ $project->leader->name ?? 'N/A' }}</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-{{ $project->status === 'active' ? 'success' : 'warning' }}" style="width: {{ $project->progress ?? rand(25, 95) }}%"></div>
                    </div>
                    <span class="badge badge-{{ $project->status === 'active' ? 'success' : 'warning' }}">{{ $project->progress ?? rand(25, 95) }}%</span>
                  </td>
                  <td>
                    <span class="badge badge-{{ $project->status === 'active' ? 'success' : 'secondary' }}">
                      {{ ucfirst($project->status ?? 'N/A') }}
                    </span>
                  </td>
                </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="4" class="text-center text-muted">No project data available</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- right col -->
  <section class="col-lg-5 connectedSortable">
    <!-- Recent Activities -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-clock mr-1"></i>
          Recent Activities
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="timeline timeline-inverse">
          @if(isset($analytics['recent_activities']))
            @foreach($analytics['recent_activities'] as $activity)
            <!-- timeline time label -->
            <div class="time-label">
              <span class="bg-primary">{{ $activity['time'] }}</span>
            </div>
            <!-- timeline item -->
            <div>
              <i class="fas fa-{{ $activity['icon'] ?? 'circle' }} bg-{{ $loop->index % 2 == 0 ? 'primary' : 'success' }}"></i>
              <div class="timeline-item">
                <h3 class="timeline-header">{{ $activity['title'] ?? 'Activity' }}</h3>
                <div class="timeline-body">
                  {{ $activity['description'] ?? 'No description' }}
                </div>
              </div>
            </div>
            @endforeach
          @else
            <div class="text-center text-muted">No recent activities</div>
          @endif
          <!-- END timeline item -->
          <div>
            <i class="far fa-clock bg-gray"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- System Performance -->
    <div class="card bg-gradient-success">
      <div class="card-header border-0">
        <h3 class="card-title">
          <i class="fas fa-tachometer-alt mr-1"></i>
          System Performance
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6 text-center">
            <div style="display:inline;width:60px;height:60px;">
              <input type="text" class="knob" data-readonly="true" value="{{ $analytics['equipment']['utilization'] ?? 75 }}" data-width="60" data-height="60" data-fgColor="#fff">
            </div>
            <div class="text-white">Equipment Usage</div>
          </div>
          <div class="col-6 text-center">
            <div style="display:inline;width:60px;height:60px;">
              <input type="text" class="knob" data-readonly="true" value="{{ $analytics['users']['growth'] ?? 12 }}" data-width="60" data-height="60" data-fgColor="#fff">
            </div>
            <div class="text-white">User Growth</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Quick Actions</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-block">
              <i class="fas fa-user-plus"></i> Add User
            </a>
          </div>
          <div class="col-6">
            <a href="{{ route('projects.create') }}" class="btn btn-success btn-block">
              <i class="fas fa-folder-plus"></i> New Project
            </a>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-6">
            <a href="{{ route('equipment.create') }}" class="btn btn-warning btn-block">
              <i class="fas fa-microscope"></i> Add Equipment
            </a>
          </div>
          <div class="col-6">
            <a href="{{ route('admin.reports') }}" class="btn btn-info btn-block">
              <i class="fas fa-chart-bar"></i> View Reports
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
<script>
$(function () {
  'use strict'

  // Activity Trends Chart
  var $activityChart = $('#activity-trends-chart')
  var activityChart = new Chart($activityChart, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Projects',
        backgroundColor: 'rgba(60,141,188,0.1)',
        borderColor: 'rgba(60,141,188,1)',
        pointRadius: 4,
        pointBackgroundColor: 'rgba(60,141,188,1)',
        data: [{{ implode(',', $analytics['charts']['projects_trend'] ?? [12, 15, 18, 22, 20, 25]) }}]
      }, {
        label: 'Publications',
        backgroundColor: 'rgba(210, 214, 222, 0.1)',
        borderColor: 'rgba(210, 214, 222, 1)',
        pointRadius: 4,
        pointBackgroundColor: 'rgba(210, 214, 222, 1)',
        data: [{{ implode(',', $analytics['charts']['publications_trend'] ?? [8, 12, 10, 15, 18, 20]) }}]
      }, {
        label: 'Users',
        backgroundColor: 'rgba(39, 174, 96, 0.1)',
        borderColor: 'rgba(39, 174, 96, 1)',
        pointRadius: 4,
        pointBackgroundColor: 'rgba(39, 174, 96, 1)',
        data: [{{ implode(',', $analytics['charts']['users_trend'] ?? [5, 8, 12, 16, 14, 18]) }}]
      }]
    },
    options: {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines: {
            display: false,
          }
        }],
        yAxes: [{
          gridLines: {
            display: true,
          }
        }]
      }
    }
  })

  // User Distribution Chart
  var $distributionChart = $('#user-distribution-chart')
  var distributionChart = new Chart($distributionChart, {
    type: 'doughnut',
    data: {
      labels: ['Researchers', 'Lab Managers', 'Visitors', 'Admins'],
      datasets: [{
        data: [{{ implode(',', $analytics['charts']['user_distribution'] ?? [45, 25, 20, 10]) }}],
        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
      }]
    },
    options: {
      legend: {
        display: true,
        position: 'bottom'
      },
      maintainAspectRatio: false,
    }
  })

  // Initialize Knob charts
  $('.knob').knob({
    readOnly: true
  })
})
</script>
@endpush