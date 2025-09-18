@extends('layouts.app', ['title' => __('Add New Project')])

@section('content')
<div id="projects-create-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Add New Project') }}</h2>
            <p class="text-muted mb-0">{{ __('Create a new research project') }}</p>
        </div>
        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Projects') }}
        </a>
    </div>

    <!-- Project Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="projectForm" method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('Basic Information') }}</h5>

                            <!-- Title in Multiple Languages -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('Project Title') }} <span class="text-danger">*</span></label>
                                <ul class="nav nav-tabs" id="titleTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="title-en-tab" data-bs-toggle="tab" data-bs-target="#title-en" type="button" role="tab">
                                            <i class="fas fa-flag-usa me-1"></i>English
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="title-fr-tab" data-bs-toggle="tab" data-bs-target="#title-fr" type="button" role="tab">
                                            <i class="fas fa-flag me-1"></i>Français
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="title-ar-tab" data-bs-toggle="tab" data-bs-target="#title-ar" type="button" role="tab">
                                            <i class="fas fa-flag me-1"></i>العربية
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="titleTabContent">
                                    <div class="tab-pane fade show active" id="title-en" role="tabpanel">
                                        <input type="text" class="form-control @error('title_en') is-invalid @enderror"
                                               name="title_en" value="{{ old('title_en') }}" required
                                               placeholder="{{ __('Enter project title in English...') }}">
                                        @error('title_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="title-fr" role="tabpanel">
                                        <input type="text" class="form-control @error('title_fr') is-invalid @enderror"
                                               name="title_fr" value="{{ old('title_fr') }}"
                                               placeholder="{{ __('Enter project title in French...') }}">
                                        @error('title_fr')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="title-ar" role="tabpanel">
                                        <input type="text" class="form-control @error('title_ar') is-invalid @enderror"
                                               name="title_ar" value="{{ old('title_ar') }}" dir="rtl"
                                               placeholder="{{ __('Enter project title in Arabic...') }}">
                                        @error('title_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Project Leader -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="leader_id" class="form-label">{{ __('Project Leader') }} <span class="text-danger">*</span></label>
                                    <select class="form-select @error('leader_id') is-invalid @enderror" id="leader_id" name="leader_id" required>
                                        <option value="">{{ __('Select Project Leader') }}</option>
                                        @foreach($researchers as $researcher)
                                            <option value="{{ $researcher->id }}" {{ old('leader_id') == $researcher->id ? 'selected' : '' }}>
                                                {{ $researcher->full_name }} ({{ $researcher->research_domain }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('leader_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">{{ __('Project Status') }} <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">{{ __('Select Status') }}</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Project Description -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('Project Description') }}</h5>

                            <div class="mb-3">
                                <ul class="nav nav-tabs" id="descriptionTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="desc-en-tab" data-bs-toggle="tab" data-bs-target="#desc-en" type="button" role="tab">
                                            <i class="fas fa-flag-usa me-1"></i>English
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="desc-fr-tab" data-bs-toggle="tab" data-bs-target="#desc-fr" type="button" role="tab">
                                            <i class="fas fa-flag me-1"></i>Français
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="desc-ar-tab" data-bs-toggle="tab" data-bs-target="#desc-ar" type="button" role="tab">
                                            <i class="fas fa-flag me-1"></i>العربية
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="descriptionTabContent">
                                    <div class="tab-pane fade show active" id="desc-en" role="tabpanel">
                                        <textarea class="form-control @error('description_en') is-invalid @enderror"
                                                  name="description_en" rows="5" required
                                                  placeholder="{{ __('Enter project description in English...') }}">{{ old('description_en') }}</textarea>
                                        @error('description_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="desc-fr" role="tabpanel">
                                        <textarea class="form-control @error('description_fr') is-invalid @enderror"
                                                  name="description_fr" rows="5"
                                                  placeholder="{{ __('Enter project description in French...') }}">{{ old('description_fr') }}</textarea>
                                        @error('description_fr')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="desc-ar" role="tabpanel">
                                        <textarea class="form-control @error('description_ar') is-invalid @enderror"
                                                  name="description_ar" rows="5" dir="rtl"
                                                  placeholder="{{ __('Enter project description in Arabic...') }}">{{ old('description_ar') }}</textarea>
                                        @error('description_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline & Budget -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('Timeline & Budget') }}</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                           id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">{{ __('End Date') }} <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                           id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="budget" class="form-label">{{ __('Project Budget') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control @error('budget') is-invalid @enderror"
                                               id="budget" name="budget" value="{{ old('budget') }}"
                                               step="0.01" min="0" placeholder="{{ __('0.00') }}">
                                        <span class="input-group-text">USD</span>
                                    </div>
                                    @error('budget')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Team Members -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('Team Members') }}</h5>

                            <div class="mb-3">
                                <label for="members" class="form-label">{{ __('Project Members') }}</label>
                                <select class="form-select @error('members') is-invalid @enderror" id="members" name="members[]" multiple>
                                    @foreach($researchers as $researcher)
                                        <option value="{{ $researcher->id }}" {{ in_array($researcher->id, old('members', [])) ? 'selected' : '' }}>
                                            {{ $researcher->full_name }} ({{ $researcher->research_domain }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">{{ __('Select team members for this project (excluding the leader)') }}</div>
                                @error('members')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Objectives -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('Project Objectives') }}</h5>

                            <div class="mb-3">
                                <label for="objectives" class="form-label">{{ __('Main Objectives') }}</label>
                                <textarea class="form-control @error('objectives') is-invalid @enderror"
                                          id="objectives" name="objectives" rows="4"
                                          placeholder="{{ __('List the main objectives of this project...') }}">{{ old('objectives') }}</textarea>
                                @error('objectives')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- File Attachments -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('File Attachments') }}</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="proposal_file" class="form-label">{{ __('Project Proposal') }}</label>
                                    <input type="file" class="form-control @error('proposal_file') is-invalid @enderror"
                                           id="proposal_file" name="proposal_file" accept=".pdf,.doc,.docx">
                                    <div class="form-text">{{ __('Upload project proposal document (PDF, DOC, DOCX - max 10MB)') }}</div>
                                    @error('proposal_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="document_files" class="form-label">{{ __('Additional Documents') }}</label>
                                    <input type="file" class="form-control @error('document_files') is-invalid @enderror"
                                           id="document_files" name="document_files[]" multiple
                                           accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                                    <div class="form-text">{{ __('Upload additional project documents (max 5MB each)') }}</div>
                                    @error('document_files')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-2"></i>{{ __('Create Project') }}
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                <i class="fas fa-times me-2"></i>{{ __('Cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Help Panel -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>{{ __('Project Creation Guidelines') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('Project Title') }}</h6>
                        <p class="small text-muted">{{ __('Provide a clear and descriptive title. Multiple languages help with international collaboration.') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('Project Leader') }}</h6>
                        <p class="small text-muted">{{ __('The project leader is responsible for project management and coordination.') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('Timeline') }}</h6>
                        <p class="small text-muted">{{ __('Set realistic start and end dates. These can be adjusted later if needed.') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('Team Members') }}</h6>
                        <p class="small text-muted">{{ __('Add team members who will contribute to the project. The leader is automatically included.') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('File Uploads') }}</h6>
                        <ul class="small text-muted">
                            <li>{{ __('Proposal: PDF/DOC/DOCX, max 10MB') }}</li>
                            <li>{{ __('Documents: Multiple files, max 5MB each') }}</li>
                        </ul>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>{{ __('Tip:') }}</strong>
                        {{ __('Complete project information helps with better collaboration and tracking.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="d-none">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">{{ __('Loading...') }}</span>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Select2 for multi-select
    $('#members').select2({
        placeholder: '{{ __("Select team members...") }}',
        allowClear: true,
        width: '100%'
    });

    // Initialize Select2 for leader selection
    $('#leader_id').select2({
        placeholder: '{{ __("Select project leader...") }}',
        allowClear: true,
        width: '100%'
    });

    // Form submission handling
    $('#projectForm').on('submit', function(e) {
        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();

        // Show loading state
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __("Creating...") }}');

        // Re-enable button after 5 seconds to prevent permanent disable on error
        setTimeout(function() {
            submitBtn.prop('disabled', false).html(originalText);
        }, 5000);
    });

    // Date validation
    $('#start_date, #end_date').on('change', function() {
        const startDate = new Date($('#start_date').val());
        const endDate = new Date($('#end_date').val());

        if (startDate && endDate && startDate >= endDate) {
            showAlert('warning', '{{ __("End date must be after start date") }}');
            $('#end_date').focus();
        }
    });

    // Budget validation
    $('#budget').on('input', function() {
        const budget = parseFloat($(this).val());
        if (budget < 0) {
            showAlert('warning', '{{ __("Budget cannot be negative") }}');
            $(this).val(0);
        }
    });

    // File upload validation
    $('#proposal_file').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Check file size (10MB = 10 * 1024 * 1024 bytes)
            if (file.size > 10 * 1024 * 1024) {
                showAlert('error', '{{ __("Proposal file size must be less than 10MB") }}');
                $(this).val('');
                return;
            }

            // Check file type
            const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            if (!allowedTypes.includes(file.type)) {
                showAlert('error', '{{ __("Only PDF, DOC, or DOCX files are allowed") }}');
                $(this).val('');
                return;
            }
        }
    });

    $('#document_files').on('change', function() {
        const files = this.files;
        const maxSize = 5 * 1024 * 1024; // 5MB

        Array.from(files).forEach(function(file) {
            if (file.size > maxSize) {
                showAlert('error', '{{ __("Each document file must be less than 5MB") }}');
                $('#document_files').val('');
                return false;
            }
        });
    });

    // Remove leader from members list when leader is selected
    $('#leader_id').on('change', function() {
        const leaderId = $(this).val();
        const membersSelect = $('#members');

        if (leaderId) {
            // Remove leader from members selection
            membersSelect.find(`option[value="${leaderId}"]`).prop('disabled', true);

            // Remove leader if already selected as member
            const currentMembers = membersSelect.val() || [];
            const updatedMembers = currentMembers.filter(id => id !== leaderId);
            membersSelect.val(updatedMembers).trigger('change');
        } else {
            // Re-enable all options if no leader selected
            membersSelect.find('option').prop('disabled', false);
        }

        membersSelect.select2('destroy').select2({
            placeholder: '{{ __("Select team members...") }}',
            allowClear: true,
            width: '100%'
        });
    });

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' :
                          type === 'warning' ? 'alert-warning' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        // Remove existing alerts
        $('.alert').remove();

        // Add new alert at the top of the container
        $('#projects-create-container').prepend(alertHtml);

        // Auto-hide after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
@endpush