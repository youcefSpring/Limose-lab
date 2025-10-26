@extends('layouts.adminlte')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Home</a></li>
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $dashboardData['overview']['total_users'] ?? 0 }}</h3>
        <p>Total Users</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-stalker"></i>
      </div>
      <a href="{{ route('admin.users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $dashboardData['overview']['total_researchers'] ?? 0 }}</h3>
        <p>Researchers</p>
      </div>
      <div class="icon">
        <i class="ion ion-university"></i>
      </div>
      <a href="{{ route('researchers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $dashboardData['overview']['active_projects'] ?? 0 }}</h3>
        <p>Active Projects</p>
      </div>
      <div class="icon">
        <i class="ion ion-folder"></i>
      </div>
      <a href="{{ route('projects.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{ $dashboardData['overview']['total_equipment'] ?? 0 }}</h3>
        <p>Lab Equipment</p>
      </div>
      <div class="icon">
        <i class="fas fa-microscope"></i>
      </div>
      <a href="{{ route('equipment.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->

<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <section class="col-lg-7 connectedSortable">
    <!-- Research Overview Chart -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-chart-pie mr-1"></i>
          Research Overview
        </h3>
        <div class="card-tools">
          <ul class="nav nav-pills ml-auto">
            <li class="nav-item">
              <a class="nav-link active" href="#research-chart" data-toggle="tab">Area</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
            </li>
          </ul>
        </div>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content p-0">
          <!-- Morris chart - Sales -->
          <div class="chart tab-pane active" id="research-chart" style="position: relative; height: 300px;">
            <canvas id="research-overview-chart" height="300" style="height: 300px;"></canvas>
          </div>
          <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
            <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
          </div>
        </div>
      </div><!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- Recent Projects -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Recent Projects</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <ul class="products-list product-list-in-card pl-2 pr-2">
          @if(isset($dashboardData['recent_activity']['recent_projects']) && count($dashboardData['recent_activity']['recent_projects']) > 0)
            @foreach($dashboardData['recent_activity']['recent_projects'] as $project)
            <li class="item">
              <div class="product-img">
                <img src="{{ asset('new/assets/images/profile/user-' . (($loop->index % 8) + 1) . '.jpg') }}" alt="Project Leader" class="img-size-50">
              </div>
              <div class="product-info">
                <a href="#" class="product-title">{{ Str::limit($project->title, 40) }}
                  @if($project->status === 'active')
                    <span class="badge badge-success float-right">Active</span>
                  @elseif($project->status === 'planning')
                    <span class="badge badge-info float-right">Planning</span>
                  @else
                    <span class="badge badge-warning float-right">{{ ucfirst($project->status) }}</span>
                  @endif
                </a>
                <span class="product-description">
                  Led by {{ $project->leader->full_name ?? 'N/A' }} • Budget: ${{ number_format($project->budget ?? 0, 0) }}
                </span>
              </div>
            </li>
            @endforeach
          @else
            <li class="item">
              <div class="product-info text-center w-100">
                <span class="product-description text-muted">No recent projects found</span>
              </div>
            </li>
          @endif
        </ul>
      </div>
      <!-- /.card-body -->
      <div class="card-footer text-center">
        <a href="{{ route('projects.index') }}" class="uppercase">View All Projects</a>
      </div>
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->
  </section>
  <!-- /.Left col -->

  <!-- right col (We are only adding the ID to make the widgets sortable)-->
  <section class="col-lg-5 connectedSortable">

    <!-- Map card -->
    <div class="card bg-gradient-primary">
      <div class="card-header border-0">
        <h3 class="card-title">
          <i class="fas fa-map-marker-alt mr-1"></i>
          Research Distribution
        </h3>
        <!-- card tools -->
        <div class="card-tools">
          <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
            <i class="far fa-calendar-alt"></i>
          </button>
          <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
        <!-- /.card-tools -->
      </div>
      <div class="card-body">
        <div id="world-map" style="height: 250px; width: 100%;"></div>
      </div>
      <!-- /.card-body-->
      <div class="card-footer bg-transparent">
        <div class="row">
          <div class="col-4 text-center">
            <div style="display:inline;width:60px;height:60px;"><canvas width="60" height="60"></canvas><input type="text" class="knob" data-readonly="true" value="{{ $dashboardData['overview']['total_projects'] ?? 0 }}" data-width="60" data-height="60" data-fgColor="#39CCCC" readonly="readonly" style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; appearance: none;"></div>
            <div class="text-white">Projects</div>
          </div>
          <!-- ./col -->
          <div class="col-4 text-center">
            <div style="display:inline;width:60px;height:60px;"><canvas width="60" height="60"></canvas><input type="text" class="knob" data-readonly="true" value="{{ $dashboardData['overview']['total_publications'] ?? 0 }}" data-width="60" data-height="60" data-fgColor="#39CCCC" readonly="readonly" style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; appearance: none;"></div>
            <div class="text-white">Publications</div>
          </div>
          <!-- ./col -->
          <div class="col-4 text-center">
            <div style="display:inline;width:60px;height:60px;"><canvas width="60" height="60"></canvas><input type="text" class="knob" data-readonly="true" value="{{ $dashboardData['overview']['total_researchers'] ?? 0 }}" data-width="60" data-height="60" data-fgColor="#39CCCC" readonly="readonly" style="width: 34px; height: 20px; position: absolute; vertical-align: middle; margin-top: 20px; margin-left: -47px; border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(57, 204, 204); padding: 0px; appearance: none;"></div>
            <div class="text-white">Researchers</div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div>
    </div>
    <!-- /.card -->

    <!-- solid sales graph -->
    <div class="card bg-gradient-info">
      <div class="card-header border-0">
        <h3 class="card-title">
          <i class="fas fa-th mr-1"></i>
          Equipment Status
        </h3>
        <div class="card-tools">
          <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
      <!-- /.card-body -->
      <div class="card-footer bg-transparent">
        <div class="row">
          @if(isset($dashboardData['equipment_status']))
            @foreach($dashboardData['equipment_status'] as $status => $count)
            <div class="col text-center">
              <div style="display:inline;width:40px;height:40px;">
                <canvas width="40" height="40"></canvas>
                <input type="text" class="knob" data-readonly="true" value="{{ $count }}" data-width="40" data-height="40" data-fgColor="#fff" readonly="readonly">
              </div>
              <div class="text-white text-capitalize">{{ str_replace('_', ' ', $status) }}</div>
            </div>
            @endforeach
          @endif
        </div>
        <!-- /.row -->
      </div>
    </div>
    <!-- /.card -->

    <!-- Calendar -->
    <div class="card bg-gradient-success">
      <div class="card-header border-0">
        <h3 class="card-title">
          <i class="far fa-calendar-alt"></i>
          Calendar
        </h3>
        <!-- tools card -->
        <div class="card-tools">
          <!-- button with a dropdown -->
          <div class="btn-group">
            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
              <i class="fas fa-bars"></i>
            </button>
            <div class="dropdown-menu" role="menu">
              <a href="#" class="dropdown-item">Add new event</a>
              <a href="#" class="dropdown-item">Clear events</a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">View calendar</a>
            </div>
          </div>
          <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <!-- /. tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body pt-0">
        <!--The calendar -->
        <div id="calendar" style="width: 100%"></div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
  <!-- right col -->
</div>
<!-- /.row (main row) -->

<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Equipment in Use</span>
        <span class="info-box-number">
          {{ $dashboardData['overview']['equipment_in_use'] ?? 0 }}
          <small>%</small>
        </span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Upcoming Events</span>
        <span class="info-box-number">{{ $dashboardData['overview']['upcoming_events'] ?? 0 }}</span>
      </div>
    </div>
  </div>

  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Pending Requests</span>
        <span class="info-box-number">{{ $dashboardData['overview']['pending_requests'] ?? 0 }}</span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Active Users</span>
        <span class="info-box-number">{{ $dashboardData['overview']['active_users'] ?? 0 }}</span>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
  'use strict'

  // Research Overview Chart
  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  var $researchChart = $('#research-overview-chart')
  var researchChart = new Chart($researchChart, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Projects',
        backgroundColor: 'rgba(60,141,188,0.1)',
        borderColor: 'rgba(60,141,188,1)',
        pointRadius: false,
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data: [{{ implode(',', $dashboardData['charts']['projects_trend'] ?? [12, 15, 18, 22, 20, 25]) }}]
      }, {
        label: 'Publications',
        backgroundColor: 'rgba(210, 214, 222, 0.1)',
        borderColor: 'rgba(210, 214, 222, 1)',
        pointRadius: false,
        pointColor: 'rgba(210, 214, 222, 1)',
        pointStrokeColor: '#c1c7d1',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data: [{{ implode(',', $dashboardData['charts']['publications_trend'] ?? [8, 12, 10, 15, 18, 20]) }}]
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 30
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

  // Sales chart
  var $salesChart = $('#sales-chart-canvas')
  var salesChart = new Chart($salesChart, {
    type: 'doughnut',
    data: {
      labels: ['Projects', 'Publications', 'Equipment', 'Events'],
      datasets: [{
        data: [{{ $dashboardData['overview']['total_projects'] ?? 0 }}, {{ $dashboardData['overview']['total_publications'] ?? 0 }}, {{ $dashboardData['overview']['total_equipment'] ?? 0 }}, {{ $dashboardData['overview']['upcoming_events'] ?? 0 }}],
        backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
      }]
    },
    options: {
      legend: {
        display: false
      },
      maintainAspectRatio: false,
    }
  })

  // The Calender
  $('#calendar').datetimepicker({
    format: 'L',
    inline: true
  })

  // Initialize Knob charts
  $('.knob').knob({
    draw: function () {
      // "tron" case
      if (this.$.data('skin') == 'tron') {
        var a = this.angle(this.cv)  // Angle
        var sa = this.startAngle          // Previous start angle
        var sat = this.startAngle         // Start angle
        var ea                            // Previous end angle
        var eat = sat + a                 // End angle

        var r = true

        this.g.lineWidth = this.lineWidth

        this.o.cursor
        && (sat = eat - 0.3)
        && (eat = eat + 0.3)

        if (this.o.displayPrevious) {
          ea = this.startAngle + this.angle(this.value)
          this.o.cursor
          && (sa = ea - 0.3)
          && (ea = ea + 0.3)
          this.g.beginPath()
          this.g.strokeStyle = this.previousColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
          this.g.stroke()
        }

        this.g.beginPath()
        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
        this.g.stroke()

        this.g.lineWidth = 2
        this.g.beginPath()
        this.g.strokeStyle = this.o.fgColor
        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
        this.g.stroke()

        return false
      }
    }
  })
})
</script>
@endpush