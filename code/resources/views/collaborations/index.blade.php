@extends('layouts.adminlte')

@section('title', 'Collaborations')
@section('page-title', 'International Collaborations')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item active">Collaborations</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('International Collaborations') }}</h2>
            <p class="text-muted mb-0">{{ __('Manage partnerships with international research institutions') }}</p>
        </div>
        @can('create', App\Models\Collaboration::class)
        <a href="{{ route('collaborations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>{{ __('New Collaboration') }}
        </a>
        @endcan
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['total_collaborations'] ?? 0 }}</div>
                    <div class="small">{{ __('Total Collaborations') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['active_collaborations'] ?? 0 }}</div>
                    <div class="small">{{ __('Active') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['unique_countries'] ?? 0 }}</div>
                    <div class="small">{{ __('Countries') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['joint_projects'] ?? 0 }}</div>
                    <div class="small">{{ __('Joint Projects') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('collaborations.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="{{ __('Search collaborations...') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('collaborations.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">{{ __('Collaboration Type') }}</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="research_partnership" {{ request('type') == 'research_partnership' ? 'selected' : '' }}>{{ __('Research Partnership') }}</option>
                        <option value="student_exchange" {{ request('type') == 'student_exchange' ? 'selected' : '' }}>{{ __('Student Exchange') }}</option>
                        <option value="joint_program" {{ request('type') == 'joint_program' ? 'selected' : '' }}>{{ __('Joint Program') }}</option>
                        <option value="equipment_sharing" {{ request('type') == 'equipment_sharing' ? 'selected' : '' }}>{{ __('Equipment Sharing') }}</option>
                        <option value="knowledge_exchange" {{ request('type') == 'knowledge_exchange' ? 'selected' : '' }}>{{ __('Knowledge Exchange') }}</option>
                        <option value="funding_partnership" {{ request('type') == 'funding_partnership' ? 'selected' : '' }}>{{ __('Funding Partnership') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>{{ __('Suspended') }}</option>
                        <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>{{ __('Terminated') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="country" class="form-label">{{ __('Country') }}</label>
                    <input type="text" class="form-control" id="country" name="country"
                           value="{{ request('country') }}" placeholder="{{ __('Filter by country...') }}">
                </div>
            </form>
        </div>
    </div>

    <!-- Results Info -->
    @if(isset($collaborations) && $collaborations->total() > 0)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted">
                {{ __('Showing :from to :to of :total collaborations', [
                    'from' => $collaborations->firstItem(),
                    'to' => $collaborations->lastItem(),
                    'total' => $collaborations->total()
                ]) }}
            </div>
            <div class="d-flex align-items-center">
                <label class="form-label mb-0 me-2">{{ __('Per page:') }}</label>
                <form method="GET" action="{{ route('collaborations.index') }}" class="d-inline">
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

    <!-- Collaborations Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Partner Institution') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Contact Person') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Duration') }}</th>
                            <th>{{ __('Projects') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($collaborations ?? [] as $collaboration)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div class="rounded d-flex align-items-center justify-content-center bg-primary text-white" style="width: 40px; height: 40px;">
                                                <i class="fas fa-university"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $collaboration->partner_institution }}</div>
                                            @if($collaboration->country)
                                                <small class="text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $collaboration->country }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $typeColors = [
                                            'research_partnership' => 'primary',
                                            'student_exchange' => 'success',
                                            'joint_program' => 'info',
                                            'equipment_sharing' => 'warning',
                                            'knowledge_exchange' => 'secondary',
                                            'funding_partnership' => 'danger'
                                        ];
                                        $typeLabels = [
                                            'research_partnership' => __('Research Partnership'),
                                            'student_exchange' => __('Student Exchange'),
                                            'joint_program' => __('Joint Program'),
                                            'equipment_sharing' => __('Equipment Sharing'),
                                            'knowledge_exchange' => __('Knowledge Exchange'),
                                            'funding_partnership' => __('Funding Partnership')
                                        ];
                                        $typeColor = $typeColors[$collaboration->type] ?? 'secondary';
                                        $typeLabel = $typeLabels[$collaboration->type] ?? $collaboration->type;
                                    @endphp
                                    <span class="badge bg-{{ $typeColor }}">{{ $typeLabel }}</span>
                                </td>
                                <td>
                                    @if($collaboration->contact_person)
                                        <div>
                                            <div class="fw-medium">{{ $collaboration->contact_person }}</div>
                                            @if($collaboration->contact_email)
                                                <small class="text-muted">{{ $collaboration->contact_email }}</small>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'active' => 'success',
                                            'pending' => 'warning',
                                            'completed' => 'primary',
                                            'suspended' => 'secondary',
                                            'terminated' => 'danger'
                                        ];
                                        $statusIcons = [
                                            'active' => 'fas fa-check-circle',
                                            'pending' => 'fas fa-clock',
                                            'completed' => 'fas fa-flag-checkered',
                                            'suspended' => 'fas fa-pause-circle',
                                            'terminated' => 'fas fa-times-circle'
                                        ];
                                        $statusLabels = [
                                            'active' => __('Active'),
                                            'pending' => __('Pending'),
                                            'completed' => __('Completed'),
                                            'suspended' => __('Suspended'),
                                            'terminated' => __('Terminated')
                                        ];
                                        $statusColor = $statusColors[$collaboration->status] ?? 'secondary';
                                        $statusIcon = $statusIcons[$collaboration->status] ?? 'fas fa-question-circle';
                                        $statusLabel = $statusLabels[$collaboration->status] ?? $collaboration->status;
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">
                                        <i class="{{ $statusIcon }} me-1"></i>{{ $statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        @if($collaboration->start_date)
                                            <div class="fw-medium">{{ $collaboration->start_date->format('M d, Y') }}</div>
                                            @if($collaboration->end_date)
                                                <small class="text-muted">{{ __('to') }} {{ $collaboration->end_date->format('M d, Y') }}</small>
                                            @else
                                                <small class="text-info">{{ __('Ongoing') }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">{{ __('Not set') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="fw-medium">{{ $collaboration->projects_count ?? 0 }}</div>
                                    <small class="text-muted">{{ __('projects') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('collaborations.show', $collaboration) }}" class="btn btn-sm btn-outline-primary" title="{{ __('View') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('update', App\Models\Collaboration::class)
                                            <a href="{{ route('collaborations.edit', $collaboration) }}" class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @if($collaboration->contact_email)
                                            <a href="mailto:{{ $collaboration->contact_email }}" class="btn btn-sm btn-outline-info" title="{{ __('Send Email') }}">
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-handshake fa-2x mb-2 d-block"></i>
                                    @if(request()->hasAny(['search', 'type', 'status', 'country']))
                                        {{ __('No collaborations found matching your search criteria') }}
                                    @else
                                        {{ __('No collaborations have been added yet') }}
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
    @if(isset($collaborations) && $collaborations->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $collaborations->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection