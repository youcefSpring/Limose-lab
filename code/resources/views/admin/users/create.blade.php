@extends('layouts.adminlte')

@section('title', 'Create User')
@section('page-title', 'Create New User')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
<li class="breadcrumb-item active">Create User</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Main Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-plus mr-1"></i>
                        Create New User
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users') }}" class="btn btn-tool" title="Back to Users">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <!-- Personal Information -->
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Personal Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                           id="name" name="name" value="{{ old('name') }}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                           id="email" name="email" value="{{ old('email') }}" required>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                           id="password" name="password" required>
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control"
                                                           id="password_confirmation" name="password_confirmation" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">Phone Number</label>
                                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                           id="phone" name="phone" value="{{ old('phone') }}">
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="department">Department</label>
                                                    <input type="text" class="form-control @error('department') is-invalid @enderror"
                                                           id="department" name="department" value="{{ old('department') }}">
                                                    @error('department')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="bio">Biography</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                                      id="bio" name="bio" rows="3">{{ old('bio') }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- User Settings -->
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">User Settings</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="role">Role <span class="text-danger">*</span></label>
                                            <select class="form-control @error('role') is-invalid @enderror"
                                                    id="role" name="role" required>
                                                <option value="">Select Role</option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="lab_manager" {{ old('role') == 'lab_manager' ? 'selected' : '' }}>Lab Manager</option>
                                                <option value="researcher" {{ old('role') == 'researcher' ? 'selected' : '' }}>Researcher</option>
                                                <option value="visitor" {{ old('role') == 'visitor' ? 'selected' : '' }}>Visitor</option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                    id="status" name="status">
                                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="preferred_language">Preferred Language</label>
                                            <select class="form-control @error('preferred_language') is-invalid @enderror"
                                                    id="preferred_language" name="preferred_language">
                                                <option value="en" {{ old('preferred_language', 'en') == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="fr" {{ old('preferred_language') == 'fr' ? 'selected' : '' }}>Français</option>
                                                <option value="ar" {{ old('preferred_language') == 'ar' ? 'selected' : '' }}>العربية</option>
                                            </select>
                                            @error('preferred_language')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_active">Account Active</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="email_verified" name="email_verified" value="1" {{ old('email_verified') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="email_verified">Email Verified</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Picture -->
                                <div class="card card-outline card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Profile Picture</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="form-group">
                                            <img id="profile-preview" src="https://via.placeholder.com/150x150/667eea/ffffff?text=?"
                                                 alt="Profile Preview" class="img-circle img-fluid mb-3" style="width: 150px; height: 150px;">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="avatar" name="avatar" accept="image/*">
                                                <label class="custom-file-label" for="avatar">Choose file</label>
                                            </div>
                                            <small class="form-text text-muted">Max size: 2MB. Supported: JPG, PNG, GIF</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>Create User
                                </button>
                                <a href="{{ route('admin.users') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times mr-1"></i>Cancel
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">Fields marked with <span class="text-danger">*</span> are required</small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Profile picture preview
    $('#avatar').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profile-preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Update file input label
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    // Password confirmation validation
    $('#password_confirmation').on('keyup', function() {
        const password = $('#password').val();
        const confirmPassword = $(this).val();

        if (password !== confirmPassword) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
});
</script>
@endpush