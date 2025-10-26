<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'LIMOSE Lab') | Scientific Research Laboratory</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css">

  <style>
    .brand-link {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .main-sidebar .nav-sidebar .nav-item .nav-link.active {
      background-color: rgba(255,255,255,.1);
      color: #c2c7d0;
    }

    .content-wrapper {
      background: #f4f6f9;
    }

    .card {
      box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
      border: none;
    }

    .info-box {
      box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
      border-radius: 0.25rem;
    }

    .small-box {
      border-radius: 0.25rem;
      box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    }

    .navbar-light .navbar-nav .nav-link {
      color: rgba(0,0,0,.5);
    }

    .main-sidebar {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .sidebar .nav-sidebar .nav-item .nav-link {
      color: rgba(255,255,255,.8);
    }

    .sidebar .nav-sidebar .nav-item .nav-link:hover {
      background-color: rgba(255,255,255,.1);
      color: #fff;
    }

    .navbar-white {
      background-color: #fff;
      box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
    }
  </style>

  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('new/assets/images/logos/logo.svg') }}" alt="LIMOSE Lab" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard.admin-lte') }}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('frontend.contact') }}" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="{{ asset('new/assets/images/profile/user-1.svg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>

      <!-- User Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <img src="{{ asset('new/assets/images/profile/user-1.svg') }}" alt="User Avatar" class="img-size-32 img-circle">
          <span class="d-none d-md-inline ml-1">{{ auth()->user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-header">
            <img src="{{ asset('new/assets/images/profile/user-1.svg') }}" alt="User Avatar" class="img-size-50 img-circle mr-2">
            <div class="d-inline-block">
              {{ auth()->user()->name }}<br>
              <small class="text-muted">{{ auth()->user()->role }}</small>
            </div>
          </div>
          <div class="dropdown-divider"></div>
          <a href="{{ route('dashboard.profile') }}" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
          </a>
          <a href="{{ route('dashboard.settings') }}" class="dropdown-item">
            <i class="fas fa-cog mr-2"></i> Settings
          </a>
          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
            @csrf
            <button type="submit" class="btn btn-link p-0 text-left w-100" style="text-decoration: none; color: inherit;">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
          </form>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.admin-lte') }}" class="brand-link">
      <img src="{{ asset('new/assets/images/logos/logo.svg') }}" alt="LIMOSE Lab" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">LIMOSE Lab</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- Dashboard -->
          <li class="nav-item">
            <a href="{{ route('dashboard.admin-lte') }}" class="nav-link {{ request()->routeIs('dashboard.admin-lte') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <!-- Analytics -->
          <li class="nav-item">
            <a href="{{ route('admin.analytics') }}" class="nav-link {{ request()->routeIs('admin.analytics*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>Analytics</p>
            </a>
          </li>

          <!-- Research Management -->
          <li class="nav-header">RESEARCH MANAGEMENT</li>

          <li class="nav-item">
            <a href="{{ route('researchers.index') }}" class="nav-link {{ request()->routeIs('researchers.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>Researchers</p>
            </a>
          </li>

          <li class="nav-item {{ request()->routeIs('projects.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-folder"></i>
              <p>
                Projects
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Projects</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('projects.create') }}" class="nav-link {{ request()->routeIs('projects.create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Project</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('publications.index') }}" class="nav-link {{ request()->routeIs('publications.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Publications</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('collaborations.index') }}" class="nav-link {{ request()->routeIs('collaborations.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-handshake"></i>
              <p>Collaborations</p>
            </a>
          </li>

          <!-- Lab Management -->
          <li class="nav-header">LAB MANAGEMENT</li>

          <li class="nav-item {{ request()->routeIs('equipment.*') || request()->routeIs('admin.equipment.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('equipment.*') || request()->routeIs('admin.equipment.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-microscope"></i>
              <p>
                Equipment
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('equipment.index') }}" class="nav-link {{ request()->routeIs('equipment.index') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Equipment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('equipment.create') }}" class="nav-link {{ request()->routeIs('equipment.create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Equipment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.equipment.reservations') }}" class="nav-link {{ request()->routeIs('admin.equipment.reservations') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reservations</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar"></i>
              <p>Events & Seminars</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('funding.index') }}" class="nav-link {{ request()->routeIs('funding.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>Funding</p>
            </a>
          </li>

          <!-- Administration -->
          <li class="nav-header">ADMINISTRATION</li>

          <li class="nav-item {{ request()->routeIs('admin.users*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.users.create') }}" class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-cog"></i>
              <p>System Settings</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>Reports</p>
            </a>
          </li>

        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @yield('breadcrumb')
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
  </div>

  <!-- Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ route('home') }}">LIMOSE Lab</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<!-- Sparkline -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
<!-- JQVMap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jquery.vmap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

<script>
$(function () {
  // Initialize tooltips
  $('[data-toggle="tooltip"]').tooltip();

  // Initialize popovers
  $('[data-toggle="popover"]').popover();

  // Auto-hide alerts after 5 seconds
  setTimeout(function() {
    $('.alert').fadeOut('slow');
  }, 5000);
});
</script>

@stack('scripts')
</body>
</html>