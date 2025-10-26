@extends('layouts.adminlte')

@section('title', $researcher->full_name ?? 'Researcher Profile')
@section('page-title', 'Researcher Profile')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('researchers.index') }}">Researchers</a></li>
<li class="breadcrumb-item active">{{ $researcher->full_name ?? 'Profile' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Main Profile Card -->
        <div class="col-md-12">
            <div class="card card-widget widget-user">
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username">{{ $researcher->full_name ?? 'Researcher' }}</h3>
                    <h5 class="widget-user-desc">{{ $researcher->research_domain ?? 'Research Domain' }}</h5>
                    <!-- Action Buttons -->
                    <div class="widget-user-actions">
                        @auth
                            @if(auth()->user()->canManageResearchers())
                                <a href="{{ route('researchers.edit', $researcher) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit mr-1"></i>Edit Profile
                                </a>
                            @endif
                        @endauth
                        <a href="{{ route('researchers.index') }}" class="btn btn-secondary btn-sm ml-2">
                            <i class="fas fa-arrow-left mr-1"></i>Back to List
                        </a>
                    </div>
                </div>
                <div class="widget-user-image">
                    @if($researcher->avatar)
                        <img class="img-circle elevation-2" src="{{ $researcher->avatar }}" alt="User Avatar">
                    @else
                        <img class="img-circle elevation-2" src="https://via.placeholder.com/90x90/007bff/ffffff?text={{ substr($researcher->full_name ?? 'R', 0, 1) }}" alt="User Avatar">
                    @endif
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-3 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $researcher->projects_count ?? 0 }}</h5>
                                <span class="description-text">PROJECTS</span>
                            </div>
                        </div>
                        <div class="col-sm-3 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $researcher->publications_count ?? 0 }}</h5>
                                <span class="description-text">PUBLICATIONS</span>
                            </div>
                        </div>
                        <div class="col-sm-3 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $researcher->collaborations_count ?? 0 }}</h5>
                                <span class="description-text">COLLABORATIONS</span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="description-block">
                                <h5 class="description-header">{{ $researcher->equipment_uses ?? 0 }}</h5>
                                <span class="description-text">EQUIPMENT USES</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-md-8">
            <!-- Personal Information -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-1"></i>
                        Personal Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                            <p class="text-muted">{{ $researcher->email ?? 'Not provided' }}</p>
                            <hr>
                            <strong><i class="fas fa-phone mr-1"></i> Phone</strong>
                            <p class="text-muted">{{ $researcher->phone ?? 'Not provided' }}</p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Institution</strong>
                            <p class="text-muted">{{ $researcher->institution ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <strong><i class="fas fa-briefcase mr-1"></i> Position</strong>
                            <p class="text-muted">{{ $researcher->position ?? 'Not provided' }}</p>
                            <hr>
                            <strong><i class="fas fa-id-badge mr-1"></i> ORCID ID</strong>
                            <p class="text-muted">
                                @if($researcher->orcid)
                                    <a href="https://orcid.org/{{ $researcher->orcid }}" target="_blank">{{ $researcher->orcid }}</a>
                                @else
                                    Not provided
                                @endif
                            </p>
                            <hr>
                            <strong><i class="fas fa-calendar-alt mr-1"></i> Member Since</strong>
                            <p class="text-muted">{{ $researcher->created_at ? $researcher->created_at->format('F d, Y') : 'Unknown' }}</p>
                        </div>
                    </div>

                    @if($researcher->bio)
                        <hr>
                        <strong><i class="fas fa-file-alt mr-1"></i> Biography</strong>
                        <p class="text-muted">{{ $researcher->bio }}</p>
                    @endif
                </div>
            </div>

            <!-- Research Information -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-microscope mr-1"></i>
                        Research Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <strong><i class="fas fa-flask mr-1"></i> Research Domain</strong>
                            <p class="text-muted">
                                <span class="badge badge-primary">{{ ucfirst(str_replace('_', ' ', $researcher->research_domain ?? 'Not specified')) }}</span>
                            </p>
                        </div>
                    </div>

                    @if($researcher->website)
                        <hr>
                        <strong><i class="fas fa-globe mr-1"></i> Website</strong>
                        <p class="text-muted">
                            <a href="{{ $researcher->website }}" target="_blank">{{ $researcher->website }}</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <!-- Status Card -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-1"></i>
                        Status
                    </h3>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        @php
                            $statusColor = $researcher->status === 'active' ? 'success' : 'secondary';
                            $statusText = ucfirst($researcher->status ?? 'unknown');
                            $publicText = $researcher->is_public ? 'Public Profile' : 'Private Profile';
                            $publicColor = $researcher->is_public ? 'primary' : 'warning';
                        @endphp
                        <h4>
                            <span class="badge badge-{{ $statusColor }}">{{ $statusText }}</span>
                        </h4>
                        <p>
                            <span class="badge badge-{{ $publicColor }}">{{ $publicText }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs mr-1"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="btn-group-vertical w-100">
                        @auth
                            @if(auth()->user()->canManageResearchers())
                                <a href="{{ route('researchers.edit', $researcher) }}" class="btn btn-primary mb-2">
                                    <i class="fas fa-edit mr-1"></i>Edit Profile
                                </a>
                            @endif
                        @endauth

                        @if($researcher->email)
                            <a href="mailto:{{ $researcher->email }}" class="btn btn-info mb-2">
                                <i class="fas fa-envelope mr-1"></i>Send Email
                            </a>
                        @endif

                        @if($researcher->phone)
                            <a href="tel:{{ $researcher->phone }}" class="btn btn-success mb-2">
                                <i class="fas fa-phone mr-1"></i>Call
                            </a>
                        @endif

                        @if($researcher->website)
                            <a href="{{ $researcher->website }}" target="_blank" class="btn btn-secondary mb-2">
                                <i class="fas fa-globe mr-1"></i>Visit Website
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            @if($researcher->orcid || $researcher->website)
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-share-alt mr-1"></i>
                            Social Links
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            @if($researcher->orcid)
                                <a href="https://orcid.org/{{ $researcher->orcid }}" target="_blank" class="btn btn-outline-success btn-sm mr-2 mb-2">
                                    <i class="fas fa-id-badge"></i> ORCID
                                </a>
                            @endif

                            @if($researcher->website)
                                <a href="{{ $researcher->website }}" target="_blank" class="btn btn-outline-primary btn-sm mr-2 mb-2">
                                    <i class="fas fa-globe"></i> Website
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection