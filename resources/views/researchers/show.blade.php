@extends('layouts.app', ['title' => $researcher->full_name])

@section('content')
<div id="researchers-show-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ $researcher->full_name }}</h2>
            <p class="text-muted mb-0">{{ __('Researcher Profile') }}</p>
        </div>
        <div class="d-flex gap-2">
            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager() || (auth()->user()->researcher && auth()->user()->researcher->id === $researcher->id))
                <a href="{{ route('researchers.edit', $researcher) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>{{ __('Edit Profile') }}
                </a>
            @endif
            <a href="{{ route('researchers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Researchers') }}
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Profile Overview Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            @if($researcher->photo_path)
                                <img src="{{ asset('storage/' . $researcher->photo_path) }}"
                                     alt="{{ $researcher->full_name }}"
                                     class="img-fluid rounded-circle mb-3"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mb-3 mx-auto"
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-4x text-white"></i>
                                </div>
                            @endif

                            <!-- Social Links -->
                            <div class="d-flex justify-content-center gap-2">
                                @if($researcher->google_scholar_url)
                                    <a href="{{ $researcher->google_scholar_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-graduation-cap"></i>
                                    </a>
                                @endif
                                @if($researcher->user->linkedin_url ?? null)
                                    <a href="{{ $researcher->user->linkedin_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                @endif
                                @if($researcher->user->researchgate_url ?? null)
                                    <a href="{{ $researcher->user->researchgate_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fab fa-researchgate"></i>
                                    </a>
                                @endif
                                @if($researcher->user->website_url ?? null)
                                    <a href="{{ $researcher->user->website_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-globe"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-9">
                            <h4 class="fw-bold">{{ $researcher->full_name }}</h4>
                            @if($researcher->user->position ?? null)
                                <p class="text-muted mb-1">{{ $researcher->user->position }}</p>
                            @endif
                            @if($researcher->user->department ?? null)
                                <p class="text-muted mb-2">{{ $researcher->user->department }}</p>
                            @endif

                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <strong>{{ __('Research Domain:') }}</strong><br>
                                    <span class="badge bg-primary">{{ $researcher->research_domain }}</span>
                                </div>
                                @if($researcher->user->orcid)
                                    <div class="col-sm-6">
                                        <strong>{{ __('ORCID ID:') }}</strong><br>
                                        <a href="https://orcid.org/{{ $researcher->user->orcid }}" target="_blank" class="text-decoration-none">
                                            {{ $researcher->user->orcid }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <strong>{{ __('Email:') }}</strong><br>
                                    <a href="mailto:{{ $researcher->user->email }}" class="text-decoration-none">
                                        {{ $researcher->user->email }}
                                    </a>
                                </div>
                                @if($researcher->user->phone)
                                    <div class="col-sm-6">
                                        <strong>{{ __('Phone:') }}</strong><br>
                                        <a href="tel:{{ $researcher->user->phone }}" class="text-decoration-none">
                                            {{ $researcher->user->phone }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            @if($researcher->cv_path)
                                <div class="mb-3">
                                    <a href="{{ asset('storage/' . $researcher->cv_path) }}" target="_blank" class="btn btn-outline-success">
                                        <i class="fas fa-file-pdf me-2"></i>{{ __('Download CV') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biography Card -->
            @if($researcher->getBio())
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-graduate me-2"></i>{{ __('Biography') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs" id="bioTabs" role="tablist">
                            @if($researcher->getBio('en'))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="bio-en-tab" data-bs-toggle="tab" data-bs-target="#bio-en" type="button" role="tab">
                                        <i class="fas fa-flag-usa me-1"></i>English
                                    </button>
                                </li>
                            @endif
                            @if($researcher->getBio('fr'))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ !$researcher->getBio('en') ? 'active' : '' }}" id="bio-fr-tab" data-bs-toggle="tab" data-bs-target="#bio-fr" type="button" role="tab">
                                        <i class="fas fa-flag me-1"></i>Français
                                    </button>
                                </li>
                            @endif
                            @if($researcher->getBio('ar'))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ !$researcher->getBio('en') && !$researcher->getBio('fr') ? 'active' : '' }}" id="bio-ar-tab" data-bs-toggle="tab" data-bs-target="#bio-ar" type="button" role="tab">
                                        <i class="fas fa-flag me-1"></i>العربية
                                    </button>
                                </li>
                            @endif
                        </ul>

                        <div class="tab-content mt-3" id="bioTabContent">
                            @if($researcher->getBio('en'))
                                <div class="tab-pane fade show active" id="bio-en" role="tabpanel">
                                    <p class="text-muted">{{ $researcher->getBio('en') }}</p>
                                </div>
                            @endif
                            @if($researcher->getBio('fr'))
                                <div class="tab-pane fade {{ !$researcher->getBio('en') ? 'show active' : '' }}" id="bio-fr" role="tabpanel">
                                    <p class="text-muted">{{ $researcher->getBio('fr') }}</p>
                                </div>
                            @endif
                            @if($researcher->getBio('ar'))
                                <div class="tab-pane fade {{ !$researcher->getBio('en') && !$researcher->getBio('fr') ? 'show active' : '' }}" id="bio-ar" role="tabpanel">
                                    <p class="text-muted" dir="rtl">{{ $researcher->getBio('ar') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Projects Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-folder me-2"></i>{{ __('Projects') }}
                    </h5>
                    <span class="badge bg-secondary">{{ $researcher->leadProjects()->count() + $researcher->projects()->count() }}</span>
                </div>
                <div class="card-body">
                    @if($researcher->leadProjects()->count() > 0 || $researcher->projects()->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Project Title') }}</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Duration') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($researcher->leadProjects as $project)
                                        <tr>
                                            <td>
                                                <a href="{{ route('projects.show', $project) }}" class="text-decoration-none">
                                                    {{ $project->getTitle() }}
                                                </a>
                                            </td>
                                            <td><span class="badge bg-success">{{ __('Leader') }}</span></td>
                                            <td>
                                                @php
                                                    $statusClass = match($project->status) {
                                                        'active' => 'bg-success',
                                                        'completed' => 'bg-info',
                                                        'pending' => 'bg-warning',
                                                        'cancelled' => 'bg-danger',
                                                        default => 'bg-secondary'
                                                    };
                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ ucfirst($project->status) }}</span>
                                            </td>
                                            <td class="text-muted">
                                                {{ $project->start_date?->format('Y-m-d') }} -
                                                {{ $project->end_date?->format('Y-m-d') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach($researcher->projects as $project)
                                        <tr>
                                            <td>
                                                <a href="{{ route('projects.show', $project) }}" class="text-decoration-none">
                                                    {{ $project->getTitle() }}
                                                </a>
                                            </td>
                                            <td><span class="badge bg-primary">{{ ucfirst($project->pivot->role ?? 'Member') }}</span></td>
                                            <td>
                                                @php
                                                    $statusClass = match($project->status) {
                                                        'active' => 'bg-success',
                                                        'completed' => 'bg-info',
                                                        'pending' => 'bg-warning',
                                                        'cancelled' => 'bg-danger',
                                                        default => 'bg-secondary'
                                                    };
                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ ucfirst($project->status) }}</span>
                                            </td>
                                            <td class="text-muted">
                                                {{ $project->start_date?->format('Y-m-d') }} -
                                                {{ $project->end_date?->format('Y-m-d') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-4">{{ __('No projects found') }}</p>
                    @endif
                </div>
            </div>

            <!-- Publications Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-book me-2"></i>{{ __('Publications') }}
                    </h5>
                    <span class="badge bg-secondary">{{ $researcher->publications()->count() }}</span>
                </div>
                <div class="card-body">
                    @if($researcher->publications()->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($researcher->publications as $publication)
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="{{ route('publications.show', $publication) }}" class="text-decoration-none">
                                                    {{ $publication->title }}
                                                </a>
                                            </h6>
                                            <p class="mb-1 text-muted">{{ $publication->authors }}</p>
                                            <small class="text-muted">
                                                @if($publication->journal)
                                                    {{ $publication->journal }},
                                                @endif
                                                {{ $publication->publication_year }}
                                                @if($publication->doi)
                                                    | DOI: <a href="https://doi.org/{{ $publication->doi }}" target="_blank" class="text-decoration-none">{{ $publication->doi }}</a>
                                                @endif
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-info">{{ ucfirst($publication->type) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">{{ __('No publications found') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Statistics Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>{{ __('Research Statistics') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="h4 fw-bold text-primary">{{ $researcher->leadProjects()->count() + $researcher->projects()->count() }}</div>
                            <div class="small text-muted">{{ __('Projects') }}</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h4 fw-bold text-success">{{ $researcher->publications()->count() }}</div>
                            <div class="small text-muted">{{ __('Publications') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 fw-bold text-info">{{ $researcher->coordinatedCollaborations()->count() }}</div>
                            <div class="small text-muted">{{ __('Collaborations') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 fw-bold text-warning">{{ $researcher->equipmentReservations()->count() }}</div>
                            <div class="small text-muted">{{ __('Equipment Uses') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-address-card me-2"></i>{{ __('Contact Information') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-envelope text-muted me-2"></i>
                        <a href="mailto:{{ $researcher->user->email }}" class="text-decoration-none">
                            {{ $researcher->user->email }}
                        </a>
                    </div>

                    @if($researcher->user->phone)
                        <div class="mb-3">
                            <i class="fas fa-phone text-muted me-2"></i>
                            <a href="tel:{{ $researcher->user->phone }}" class="text-decoration-none">
                                {{ $researcher->user->phone }}
                            </a>
                        </div>
                    @endif

                    @if($researcher->user->position)
                        <div class="mb-3">
                            <i class="fas fa-briefcase text-muted me-2"></i>
                            {{ $researcher->user->position }}
                        </div>
                    @endif

                    @if($researcher->user->department)
                        <div class="mb-3">
                            <i class="fas fa-building text-muted me-2"></i>
                            {{ $researcher->user->department }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <i class="fas fa-calendar text-muted me-2"></i>
                        {{ __('Member since') }} {{ $researcher->created_at->format('F Y') }}
                    </div>
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>{{ __('Recent Activity') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @if($researcher->createdPublications()->latest()->limit(3)->count() > 0)
                            @foreach($researcher->createdPublications()->latest()->limit(3)->get() as $publication)
                                <div class="timeline-item mb-3">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <small class="text-muted">{{ $publication->created_at->diffForHumans() }}</small>
                                        <p class="mb-0">{{ __('Published') }}: {{ Str::limit($publication->title, 50) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if($researcher->equipmentReservations()->latest()->limit(2)->count() > 0)
                            @foreach($researcher->equipmentReservations()->latest()->limit(2)->get() as $reservation)
                                <div class="timeline-item mb-3">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <small class="text-muted">{{ $reservation->created_at->diffForHumans() }}</small>
                                        <p class="mb-0">{{ __('Used equipment') }}: {{ $reservation->equipment->getName() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if($researcher->createdPublications()->count() === 0 && $researcher->equipmentReservations()->count() === 0)
                            <p class="text-muted text-center">{{ __('No recent activity') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline-item {
    position: relative;
    padding-left: 30px;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-content {
    padding-left: 10px;
}
</style>
@endpush