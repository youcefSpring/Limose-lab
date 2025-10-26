@extends('layouts.adminlte')

@section('title', 'Projects')
@section('page-title', 'Project Management')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item active">Projects</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Research Projects') }}</h2>
            <p class="text-muted mb-0">{{ __('Explore ongoing and completed research initiatives') }}</p>
        </div>
        @auth
            @if(auth()->user()->isResearcher() || auth()->user()->isAdmin() || auth()->user()->isLabManager())
                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('New Project') }}
                </a>
            @endif
        @endauth
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['total_projects'] ?? 0 }}</div>
                    <div class="small">{{ __('Total Projects') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['active_projects'] ?? 0 }}</div>
                    <div class="small">{{ __('Active Projects') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['pending_projects'] ?? 0 }}</div>
                    <div class="small">{{ __('Pending Projects') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['completed_projects'] ?? 0 }}</div>
                    <div class="small">{{ __('Completed Projects') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('projects.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="{{ __('Search projects...') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>{{ __('Suspended') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="leader_id" class="form-label">{{ __('Project Leader') }}</label>
                    <select class="form-select" id="leader_id" name="leader_id">
                        <option value="">{{ __('All Leaders') }}</option>
                        @foreach($leaders ?? [] as $leader)
                            <option value="{{ $leader->id }}" {{ request('leader_id') == $leader->id ? 'selected' : '' }}>
                                {{ $leader->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="budget_range" class="form-label">{{ __('Budget Range') }}</label>
                    <select class="form-select" id="budget_range" name="budget_range">
                        <option value="">{{ __('All Ranges') }}</option>
                        <option value="0-10000" {{ request('budget_range') == '0-10000' ? 'selected' : '' }}>{{ __('Under $10K') }}</option>
                        <option value="10000-50000" {{ request('budget_range') == '10000-50000' ? 'selected' : '' }}>{{ __('$10K - $50K') }}</option>
                        <option value="50000-100000" {{ request('budget_range') == '50000-100000' ? 'selected' : '' }}>{{ __('$50K - $100K') }}</option>
                        <option value="100000-999999999" {{ request('budget_range') == '100000-999999999' ? 'selected' : '' }}>{{ __('Over $100K') }}</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Info -->
    @if(isset($projects) && $projects->total() > 0)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted">
                {{ __('Showing :from to :to of :total projects', [
                    'from' => $projects->firstItem(),
                    'to' => $projects->lastItem(),
                    'total' => $projects->total()
                ]) }}
            </div>
            <div class="d-flex align-items-center">
                <label class="form-label mb-0 me-2">{{ __('Per page:') }}</label>
                <form method="GET" action="{{ route('projects.index') }}" class="d-inline">
                    @foreach(request()->except('per_page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
            </div>
        </div>
    @endif

    <!-- Projects Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Project') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Leader') }}</th>
                            <th>{{ __('Progress') }}</th>
                            <th>{{ __('Budget') }}</th>
                            <th>{{ __('Timeline') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects ?? [] as $project)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="rounded d-flex align-items-center justify-content-center bg-primary text-white" style="width: 40px; height: 40px;">
                                                <i class="fas fa-folder"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $project->title }}</div>
                                            @if($project->description)
                                                <small class="text-muted">{{ Str::limit($project->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'active' => 'success',
                                            'completed' => 'primary',
                                            'suspended' => 'danger'
                                        ];
                                        $statusIcons = [
                                            'pending' => 'fas fa-clock',
                                            'active' => 'fas fa-play-circle',
                                            'completed' => 'fas fa-check-circle',
                                            'suspended' => 'fas fa-pause-circle'
                                        ];
                                        $statusLabels = [
                                            'pending' => __('Pending'),
                                            'active' => __('Active'),
                                            'completed' => __('Completed'),
                                            'suspended' => __('Suspended')
                                        ];
                                        $statusColor = $statusColors[$project->status] ?? 'secondary';
                                        $statusIcon = $statusIcons[$project->status] ?? 'fas fa-question-circle';
                                        $statusLabel = $statusLabels[$project->status] ?? $project->status;
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">
                                        <i class="{{ $statusIcon }} me-1"></i>{{ $statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    @if($project->principal_investigator)
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $project->principal_investigator->name ?? $project->principal_investigator }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $progress = $project->progress_percentage ?? 0;
                                        $progressColor = $progress < 30 ? 'danger' : ($progress < 70 ? 'warning' : 'success');
                                    @endphp
                                    <div style="min-width: 100px;">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>{{ $progress }}%</small>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-{{ $progressColor }}" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($project->budget)
                                        <div class="fw-medium">${{ number_format($project->budget) }}</div>
                                    @else
                                        <span class="text-muted">{{ __('Not specified') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        @if($project->start_date && $project->end_date)
                                            <div class="small">{{ $project->start_date->format('M d, Y') }} - {{ $project->end_date->format('M d, Y') }}</div>
                                            @php
                                                $now = now();
                                                $diffDays = $project->end_date->diffInDays($now, false);
                                                if ($diffDays < 0) {
                                                    $status = __('Overdue');
                                                    $statusClass = 'text-danger';
                                                } elseif ($diffDays <= 30) {
                                                    $status = __(':days days remaining', ['days' => abs($diffDays)]);
                                                    $statusClass = 'text-warning';
                                                } else {
                                                    $status = __('On track');
                                                    $statusClass = 'text-success';
                                                }
                                            @endphp
                                            <div class="small {{ $statusClass }}">{{ $status }}</div>
                                        @else
                                            <span class="text-muted">{{ __('Not set') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary" title="{{ __('View') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @auth
                                            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                                                <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                    @if(request()->hasAny(['search', 'status', 'leader_id', 'budget_range']))
                                        {{ __('No projects found matching your search criteria') }}
                                    @else
                                        {{ __('No projects have been added yet') }}
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if(isset($projects) && $projects->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $projects->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection