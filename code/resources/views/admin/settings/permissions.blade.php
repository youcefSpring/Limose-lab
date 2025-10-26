@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('Permissions Settings') }}</h1>
            <p class="text-muted mb-0">{{ __('Manage user roles and access permissions') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.settings') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Settings') }}
            </a>
        </div>
    </div>

    <!-- Roles Overview -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <i class="fas fa-shield-alt fa-3x text-danger mb-2"></i>
                    <h5 class="card-title">{{ __('Admin') }}</h5>
                    <p class="text-muted small">{{ __('Full system access') }}</p>
                    <span class="badge bg-danger">{{ __('Highest Level') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-flask fa-3x text-warning mb-2"></i>
                    <h5 class="card-title">{{ __('Lab Manager') }}</h5>
                    <p class="text-muted small">{{ __('Lab operations & equipment') }}</p>
                    <span class="badge bg-warning">{{ __('Management') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-user-graduate fa-3x text-success mb-2"></i>
                    <h5 class="card-title">{{ __('Researcher') }}</h5>
                    <p class="text-muted small">{{ __('Research activities') }}</p>
                    <span class="badge bg-success">{{ __('Standard') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-eye fa-3x text-info mb-2"></i>
                    <h5 class="card-title">{{ __('Visitor') }}</h5>
                    <p class="text-muted small">{{ __('Read-only access') }}</p>
                    <span class="badge bg-info">{{ __('Limited') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Matrix -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-table me-2"></i>{{ __('Permissions Matrix') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>{{ __('Module / Action') }}</th>
                            <th class="text-center">{{ __('Admin') }}</th>
                            <th class="text-center">{{ __('Lab Manager') }}</th>
                            <th class="text-center">{{ __('Researcher') }}</th>
                            <th class="text-center">{{ __('Visitor') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- User Management -->
                        <tr>
                            <th colspan="5" class="table-secondary">{{ __('User Management') }}</th>
                        </tr>
                        <tr>
                            <td>{{ __('Create Users') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td>{{ __('Edit Users') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-minus text-warning"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td>{{ __('Delete Users') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>

                        <!-- Project Management -->
                        <tr>
                            <th colspan="5" class="table-secondary">{{ __('Project Management') }}</th>
                        </tr>
                        <tr>
                            <td>{{ __('Create Projects') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td>{{ __('Edit Own Projects') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td>{{ __('Edit All Projects') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>

                        <!-- Equipment Management -->
                        <tr>
                            <th colspan="5" class="table-secondary">{{ __('Equipment Management') }}</th>
                        </tr>
                        <tr>
                            <td>{{ __('Add Equipment') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td>{{ __('Reserve Equipment') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td>{{ __('Equipment Maintenance') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>

                        <!-- Funding Management -->
                        <tr>
                            <th colspan="5" class="table-secondary">{{ __('Funding Management') }}</th>
                        </tr>
                        <tr>
                            <td>{{ __('Add Funding') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td>{{ __('View Funding') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-minus text-warning"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>

                        <!-- System Settings -->
                        <tr>
                            <th colspan="5" class="table-secondary">{{ __('System Administration') }}</th>
                        </tr>
                        <tr>
                            <td>{{ __('System Settings') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                            <td>{{ __('View Analytics') }}</td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-check text-success"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                            <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Legend -->
            <div class="mt-3">
                <h6>{{ __('Legend:') }}</h6>
                <div class="d-flex gap-3 flex-wrap">
                    <span><i class="fas fa-check text-success me-1"></i>{{ __('Full Access') }}</span>
                    <span><i class="fas fa-minus text-warning me-1"></i>{{ __('Limited Access') }}</span>
                    <span><i class="fas fa-times text-danger me-1"></i>{{ __('No Access') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Management Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-tools me-2"></i>{{ __('Role Management Actions') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>{{ __('Available Actions:') }}</h6>
                            <ul>
                                <li>{{ __('Create custom roles (Coming Soon)') }}</li>
                                <li>{{ __('Modify role permissions (Coming Soon)') }}</li>
                                <li>{{ __('Assign users to roles') }}</li>
                                <li>{{ __('View role audit logs (Coming Soon)') }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>{{ __('Quick Actions:') }}</h6>
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary btn-sm me-2 mb-2">
                                <i class="fas fa-users me-1"></i>{{ __('Manage Users') }}
                            </a>
                            <button class="btn btn-outline-secondary btn-sm mb-2" disabled>
                                <i class="fas fa-plus me-1"></i>{{ __('Create Role') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection