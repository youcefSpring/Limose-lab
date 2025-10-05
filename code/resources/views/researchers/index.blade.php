@extends('layouts.app', ['title' => __('Researchers Management')])

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Researchers') }}</h2>
            <p class="text-muted mb-0">{{ __('Manage and browse research team members') }}</p>
        </div>
        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                <a href="{{ route('researchers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('Add Researcher') }}
                </a>
            @endif
        @endauth
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('researchers.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="{{ __('Search researchers...') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('researchers.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="domain" class="form-label">{{ __('Research Domain') }}</label>
                    <select class="form-select" id="domain" name="domain">
                        <option value="">{{ __('All Domains') }}</option>
                        @foreach($domains ?? [] as $domain)
                            <option value="{{ $domain }}" {{ request('domain') == $domain ? 'selected' : '' }}>
                                {{ $domain }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>{{ __('Filter') }}
                        </button>
                        <a href="{{ route('researchers.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>{{ __('Clear') }}
                        </a>
                        <a href="{{ route('researchers.index', array_merge(request()->all(), ['export' => 'excel'])) }}"
                           class="btn btn-outline-success" title="{{ __('Export') }}">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Info -->
    @if(isset($researchers) && $researchers->total() > 0)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted">
                {{ __('Showing :from to :to of :total researchers', [
                    'from' => $researchers->firstItem(),
                    'to' => $researchers->lastItem(),
                    'total' => $researchers->total()
                ]) }}
            </div>
            <div class="d-flex align-items-center">
                <label class="form-label mb-0 me-2">{{ __('Per page:') }}</label>
                <form method="GET" action="{{ route('researchers.index') }}" class="d-inline">
                    @foreach(request()->except('per_page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12</option>
                        <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                        <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                    </select>
                </form>
            </div>
        </div>
    @endif

    <!-- Researchers Grid -->
    <div class="row g-4">
        @forelse($researchers ?? [] as $researcher)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 researcher-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $researcher->photo_url ?? '/images/default-avatar.png' }}"
                                 alt="{{ $researcher->first_name }} {{ $researcher->last_name }}"
                                 class="rounded-circle me-3"
                                 style="width: 60px; height: 60px; object-fit: cover;">
                            <div>
                                <h5 class="card-title mb-1">
                                    {{ $researcher->first_name }} {{ $researcher->last_name }}
                                </h5>
                                <p class="text-muted small mb-0">{{ $researcher->position ?? __('Researcher') }}</p>
                            </div>
                        </div>

                        @if($researcher->research_interests)
                            <div class="mb-3">
                                <h6 class="small fw-bold text-muted mb-2">{{ __('Research Interests') }}</h6>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach(explode(',', $researcher->research_interests) as $interest)
                                        <span class="badge bg-light text-dark">{{ trim($interest) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($researcher->email || $researcher->phone)
                            <div class="mb-3">
                                @if($researcher->email)
                                    <div class="small text-muted">
                                        <i class="fas fa-envelope me-1"></i>{{ $researcher->email }}
                                    </div>
                                @endif
                                @if($researcher->phone)
                                    <div class="small text-muted">
                                        <i class="fas fa-phone me-1"></i>{{ $researcher->phone }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-{{ $researcher->status == 'active' ? 'success' : ($researcher->status == 'inactive' ? 'secondary' : 'warning') }}">
                                {{ ucfirst($researcher->status ?? 'active') }}
                            </span>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('researchers.show', $researcher) }}" class="btn btn-outline-primary" title="{{ __('View') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @auth
                                    @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                                        <a href="{{ route('researchers.edit', $researcher) }}" class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-user-friends text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">{{ __('No researchers found') }}</h4>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'domain', 'status']))
                            {{ __('Try adjusting your search criteria or clear filters') }}
                        @else
                            {{ __('No researchers have been added yet') }}
                        @endif
                    </p>
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                            <a href="{{ route('researchers.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i>{{ __('Add First Researcher') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($researchers) && $researchers->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $researchers->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection


@push('styles')
<style>
.researcher-card {
    transition: transform 0.2s ease-in-out;
}

.researcher-card:hover {
    transform: translateY(-4px);
}

.researcher-card .card-title {
    word-break: break-word;
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .researcher-card {
        margin-bottom: 16px;
    }
}
</style>
@endpush