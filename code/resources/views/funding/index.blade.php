@extends('layouts.app', ['title' => __('Funding Management')])

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Funding Management') }}</h2>
            <p class="text-muted mb-0">{{ __('Track grants, funding opportunities, and budget allocation') }}</p>
        </div>
        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                <a href="{{ route('funding.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('Add Funding') }}
                </a>
            @endif
        @endauth
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">${{ number_format($statistics['total_funding'] ?? 0) }}</div>
                    <div class="small">{{ __('Total Funding') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['active_funding'] ?? 0 }}</div>
                    <div class="small">{{ __('Active Grants') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">${{ number_format($statistics['budget_used'] ?? 0) }}</div>
                    <div class="small">{{ __('Budget Used') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">${{ number_format($statistics['available_budget'] ?? 0) }}</div>
                    <div class="small">{{ __('Available Budget') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('funding.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="{{ __('Search funding...') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('funding.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">{{ __('Funding Type') }}</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="government_grant" {{ request('type') == 'government_grant' ? 'selected' : '' }}>{{ __('Government Grant') }}</option>
                        <option value="private_foundation" {{ request('type') == 'private_foundation' ? 'selected' : '' }}>{{ __('Private Foundation') }}</option>
                        <option value="industry_partnership" {{ request('type') == 'industry_partnership' ? 'selected' : '' }}>{{ __('Industry Partnership') }}</option>
                        <option value="internal_funding" {{ request('type') == 'internal_funding' ? 'selected' : '' }}>{{ __('Internal Funding') }}</option>
                        <option value="international_grant" {{ request('type') == 'international_grant' ? 'selected' : '' }}>{{ __('International Grant') }}</option>
                        <option value="crowdfunding" {{ request('type') == 'crowdfunding' ? 'selected' : '' }}>{{ __('Crowdfunding') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>{{ __('Applied') }}</option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>{{ __('Under Review') }}</option>
                        <option value="awarded" {{ request('status') == 'awarded' ? 'selected' : '' }}>{{ __('Awarded') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="year" class="form-label">{{ __('Year') }}</label>
                    <input type="number" class="form-control" id="year" name="year"
                           value="{{ request('year') }}" placeholder="{{ __('Year') }}" min="2000" max="{{ date('Y') + 5 }}">
                </div>
            </form>
        </div>
    </div>

    <!-- Results Info -->
    @if(isset($funding) && $funding->total() > 0)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted">
                {{ __('Showing :from to :to of :total funding records', [
                    'from' => $funding->firstItem(),
                    'to' => $funding->lastItem(),
                    'total' => $funding->total()
                ]) }}
            </div>
            <div class="d-flex align-items-center">
                <label class="form-label mb-0 me-2">{{ __('Per page:') }}</label>
                <form method="GET" action="{{ route('funding.index') }}" class="d-inline">
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

    <!-- Funding Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Duration') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('PI') }}</th>
                            <th>{{ __('Budget Used') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($funding ?? [] as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @php
                                                $typeIcons = [
                                                    'government_grant' => 'fas fa-university',
                                                    'private_foundation' => 'fas fa-building',
                                                    'industry_partnership' => 'fas fa-industry',
                                                    'internal_funding' => 'fas fa-home',
                                                    'international_grant' => 'fas fa-globe',
                                                    'crowdfunding' => 'fas fa-users'
                                                ];
                                                $typeColors = [
                                                    'government_grant' => 'primary',
                                                    'private_foundation' => 'success',
                                                    'industry_partnership' => 'warning',
                                                    'internal_funding' => 'info',
                                                    'international_grant' => 'secondary',
                                                    'crowdfunding' => 'danger'
                                                ];
                                                $icon = $typeIcons[$item->type] ?? 'fas fa-dollar-sign';
                                                $color = $typeColors[$item->type] ?? 'secondary';
                                            @endphp
                                            <div class="rounded d-flex align-items-center justify-content-center bg-{{ $color }} text-white" style="width: 40px; height: 40px;">
                                                <i class="{{ $icon }}"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $item->title }}</div>
                                            @if($item->funding_agency)
                                                <small class="text-muted">{{ $item->funding_agency }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $typeLabels = [
                                            'government_grant' => __('Government Grant'),
                                            'private_foundation' => __('Private Foundation'),
                                            'industry_partnership' => __('Industry Partnership'),
                                            'internal_funding' => __('Internal Funding'),
                                            'international_grant' => __('International Grant'),
                                            'crowdfunding' => __('Crowdfunding')
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $typeLabels[$item->type] ?? $item->type }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="fw-medium">${{ number_format($item->amount ?? 0) }}</div>
                                    @if($item->currency && $item->currency !== 'USD')
                                        <small class="text-muted">{{ $item->currency }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $item->start_date ? $item->start_date->format('M d, Y') : __('Not set') }}</div>
                                    @if($item->end_date)
                                        <small class="text-muted">{{ __('to') }} {{ $item->end_date->format('M d, Y') }}</small><br>
                                        @php
                                            $now = now();
                                            $diffDays = $item->end_date->diffInDays($now, false);
                                            if ($diffDays < 0) {
                                                $status = __('Expired');
                                                $statusClass = 'text-danger';
                                            } elseif ($diffDays <= 30) {
                                                $status = __('Expires in :days days', ['days' => abs($diffDays)]);
                                                $statusClass = 'text-warning';
                                            } else {
                                                $status = __('Active');
                                                $statusClass = 'text-success';
                                            }
                                        @endphp
                                        <small class="{{ $statusClass }}">{{ $status }}</small>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'applied' => 'info',
                                            'under_review' => 'warning',
                                            'awarded' => 'success',
                                            'active' => 'primary',
                                            'completed' => 'secondary',
                                            'rejected' => 'danger'
                                        ];
                                        $statusIcons = [
                                            'applied' => 'fas fa-paper-plane',
                                            'under_review' => 'fas fa-clock',
                                            'awarded' => 'fas fa-trophy',
                                            'active' => 'fas fa-check-circle',
                                            'completed' => 'fas fa-flag-checkered',
                                            'rejected' => 'fas fa-times'
                                        ];
                                        $statusLabels = [
                                            'applied' => __('Applied'),
                                            'under_review' => __('Under Review'),
                                            'awarded' => __('Awarded'),
                                            'active' => __('Active'),
                                            'completed' => __('Completed'),
                                            'rejected' => __('Rejected')
                                        ];
                                        $statusColor = $statusColors[$item->status] ?? 'secondary';
                                        $statusIcon = $statusIcons[$item->status] ?? 'fas fa-question-circle';
                                        $statusLabel = $statusLabels[$item->status] ?? $item->status;
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">
                                        <i class="{{ $statusIcon }} me-1"></i>{{ $statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->principal_investigator)
                                        <div>{{ $item->principal_investigator }}</div>
                                        @if($item->department)
                                            <small class="text-muted">{{ $item->department }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                        $budgetUsed = $item->budget_used ?? 0;
                                        $totalBudget = $item->amount ?? 0;
                                        $percentage = $totalBudget > 0 ? round(($budgetUsed / $totalBudget) * 100) : 0;
                                        if ($percentage >= 90) $progressColor = 'danger';
                                        elseif ($percentage >= 75) $progressColor = 'warning';
                                        else $progressColor = 'success';
                                    @endphp
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <div class="progress me-2" style="width: 50px; height: 6px;">
                                            <div class="progress-bar bg-{{ $progressColor }}" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <small>{{ $percentage }}%</small>
                                    </div>
                                    <small class="text-muted">${{ number_format($budgetUsed) }} / ${{ number_format($totalBudget) }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('funding.show', $item) }}" class="btn btn-sm btn-outline-primary" title="{{ __('View') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @auth
                                            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                                                <a href="{{ route('funding.edit', $item) }}" class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($item->status === 'active')
                                                    <a href="{{ route('funding.expenses.create', $item) }}" class="btn btn-sm btn-outline-success" title="{{ __('Add Expense') }}">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                    @if(request()->hasAny(['search', 'type', 'status', 'year']))
                                        {{ __('No funding records found matching your search criteria') }}
                                    @else
                                        {{ __('No funding records have been added yet') }}
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
    @if(isset($funding) && $funding->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $funding->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection