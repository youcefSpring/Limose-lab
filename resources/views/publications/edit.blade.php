@extends('layouts.app', ['title' => __('Edit Publication')])

@section('content')
<div id="publications-edit-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Edit Publication') }}</h2>
            <p class="text-muted mb-0">{{ __('Update publication information') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('publications.show', $publication) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-2"></i>{{ __('View Publication') }}
            </a>
            <a href="{{ route('publications.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Publications') }}
            </a>
        </div>
    </div>

    <!-- Publication Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="publicationForm" method="POST" action="{{ route('publications.update', $publication) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('Basic Information') }}</h5>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="title" class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ old('title', $publication->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="type" class="form-label">{{ __('Publication Type') }} <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">{{ __('Select Type') }}</option>
                                        <option value="article" {{ old('type', $publication->type) == 'article' ? 'selected' : '' }}>{{ __('Journal Article') }}</option>
                                        <option value="conference" {{ old('type', $publication->type) == 'conference' ? 'selected' : '' }}>{{ __('Conference Paper') }}</option>
                                        <option value="patent" {{ old('type', $publication->type) == 'patent' ? 'selected' : '' }}>{{ __('Patent') }}</option>
                                        <option value="book" {{ old('type', $publication->type) == 'book' ? 'selected' : '' }}>{{ __('Book') }}</option>
                                        <option value="poster" {{ old('type', $publication->type) == 'poster' ? 'selected' : '' }}>{{ __('Poster') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">{{ __('Select Status') }}</option>
                                        <option value="draft" {{ old('status', $publication->status) == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                        <option value="submitted" {{ old('status', $publication->status) == 'submitted' ? 'selected' : '' }}>{{ __('Submitted') }}</option>
                                        <option value="published" {{ old('status', $publication->status) == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                                        <option value="archived" {{ old('status', $publication->status) == 'archived' ? 'selected' : '' }}>{{ __('Archived') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="authors" class="form-label">{{ __('Authors') }} <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('authors') is-invalid @enderror"
                                              id="authors" name="authors" rows="3" required
                                              placeholder="{{ __('Enter authors separated by commas') }}">{{ old('authors', $publication->authors) }}</textarea>
                                    @error('authors')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Publication Details -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('Publication Details') }}</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="journal" class="form-label">{{ __('Journal/Venue') }}</label>
                                    <input type="text" class="form-control @error('journal') is-invalid @enderror"
                                           id="journal" name="journal" value="{{ old('journal', $publication->journal) }}">
                                    @error('journal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="conference" class="form-label">{{ __('Conference') }}</label>
                                    <input type="text" class="form-control @error('conference') is-invalid @enderror"
                                           id="conference" name="conference" value="{{ old('conference', $publication->conference) }}">
                                    @error('conference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="publisher" class="form-label">{{ __('Publisher') }}</label>
                                    <input type="text" class="form-control @error('publisher') is-invalid @enderror"
                                           id="publisher" name="publisher" value="{{ old('publisher', $publication->publisher) }}">
                                    @error('publisher')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="publication_year" class="form-label">{{ __('Publication Year') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('publication_year') is-invalid @enderror"
                                           id="publication_year" name="publication_year" value="{{ old('publication_year', $publication->publication_year) }}"
                                           min="1900" max="{{ date('Y') + 5 }}" required>
                                    @error('publication_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="volume" class="form-label">{{ __('Volume') }}</label>
                                    <input type="text" class="form-control @error('volume') is-invalid @enderror"
                                           id="volume" name="volume" value="{{ old('volume', $publication->volume) }}">
                                    @error('volume')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="issue" class="form-label">{{ __('Issue') }}</label>
                                    <input type="text" class="form-control @error('issue') is-invalid @enderror"
                                           id="issue" name="issue" value="{{ old('issue', $publication->issue) }}">
                                    @error('issue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="pages" class="form-label">{{ __('Pages') }}</label>
                                    <input type="text" class="form-control @error('pages') is-invalid @enderror"
                                           id="pages" name="pages" value="{{ old('pages', $publication->pages) }}"
                                           placeholder="{{ __('e.g., 123-145') }}">
                                    @error('pages')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="doi" class="form-label">{{ __('DOI') }}</label>
                                    <input type="text" class="form-control @error('doi') is-invalid @enderror"
                                           id="doi" name="doi" value="{{ old('doi', $publication->doi) }}"
                                           placeholder="{{ __('e.g., 10.1000/182') }}">
                                    @error('doi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-4">
                            <h5 class="card-title mb-3">{{ __('File Upload') }}</h5>

                            @if($publication->pdf_path)
                                <div class="mb-3">
                                    <div class="alert alert-info">
                                        <i class="fas fa-file-pdf me-2"></i>
                                        {{ __('Current PDF:') }}
                                        <a href="{{ asset('storage/' . $publication->pdf_path) }}" target="_blank" class="text-decoration-none">
                                            {{ __('View Current PDF') }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="pdf_file" class="form-label">{{ __('PDF File') }}</label>
                                    <input type="file" class="form-control @error('pdf_file') is-invalid @enderror"
                                           id="pdf_file" name="pdf_file" accept=".pdf">
                                    <div class="form-text">{{ __('Upload a new PDF file to replace the current one (max 10MB)') }}</div>
                                    @error('pdf_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-2"></i>{{ __('Update Publication') }}
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                <i class="fas fa-times me-2"></i>{{ __('Cancel') }}
                            </button>
                            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                                <button type="button" class="btn btn-outline-danger ms-auto" id="deleteBtn" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-2"></i>{{ __('Delete Publication') }}
                                </button>
                            @endif
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
                        <i class="fas fa-info-circle me-2"></i>{{ __('Publication Guidelines') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('Title') }}</h6>
                        <p class="small text-muted">{{ __('Enter the complete title of the publication as it appears in the original source.') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('Authors') }}</h6>
                        <p class="small text-muted">{{ __('List all authors in the order they appear in the publication, separated by commas.') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('DOI') }}</h6>
                        <p class="small text-muted">{{ __('Digital Object Identifier - a unique alphanumeric string assigned to identify academic papers.') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">{{ __('Publication Types') }}</h6>
                        <ul class="small text-muted">
                            <li>{{ __('Journal Article: Peer-reviewed research papers') }}</li>
                            <li>{{ __('Conference: Conference proceedings and presentations') }}</li>
                            <li>{{ __('Patent: Intellectual property documents') }}</li>
                            <li>{{ __('Book: Complete books or book chapters') }}</li>
                            <li>{{ __('Poster: Research posters and abstracts') }}</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>{{ __('Note:') }}</strong>
                        {{ __('Changes will be saved immediately when you click Update Publication.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
@if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ __('Delete Publication') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure you want to delete this publication?') }}</p>
                <p class="text-muted small">{{ __('This action cannot be undone. All associated data will be permanently removed.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form method="POST" action="{{ route('publications.destroy', $publication) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Delete Publication') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

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
    $('#publicationForm').on('submit', function(e) {
        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();

        // Show loading state
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __("Updating...") }}');

        // Re-enable button after 5 seconds to prevent permanent disable on error
        setTimeout(function() {
            submitBtn.prop('disabled', false).html(originalText);
        }, 5000);
    });

    // Dynamic form behavior based on publication type
    $('#type').on('change', function() {
        const type = $(this).val();
        const journalField = $('#journal').closest('.col-md-6');
        const conferenceField = $('#conference').closest('.col-md-6');
        const publisherField = $('#publisher').closest('.col-md-6');

        // Reset all fields
        journalField.show();
        conferenceField.show();
        publisherField.show();

        // Show/hide relevant fields based on type
        switch(type) {
            case 'article':
                conferenceField.hide();
                break;
            case 'conference':
                journalField.hide();
                publisherField.hide();
                break;
            case 'book':
                journalField.hide();
                conferenceField.hide();
                break;
            case 'patent':
                journalField.hide();
                conferenceField.hide();
                break;
        }
    });

    // Trigger initial form setup
    $('#type').trigger('change');

    // File upload validation
    $('#pdf_file').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Check file size (10MB = 10 * 1024 * 1024 bytes)
            if (file.size > 10 * 1024 * 1024) {
                showAlert('error', '{{ __("File size must be less than 10MB") }}');
                $(this).val('');
                return;
            }

            // Check file type
            if (file.type !== 'application/pdf') {
                showAlert('error', '{{ __("Only PDF files are allowed") }}');
                $(this).val('');
                return;
            }
        }
    });

    // DOI format validation
    $('#doi').on('blur', function() {
        const doi = $(this).val();
        if (doi && !doi.match(/^10\.\d+\/.+/)) {
            showAlert('warning', '{{ __("DOI format should be like: 10.1000/182") }}');
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
        $('#publications-edit-container').prepend(alertHtml);

        // Auto-hide after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
@endpush