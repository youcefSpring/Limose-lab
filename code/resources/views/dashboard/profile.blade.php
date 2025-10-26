@extends('layouts.adminlte')

@section('title', 'Profile')
@section('page-title', 'My Profile')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>{{ __('My Profile') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="profile-avatar mb-3">
                                <i class="fas fa-user-circle fa-5x text-muted"></i>
                            </div>
                            <h5>{{ $user->name }}</h5>
                            <p class="text-muted">{{ __(ucfirst($user->role)) }}</p>
                        </div>
                        <div class="col-md-8">
                            <h6 class="mb-3">{{ __('Profile Information') }}</h6>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>{{ __('Name') }}:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $user->name }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>{{ __('Email') }}:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $user->email }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>{{ __('Role') }}:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <span class="badge bg-primary">{{ __(ucfirst($user->role)) }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>{{ __('Member Since') }}:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $user->created_at->format('F j, Y') }}
                                </div>
                            </div>

                            @if($user->researcher)
                            <hr>
                            <h6 class="mb-3">{{ __('Research Information') }}</h6>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>{{ __('Research Domain') }}:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $user->researcher->research_domain ?? __('Not specified') }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>{{ __('Institution') }}:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $user->researcher->institution ?? __('Not specified') }}
                                </div>
                            </div>
                            @endif

                            <div class="mt-4">
                                <a href="#" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>{{ __('Edit Profile') }}
                                </a>
                                <a href="{{ route('dashboard.settings') }}" class="btn btn-secondary">
                                    <i class="fas fa-cog me-2"></i>{{ __('Settings') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection