@extends('layouts.adminlte')

@section('title', 'Researchers')
@section('page-title', 'Researchers Management')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item active">Researchers</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $researchers->total() ?? 0 }}</h3>
                    <p>Total Researchers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $researchers->where('status', 'active')->count() ?? 0 }}</h3>
                    <p>Active Researchers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $researchers->where('research_domain', '!=', null)->unique('research_domain')->count() ?? 0 }}</h3>
                    <p>Research Domains</p>
                </div>
                <div class="icon">
                    <i class="fas fa-microscope"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $researchers->where('created_at', '>=', now()->subMonth())->count() ?? 0 }}</h3>
                    <p>New This Month</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-users mr-1"></i>
                Researchers Directory
            </h3>
            <div class="card-tools">
                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                        <a href="{{ route('researchers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>Add Researcher
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="card-body filter-container">
            <form method="GET" action="{{ route('researchers.index') }}" class="filter-form">
                <div class="form-group search-field">
                    <label for="search" class="form-label">Search Researchers</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="Name, email, institution...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group select-field">
                    <label for="domain" class="form-label">Research Domain</label>
                    <select class="form-control" id="domain" name="domain">
                        <option value="">All Domains</option>
                        <option value="computer_science" {{ request('domain') == 'computer_science' ? 'selected' : '' }}>Computer Science</option>
                        <option value="biology" {{ request('domain') == 'biology' ? 'selected' : '' }}>Biology</option>
                        <option value="chemistry" {{ request('domain') == 'chemistry' ? 'selected' : '' }}>Chemistry</option>
                        <option value="physics" {{ request('domain') == 'physics' ? 'selected' : '' }}>Physics</option>
                        <option value="engineering" {{ request('domain') == 'engineering' ? 'selected' : '' }}>Engineering</option>
                        <option value="medicine" {{ request('domain') == 'medicine' ? 'selected' : '' }}>Medicine</option>
                        <option value="mathematics" {{ request('domain') == 'mathematics' ? 'selected' : '' }}>Mathematics</option>
                        <option value="other" {{ request('domain') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="form-group select-field">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="form-group btn-field">
                    <button type="submit" class="btn btn-filter-primary">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    @if(request()->hasAny(['search', 'domain', 'status']))
                        <a href="{{ route('researchers.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Researchers Grid -->
        <div class="card-body">
            @if(isset($researchers) && $researchers->count() > 0)
                <div class="row">
                    @foreach($researchers as $researcher)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card card-widget widget-user">
                                <div class="widget-user-header bg-gradient-primary">
                                    <h3 class="widget-user-username">{{ $researcher->full_name ?? 'N/A' }}</h3>
                                    <h5 class="widget-user-desc">{{ $researcher->research_domain ?? 'Research Domain' }}</h5>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="{{ $researcher->avatar ?? 'https://via.placeholder.com/90x90/007bff/ffffff?text=' . substr($researcher->full_name ?? 'R', 0, 1) }}" alt="User Avatar">
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ $researcher->projects_count ?? 0 }}</h5>
                                                <span class="description-text">PROJECTS</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ $researcher->publications_count ?? 0 }}</h5>
                                                <span class="description-text">PUBLICATIONS</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ $researcher->collaborations_count ?? 0 }}</h5>
                                                <span class="description-text">COLLABORATIONS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="text-muted">
                                                <p class="text-sm mb-1">
                                                    <i class="fas fa-university mr-1"></i>
                                                    {{ $researcher->institution ?? 'Institution not specified' }}
                                                </p>
                                                <p class="text-sm mb-1">
                                                    <i class="fas fa-envelope mr-1"></i>
                                                    {{ $researcher->email ?? 'Email not available' }}
                                                </p>
                                                @if($researcher->phone)
                                                <p class="text-sm mb-1">
                                                    <i class="fas fa-phone mr-1"></i>
                                                    {{ $researcher->phone }}
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="btn-group w-100">
                                                <a href="{{ route('researchers.show', $researcher) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                @auth
                                                    @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                                                        <a href="{{ route('researchers.edit', $researcher) }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        @if(auth()->user()->isAdmin())
                                                            <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $researcher->id }})">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($researchers->hasPages())
                    <div class="row">
                        <div class="col-12">
                            <div class="card-tools float-right">
                                {{ $researchers->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-users fa-5x text-muted mb-4"></i>
                        <h4 class="text-muted">No Researchers Found</h4>
                        @if(request()->hasAny(['search', 'domain', 'status']))
                            <p class="text-muted">No researchers match your search criteria.</p>
                            <a href="{{ route('researchers.index') }}" class="btn btn-primary">
                                <i class="fas fa-times mr-1"></i>Clear Filters
                            </a>
                        @else
                            <p class="text-muted">No researchers have been added yet.</p>
                            @auth
                                @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                                    <a href="{{ route('researchers.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus mr-1"></i>Add First Researcher
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.filter-container {
    background-color: #f8f9fa;
    border-radius: 0.5rem;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
}

.filter-form {
    display: flex;
    align-items: end;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-form .form-group {
    margin-bottom: 0;
    min-width: 0;
}

.filter-form .search-field {
    flex: 1;
    min-width: 300px;
}

.filter-form .select-field {
    min-width: 180px;
}

.filter-form .btn-field {
    flex-shrink: 0;
}

.filter-form .form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.filter-form .form-control {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    background-color: white;
}

.filter-form .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.filter-form .input-group .btn {
    border-radius: 0 0.375rem 0.375rem 0;
    border-left: none;
}

.btn-filter-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
}

.btn-filter-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

@media (max-width: 768px) {
    .filter-form {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-form .search-field,
    .filter-form .select-field {
        min-width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(researcherId) {
    if (confirm('Are you sure you want to delete this researcher? This action cannot be undone.')) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/researchers/${researcherId}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';

        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush