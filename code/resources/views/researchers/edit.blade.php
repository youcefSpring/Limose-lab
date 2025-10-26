@extends('layouts.adminlte')

@section('title', 'Edit Researcher')
@section('page-title', 'Edit Researcher Profile')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('researchers.index') }}">Researchers</a></li>
<li class="breadcrumb-item"><a href="{{ route('researchers.show', $researcher) }}">{{ $researcher->full_name ?? 'Researcher' }}</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Main Card -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit mr-1"></i>
                        Edit Researcher Profile
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('researchers.show', $researcher) }}" class="btn btn-tool" title="View Profile">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('researchers.index') }}" class="btn btn-tool" title="Back to Researchers">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('researchers.update', $researcher) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                           id="first_name" name="first_name" value="{{ old('first_name', $researcher->first_name) }}" required>
                                                    @error('first_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                           id="last_name" name="last_name" value="{{ old('last_name', $researcher->last_name) }}" required>
                                                    @error('last_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                           id="email" name="email" value="{{ old('email', $researcher->email) }}" required>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">Phone Number</label>
                                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                           id="phone" name="phone" value="{{ old('phone', $researcher->phone) }}">
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Professional Information -->
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Professional Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="research_domain">Research Domain <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('research_domain') is-invalid @enderror"
                                                            id="research_domain" name="research_domain" required>
                                                        <option value="">Select Research Domain</option>
                                                        <option value="computer_science" {{ old('research_domain', $researcher->research_domain) == 'computer_science' ? 'selected' : '' }}>Computer Science</option>
                                                        <option value="biology" {{ old('research_domain', $researcher->research_domain) == 'biology' ? 'selected' : '' }}>Biology</option>
                                                        <option value="chemistry" {{ old('research_domain', $researcher->research_domain) == 'chemistry' ? 'selected' : '' }}>Chemistry</option>
                                                        <option value="physics" {{ old('research_domain', $researcher->research_domain) == 'physics' ? 'selected' : '' }}>Physics</option>
                                                        <option value="engineering" {{ old('research_domain', $researcher->research_domain) == 'engineering' ? 'selected' : '' }}>Engineering</option>
                                                        <option value="medicine" {{ old('research_domain', $researcher->research_domain) == 'medicine' ? 'selected' : '' }}>Medicine</option>
                                                        <option value="mathematics" {{ old('research_domain', $researcher->research_domain) == 'mathematics' ? 'selected' : '' }}>Mathematics</option>
                                                        <option value="other" {{ old('research_domain', $researcher->research_domain) == 'other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                    @error('research_domain')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="position">Position/Title</label>
                                                    <input type="text" class="form-control @error('position') is-invalid @enderror"
                                                           id="position" name="position" value="{{ old('position', $researcher->position) }}"
                                                           placeholder="e.g., Research Scientist, PhD Student">
                                                    @error('position')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="institution">Institution/University <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('institution') is-invalid @enderror"
                                                   id="institution" name="institution" value="{{ old('institution', $researcher->institution) }}" required>
                                            @error('institution')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="bio">Biography/Research Interests</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                                      id="bio" name="bio" rows="4" placeholder="Brief description of research interests and background">{{ old('bio', $researcher->bio) }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Additional Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="orcid">ORCID ID</label>
                                                    <input type="text" class="form-control @error('orcid') is-invalid @enderror"
                                                           id="orcid" name="orcid" value="{{ old('orcid', $researcher->orcid) }}"
                                                           placeholder="0000-0000-0000-0000">
                                                    @error('orcid')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="website">Website/Profile URL</label>
                                                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                                                           id="website" name="website" value="{{ old('website', $researcher->website) }}">
                                                    @error('website')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Profile Picture -->
                                <div class="card card-outline card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Profile Picture</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="form-group">
                                            @if($researcher->avatar)
                                                <img id="profile-preview" src="{{ $researcher->avatar }}"
                                                     alt="Current Profile" class="img-circle img-fluid mb-3" style="width: 150px; height: 150px;">
                                            @else
                                                <img id="profile-preview" src="https://via.placeholder.com/150x150/667eea/ffffff?text={{ substr($researcher->full_name ?? 'R', 0, 1) }}"
                                                     alt="Profile Preview" class="img-circle img-fluid mb-3" style="width: 150px; height: 150px;">
                                            @endif
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="profile_picture" name="profile_picture" accept="image/*">
                                                <label class="custom-file-label" for="profile_picture">Choose file</label>
                                            </div>
                                            <small class="form-text text-muted">Max size: 2MB. Supported: JPG, PNG, GIF</small>
                                            @error('profile_picture')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Settings -->
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Settings</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="active" {{ old('status', $researcher->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $researcher->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_public" name="is_public" value="1" {{ old('is_public', $researcher->is_public) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_public">Public Profile</label>
                                            </div>
                                            <small class="form-text text-muted">Allow profile to be visible to visitors</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save mr-1"></i>Update Researcher
                                </button>
                                <a href="{{ route('researchers.show', $researcher) }}" class="btn btn-secondary ml-2">
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
    $('#profile_picture').on('change', function() {
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

    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;

        // Check required fields
        $('input[required], select[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            toastr.error('Please fill in all required fields');
        }
    });

    // Real-time validation
    $('input, select, textarea').on('change', function() {
        if ($(this).attr('required') && !$(this).val()) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
});
</script>
@endpush