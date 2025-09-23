@extends('layouts.app', ['title' => __('Publications Management')])

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Publications Management') }}</h2>
            <p class="text-muted mb-0">{{ __('Manage research publications and papers') }}</p>
        </div>
        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager() || auth()->user()->isResearcher())
                <a href="{{ route('publications.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('Add Publication') }}
                </a>
            @endif
        @endauth
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['total_publications'] ?? 0 }}</div>
                    <div class="small">{{ __('Total Publications') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['this_year_publications'] ?? 0 }}</div>
                    <div class="small">{{ __('This Year') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ $statistics['total_citations'] ?? 0 }}</div>
                    <div class="small">{{ __('Total Citations') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1">{{ number_format($statistics['average_impact_factor'] ?? 0, 2) }}</div>
                    <div class="small">{{ __('Avg Impact Factor') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('publications.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="{{ __('Search publications...') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('publications.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">{{ __('Type') }}</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="article" {{ request('type') == 'article' ? 'selected' : '' }}>{{ __('Article') }}</option>
                        <option value="conference" {{ request('type') == 'conference' ? 'selected' : '' }}>{{ __('Conference') }}</option>
                        <option value="patent" {{ request('type') == 'patent' ? 'selected' : '' }}>{{ __('Patent') }}</option>
                        <option value="book" {{ request('type') == 'book' ? 'selected' : '' }}>{{ __('Book') }}</option>
                        <option value="poster" {{ request('type') == 'poster' ? 'selected' : '' }}>{{ __('Poster') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>{{ __('Submitted') }}</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>{{ __('Archived') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="year" class="form-label">{{ __('Year') }}</label>
                    <input type="number" class="form-control" id="year" name="year"
                           value="{{ request('year') }}" placeholder="{{ __('Publication Year') }}" min="1900" max="{{ date('Y') + 5 }}">
                </div>
            </form>
        </div>
    </div>

    <!-- Results Info -->
    @if(isset($publications) && $publications->total() > 0)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted">
                {{ __('Showing :from to :to of :total publications', [
                    'from' => $publications->firstItem(),
                    'to' => $publications->lastItem(),
                    'total' => $publications->total()
                ]) }}
            </div>
            <div class="d-flex align-items-center">
                <label class="form-label mb-0 me-2">{{ __('Per page:') }}</label>
                <form method="GET" action="{{ route('publications.index') }}" class="d-inline">
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

    <!-- Publications Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Authors') }}</th>
                            <th>{{ __('Journal/Conference') }}</th>
                            <th>{{ __('Year') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Citations') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($publications ?? [] as $publication)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @php
                                                $typeIcons = [
                                                    'article' => 'fas fa-file-alt',
                                                    'conference' => 'fas fa-comments',
                                                    'patent' => 'fas fa-lightbulb',
                                                    'book' => 'fas fa-book',
                                                    'poster' => 'fas fa-image'
                                                ];
                                                $typeColors = [
                                                    'article' => 'primary',
                                                    'conference' => 'success',
                                                    'patent' => 'warning',
                                                    'book' => 'info',
                                                    'poster' => 'secondary'
                                                ];
                                                $icon = $typeIcons[$publication->type] ?? 'fas fa-file';
                                                $color = $typeColors[$publication->type] ?? 'secondary';
                                            @endphp
                                            <div class="rounded d-flex align-items-center justify-content-center bg-{{ $color }} text-white" style="width: 40px; height: 40px;">
                                                <i class="{{ $icon }}"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ Str::limit($publication->title, 60) }}</div>
                                            @if($publication->doi)
                                                <small class="text-muted">DOI: {{ $publication->doi }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $typeLabels = [
                                            'article' => __('Article'),
                                            'conference' => __('Conference'),
                                            'patent' => __('Patent'),
                                            'book' => __('Book'),
                                            'poster' => __('Poster')
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $typeLabels[$publication->type] ?? $publication->type }}</span>
                                </td>
                                <td>
                                    @if($publication->authors)
                                        <div>{{ Str::limit($publication->authors, 50) }}</div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($publication->journal || $publication->conference)
                                        <div class="fw-medium">{{ $publication->journal ?? $publication->conference }}</div>
                                        @if($publication->impact_factor)
                                            <small class="text-muted">IF: {{ number_format($publication->impact_factor, 2) }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="fw-medium">{{ $publication->publication_year ?? '-' }}</div>
                                    @if($publication->publication_date)
                                        <small class="text-muted">{{ $publication->publication_date->format('M d') }}</small>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'draft' => 'secondary',
                                            'submitted' => 'warning',
                                            'published' => 'success',
                                            'archived' => 'info'
                                        ];
                                        $statusIcons = [
                                            'draft' => 'fas fa-edit',
                                            'submitted' => 'fas fa-paper-plane',
                                            'published' => 'fas fa-check-circle',
                                            'archived' => 'fas fa-archive'
                                        ];
                                        $statusLabels = [
                                            'draft' => __('Draft'),
                                            'submitted' => __('Submitted'),
                                            'published' => __('Published'),
                                            'archived' => __('Archived')
                                        ];
                                        $statusColor = $statusColors[$publication->status] ?? 'secondary';
                                        $statusIcon = $statusIcons[$publication->status] ?? 'fas fa-question-circle';
                                        $statusLabel = $statusLabels[$publication->status] ?? $publication->status;
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">
                                        <i class="{{ $statusIcon }} me-1"></i>{{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="fw-medium">{{ $publication->citations ?? 0 }}</div>
                                    @if($publication->h_index)
                                        <small class="text-muted">H-index: {{ $publication->h_index }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('publications.show', $publication) }}" class="btn btn-sm btn-outline-primary" title="{{ __('View') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @auth
                                            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager() ||
                                                (auth()->user()->isResearcher() && auth()->user()->researcher &&
                                                 $publication->researchers->contains('user_id', auth()->id())))
                                                <a href="{{ route('publications.edit', $publication) }}" class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if($publication->url)
                                                <a href="{{ $publication->url }}" target="_blank" class="btn btn-sm btn-outline-info" title="{{ __('View Online') }}">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            @endif
                                            @if($publication->file_path)
                                                <a href="{{ asset('storage/' . $publication->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="{{ __('Download PDF') }}">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-file-alt fa-2x mb-2 d-block"></i>
                                    @if(request()->hasAny(['search', 'type', 'status', 'year']))
                                        {{ __('No publications found matching your search criteria') }}
                                    @else
                                        {{ __('No publications have been added yet') }}
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
    @if(isset($publications) && $publications->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $publications->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection