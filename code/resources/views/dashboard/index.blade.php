@extends('layouts.adminlte')

@section('title', __('Dashboard'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-md-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-semibold mb-0">{{ __('Welcome back, :name', ['name' => auth()->user()->name]) }}</h3>
                    <p class="text-muted mb-0">{{ __(ucfirst(auth()->user()->role)) }} • {{ now()->format('F j, Y') }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('dashboard.profile') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-user me-2"></i>{{ __('Profile') }}
                    </a>
                    <a href="{{ route('dashboard.settings') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-cog me-2"></i>{{ __('Settings') }}
                    </a>
                </div>
            </div>

            @if(auth()->user()->role === 'admin')
                @include('dashboard.partials.admin-dashboard-clean')
            @elseif(auth()->user()->role === 'lab_manager')
                @include('dashboard.partials.lab-manager-dashboard-clean')
            @elseif(auth()->user()->role === 'researcher')
                @include('dashboard.partials.researcher-dashboard-clean')
            @else
                @include('dashboard.partials.visitor-dashboard-clean')
            @endif
        </div>
    </div>
</div>

@endsection