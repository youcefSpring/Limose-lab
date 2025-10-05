@extends('layouts.app', ['title' => $project->getTitle()])

@section('content')
<div id="projects-show-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ $project->getTitle() }}</h2>
            <p class="text-muted mb-0">{{ __('Project Details') }}</p>
        </div>
        <div class="d-flex gap-2">
            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager() || (auth()->user()->researcher && $project->leader_id === auth()->user()->researcher->id))
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>{{ __('Edit Project') }}
                </a>
            @endif
            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Projects') }}
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Project Overview Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>{{ __('Project Overview') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>{{ __('Project Leader:') }}</strong><br>
                            <a href="{{ route('researchers.show', $project->leader) }}" class="text-decoration-none">
                                {{ $project->leader->full_name }}
                            </a>
                        </div>
                        <div class="col-md-6">
                            <strong>{{ __('Status:') }}</strong><br>
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
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>{{ __('Start Date:') }}</strong><br>
                            {{ $project->start_date?->format('F j, Y') }}
                        </div>
                        <div class="col-md-6">
                            <strong>{{ __('End Date:') }}</strong><br>
                            {{ $project->end_date?->format('F j, Y') }}
                        </div>
                    </div>

                    @if($project->budget)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>{{ __('Budget:') }}</strong><br>
                                ${{ number_format($project->budget, 2) }} USD
                            </div>
                            <div class="col-md-6">
                                <strong>{{ __('Duration:') }}</strong><br>
                                {{ $project->start_date?->diffInDays($project->end_date) }} {{ __('days') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Project Description Card -->
            @if($project->getDescription())
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-text me-2"></i>{{ __('Project Description') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs" id="descTabs" role="tablist">
                            @if($project->getDescription('en'))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="desc-en-tab" data-bs-toggle="tab" data-bs-target="#desc-en" type="button" role="tab">
                                        <i class="fas fa-flag-usa me-1"></i>English
                                    </button>
                                </li>
                            @endif
                            @if($project->getDescription('fr'))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ !$project->getDescription('en') ? 'active' : '' }}" id="desc-fr-tab" data-bs-toggle="tab" data-bs-target="#desc-fr" type="button" role="tab">
                                        <i class="fas fa-flag me-1"></i>Français
                                    </button>
                                </li>
                            @endif
                            @if($project->getDescription('ar'))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ !$project->getDescription('en') && !$project->getDescription('fr') ? 'active' : '' }}" id="desc-ar-tab" data-bs-toggle="tab" data-bs-target="#desc-ar" type="button" role="tab">
                                        <i class="fas fa-flag me-1"></i>العربية
                                    </button>
                                </li>
                            @endif
                        </ul>

                        <div class="tab-content mt-3" id="descTabContent">
                            @if($project->getDescription('en'))
                                <div class="tab-pane fade show active" id="desc-en" role="tabpanel">
                                    <p class="text-muted">{{ $project->getDescription('en') }}</p>
                                </div>
                            @endif
                            @if($project->getDescription('fr'))
                                <div class="tab-pane fade {{ !$project->getDescription('en') ? 'show active' : '' }}" id="desc-fr" role="tabpanel">
                                    <p class="text-muted">{{ $project->getDescription('fr') }}</p>
                                </div>
                            @endif
                            @if($project->getDescription('ar'))
                                <div class="tab-pane fade {{ !$project->getDescription('en') && !$project->getDescription('fr') ? 'show active' : '' }}" id="desc-ar" role="tabpanel">
                                    <p class="text-muted" dir="rtl">{{ $project->getDescription('ar') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Team Members -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>{{ __('Team Members') }}
                    </h5>
                    <span class="badge bg-secondary">{{ $project->members()->count() + 1 }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Project Leader -->
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center p-3 border rounded">
                                @if($project->leader->photo_path)
                                    <img src="{{ asset('storage/' . $project->leader->photo_path) }}"
                                         alt="{{ $project->leader->full_name }}"
                                         class="rounded-circle me-3"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1">
                                        <a href="{{ route('researchers.show', $project->leader) }}" class="text-decoration-none">
                                            {{ $project->leader->full_name }}
                                        </a>
                                    </h6>
                                    <span class="badge bg-success">{{ __('Leader') }}</span>
                                    <small class="d-block text-muted">{{ $project->leader->research_domain }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Team Members -->
                        @foreach($project->members as $member)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center p-3 border rounded">
                                    @if($member->photo_path)
                                        <img src="{{ asset('storage/' . $member->photo_path) }}"
                                             alt="{{ $member->full_name }}"
                                             class="rounded-circle me-3"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3"
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-1">
                                            <a href="{{ route('researchers.show', $member) }}" class="text-decoration-none">
                                                {{ $member->full_name }}
                                            </a>
                                        </h6>
                                        <span class="badge bg-primary">{{ ucfirst($member->pivot->role ?? 'Member') }}</span>
                                        <small class="d-block text-muted">{{ $member->research_domain }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Publications -->
            @if($project->publications()->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-book me-2"></i>{{ __('Related Publications') }}
                        </h5>
                        <span class="badge bg-secondary">{{ $project->publications()->count() }}</span>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($project->publications as $publication)
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
                                                {{ $publication->journal ?? $publication->conference }}, {{ $publication->publication_year }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-info">{{ ucfirst($publication->type) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Project Statistics -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>{{ __('Project Statistics') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="h4 fw-bold text-primary">{{ $project->members()->count() + 1 }}</div>
                            <div class="small text-muted">{{ __('Team Members') }}</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h4 fw-bold text-success">{{ $project->publications()->count() }}</div>
                            <div class="small text-muted">{{ __('Publications') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 fw-bold text-info">{{ $project->equipmentReservations()->count() }}</div>
                            <div class="small text-muted">{{ __('Equipment Uses') }}</div>
                        </div>
                        <div class="col-6">
                            @if($project->start_date && $project->end_date)
                                <div class="h4 fw-bold text-warning">{{ $project->start_date->diffInDays($project->end_date) }}</div>
                                <div class="small text-muted">{{ __('Duration (days)') }}</div>
                            @else
                                <div class="h4 fw-bold text-muted">-</div>
                                <div class="small text-muted">{{ __('Duration') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Timeline -->
            @if($project->start_date && $project->end_date)
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-calendar me-2"></i>{{ __('Project Timeline') }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>{{ __('Start Date') }}</strong><br>
                            <span class="text-muted">{{ $project->start_date->format('F j, Y') }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>{{ __('End Date') }}</strong><br>
                            <span class="text-muted">{{ $project->end_date->format('F j, Y') }}</span>
                        </div>
                        <div class="mb-3">
                            <strong>{{ __('Progress') }}</strong><br>
                            @php
                                $totalDays = $project->start_date->diffInDays($project->end_date);
                                $elapsedDays = max(0, min($totalDays, $project->start_date->diffInDays(now())));
                                $progress = $totalDays > 0 ? ($elapsedDays / $totalDays) * 100 : 0;
                            @endphp
                            <div class="progress mb-2">
                                <div class="progress-bar" style="width: {{ $progress }}%"></div>
                            </div>
                            <small class="text-muted">{{ round($progress) }}% {{ __('complete') }}</small>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-lightning-bolt me-2"></i>{{ __('Quick Actions') }}
                    </h6>
                </div>
                <div class="card-body">
                    @if(auth()->user()->isAdmin() || auth()->user()->isLabManager() || (auth()->user()->researcher && $project->leader_id === auth()->user()->researcher->id))
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">
                            <i class="fas fa-edit me-2"></i>{{ __('Edit Project') }}
                        </a>
                    @endif
                    <a href="{{ route('publications.create', ['project_id' => $project->id]) }}" class="btn btn-outline-success btn-sm w-100 mb-2">
                        <i class="fas fa-plus me-2"></i>{{ __('Add Publication') }}
                    </a>
                    <a href="{{ route('equipment.index', ['project_id' => $project->id]) }}" class="btn btn-outline-info btn-sm w-100 mb-2">
                        <i class="fas fa-tools me-2"></i>{{ __('Reserve Equipment') }}
                    </a>
                    <a href="mailto:{{ $project->leader->user->email }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-envelope me-2"></i>{{ __('Contact Leader') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection