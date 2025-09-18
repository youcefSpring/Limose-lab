@extends('layouts.app', ['title' => __('Add New Researcher')])

@section('content')
<div id="researchers-create-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Add New Researcher') }}</h2>
            <p class="text-muted mb-0">{{ __('Create a new researcher profile') }}</p>
        </div>
        <a href="{{ route('researchers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Researchers') }}
        </a>
    </div>

    <!-- Researcher Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="researcherForm" method="POST" action="{{ route('researchers.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Personal Information -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('Personal Information') }}</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">{{ __('First Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                           id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="photo" class="form-label">{{ __('Profile Photo') }}</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                           id="photo" name="photo" accept="image/*">
                                    <div class="form-text">{{ __('Upload a profile photo (max 2MB, JPG/PNG only)') }}</div>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('Professional Information') }}</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="position" class="form-label">{{ __('Position/Title') }}</label>
                                    <input type="text" class="form-control @error('position') is-invalid @enderror"
                                           id="position" name="position" value="{{ old('position') }}"
                                           placeholder="{{ __('e.g., Senior Researcher, Professor') }}">
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label">{{ __('Department') }}</label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror"
                                           id="department" name="department" value="{{ old('department') }}">
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="research_domain" class="form-label">{{ __('Research Domain') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('research_domain') is-invalid @enderror"
                                           id="research_domain" name="research_domain" value="{{ old('research_domain') }}" required
                                           placeholder="{{ __('e.g., Artificial Intelligence, Biotechnology') }}">
                                    @error('research_domain')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="orcid" class="form-label">{{ __('ORCID ID') }}</label>
                                    <input type="text" class="form-control @error('orcid') is-invalid @enderror"
                                           id="orcid" name="orcid" value="{{ old('orcid') }}"
                                           placeholder="{{ __('e.g., 0000-0000-0000-0000') }}">
                                    @error('orcid')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="google_scholar_url" class="form-label">{{ __('Google Scholar URL') }}</label>
                                    <input type="url" class="form-control @error('google_scholar_url') is-invalid @enderror"
                                           id="google_scholar_url" name="google_scholar_url" value="{{ old('google_scholar_url') }}"
                                           placeholder="{{ __('https://scholar.google.com/citations?user=...') }}">
                                    @error('google_scholar_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Biography -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('Biography') }}</h5>

                            <div class="mb-3">
                                <ul class="nav nav-tabs" id="bioTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="bio-en-tab" data-bs-toggle="tab" data-bs-target="#bio-en" type="button" role="tab">
                                            <i class="fas fa-flag-usa me-1"></i>English
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="bio-fr-tab" data-bs-toggle="tab" data-bs-target="#bio-fr" type="button" role="tab">
                                            <i class="fas fa-flag me-1"></i>Français
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="bio-ar-tab" data-bs-toggle="tab" data-bs-target="#bio-ar" type="button" role="tab">
                                            <i class="fas fa-flag me-1"></i>العربية
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="bioTabContent">
                                    <div class="tab-pane fade show active" id="bio-en" role="tabpanel">
                                        <textarea class="form-control @error('bio_en') is-invalid @enderror"
                                                  name="bio_en" rows="4"
                                                  placeholder="{{ __('Enter biography in English...') }}">{{ old('bio_en') }}</textarea>
                                        @error('bio_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="bio-fr" role="tabpanel">
                                        <textarea class="form-control @error('bio_fr') is-invalid @enderror"
                                                  name="bio_fr" rows="4"
                                                  placeholder="{{ __('Enter biography in French...') }}">{{ old('bio_fr') }}</textarea>
                                        @error('bio_fr')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tab-pane fade" id="bio-ar" role="tabpanel">
                                        <textarea class="form-control @error('bio_ar') is-invalid @enderror"
                                                  name="bio_ar" rows="4" dir="rtl"
                                                  placeholder="{{ __('Enter biography in Arabic...') }}">{{ old('bio_ar') }}</textarea>
                                        @error('bio_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CV Upload -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('CV Upload') }}</h5>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="cv_file" class="form-label">{{ __('CV File') }}</label>
                                    <input type="file" class="form-control @error('cv_file') is-invalid @enderror"
                                           id="cv_file" name="cv_file" accept=".pdf,.doc,.docx">
                                    <div class="form-text">{{ __('Upload CV file (PDF, DOC, or DOCX - max 5MB)') }}</div>
                                    @error('cv_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Social/Academic Links -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('Social & Academic Links') }}</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="linkedin_url" class="form-label">{{ __('LinkedIn URL') }}</label>
                                    <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror"
                                           id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url') }}"
                                           placeholder="{{ __('https://linkedin.com/in/...') }}">
                                    @error('linkedin_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="researchgate_url" class="form-label">{{ __('ResearchGate URL') }}</label>
                                    <input type="url" class="form-control @error('researchgate_url') is-invalid @enderror"
                                           id="researchgate_url" name="researchgate_url" value="{{ old('researchgate_url') }}"
                                           placeholder="{{ __('https://researchgate.net/profile/...') }}">
                                    @error('researchgate_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="website_url" class="form-label">{{ __('Personal Website') }}</label>
                                    <input type="url" class="form-control @error('website_url') is-invalid @enderror"
                                           id="website_url" name="website_url" value="{{ old('website_url') }}"
                                           placeholder="{{ __('https://yourwebsite.com') }}">
                                    @error('website_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-2"></i>{{ __('Create Researcher Profile') }}
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
                        <i class="fas fa-info-circle me-2"></i>{{ __('Researcher Profile Guidelines') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('Personal Information') }}</h6>
                        <p class="small text-muted">{{ __('Provide accurate personal details. Email will be used for system notifications.') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('Research Domain') }}</h6>
                        <p class="small text-muted">{{ __('Specify your primary research areas and specializations for better categorization.') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('ORCID ID') }}</h6>
                        <p class="small text-muted">{{ __('Open Researcher and Contributor ID - a unique identifier for researchers.') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('Biography') }}</h6>
                        <p class="small text-muted">{{ __('Provide biography in multiple languages to reach a wider audience.') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('File Uploads') }}</h6>
                        <ul class="small text-muted">
                            <li>{{ __('Profile Photo: JPG/PNG, max 2MB') }}</li>
                            <li>{{ __('CV: PDF/DOC/DOCX, max 5MB') }}</li>
                        </ul>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>{{ __('Tip:') }}</strong>
                        {{ __('Complete profiles get better visibility in the researcher directory.') }}
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
    // Form submission handling
    $('#researcherForm').on('submit', function(e) {
        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();

        // Show loading state
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __("Creating...") }}');

        // Re-enable button after 5 seconds to prevent permanent disable on error
        setTimeout(function() {
            submitBtn.prop('disabled', false).html(originalText);
        }, 5000);
    });

    // Photo upload validation
    $('#photo').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Check file size (2MB = 2 * 1024 * 1024 bytes)
            if (file.size > 2 * 1024 * 1024) {
                showAlert('error', '{{ __("Photo size must be less than 2MB") }}');
                $(this).val('');
                return;
            }

            // Check file type
            if (!file.type.startsWith('image/')) {
                showAlert('error', '{{ __("Only image files are allowed") }}');
                $(this).val('');
                return;
            }
        }
    });

    // CV upload validation
    $('#cv_file').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Check file size (5MB = 5 * 1024 * 1024 bytes)
            if (file.size > 5 * 1024 * 1024) {
                showAlert('error', '{{ __("CV file size must be less than 5MB") }}');
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

    // ORCID format validation
    $('#orcid').on('blur', function() {
        const orcid = $(this).val();
        if (orcid && !orcid.match(/^\d{4}-\d{4}-\d{4}-\d{3}[\dX]$/)) {
            showAlert('warning', '{{ __("ORCID format should be like: 0000-0000-0000-0000") }}');
        }
    });

    // Email validation
    $('#email').on('blur', function() {
        const email = $(this).val();
        if (email) {
            // Basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showAlert('warning', '{{ __("Please enter a valid email address") }}');
            }
        }
    });

    // URL validation for all URL fields
    $('input[type="url"]').on('blur', function() {
        const url = $(this).val();
        const fieldName = $(this).attr('name');

        if (url) {
            try {
                new URL(url);
            } catch {
                showAlert('warning', '{{ __("Please enter a valid URL starting with http:// or https://") }}');
                $(this).focus();
            }
        }
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
        $('#researchers-create-container').prepend(alertHtml);

        // Auto-hide after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
@endpush