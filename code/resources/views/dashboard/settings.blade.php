@extends('layouts.adminlte')

@section('title', 'Settings')
@section('page-title', 'Account Settings')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item active">Settings</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-cog me-2"></i>{{ __('Account Settings') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                                <a class="nav-link active" id="v-pills-general-tab" data-bs-toggle="pill" href="#v-pills-general">
                                    <i class="fas fa-user me-2"></i>{{ __('General') }}
                                </a>
                                <a class="nav-link" id="v-pills-security-tab" data-bs-toggle="pill" href="#v-pills-security">
                                    <i class="fas fa-shield-alt me-2"></i>{{ __('Security') }}
                                </a>
                                <a class="nav-link" id="v-pills-notifications-tab" data-bs-toggle="pill" href="#v-pills-notifications">
                                    <i class="fas fa-bell me-2"></i>{{ __('Notifications') }}
                                </a>
                                <a class="nav-link" id="v-pills-preferences-tab" data-bs-toggle="pill" href="#v-pills-preferences">
                                    <i class="fas fa-palette me-2"></i>{{ __('Preferences') }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <!-- General Settings -->
                                <div class="tab-pane fade show active" id="v-pills-general">
                                    <h6 class="mb-3">{{ __('General Settings') }}</h6>
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Full Name') }}</label>
                                            <input type="text" class="form-control" value="{{ $user->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Email') }}</label>
                                            <input type="email" class="form-control" value="{{ $user->email }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Language') }}</label>
                                            <select class="form-select">
                                                <option value="en">English</option>
                                                <option value="fr">Français</option>
                                                <option value="ar">العربية</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                                    </form>
                                </div>

                                <!-- Security Settings -->
                                <div class="tab-pane fade" id="v-pills-security">
                                    <h6 class="mb-3">{{ __('Security Settings') }}</h6>
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Current Password') }}</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('New Password') }}</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('Confirm New Password') }}</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="two-factor">
                                                <label class="form-check-label" for="two-factor">
                                                    {{ __('Enable Two-Factor Authentication') }}
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>
                                    </form>
                                </div>

                                <!-- Notifications -->
                                <div class="tab-pane fade" id="v-pills-notifications">
                                    <h6 class="mb-3">{{ __('Notification Preferences') }}</h6>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="email-notifications" checked>
                                            <label class="form-check-label" for="email-notifications">
                                                {{ __('Email Notifications') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="project-updates" checked>
                                            <label class="form-check-label" for="project-updates">
                                                {{ __('Project Updates') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="equipment-alerts">
                                            <label class="form-check-label" for="equipment-alerts">
                                                {{ __('Equipment Alerts') }}
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{ __('Save Preferences') }}</button>
                                </div>

                                <!-- Preferences -->
                                <div class="tab-pane fade" id="v-pills-preferences">
                                    <h6 class="mb-3">{{ __('Display Preferences') }}</h6>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Theme') }}</label>
                                        <select class="form-select">
                                            <option value="light">{{ __('Light') }}</option>
                                            <option value="dark">{{ __('Dark') }}</option>
                                            <option value="auto">{{ __('Auto') }}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Dashboard Layout') }}</label>
                                        <select class="form-select">
                                            <option value="default">{{ __('Default') }}</option>
                                            <option value="compact">{{ __('Compact') }}</option>
                                            <option value="expanded">{{ __('Expanded') }}</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{ __('Save Preferences') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection