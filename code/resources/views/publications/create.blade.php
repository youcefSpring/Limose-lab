@extends('layouts.adminlte')

@section('title', 'Add Publication')
@section('page-title', 'Add New Publication')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('publications.index') }}">Publications</a></li>
<li class="breadcrumb-item active">Add Publication</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Main Card -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-book-open mr-1"></i>
                        Create New Publication
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('publications.index') }}" class="btn btn-tool" title="Back to Publications">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('publications.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Basic Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="title">Publication Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                   id="title" name="title" value="{{ old('title') }}" required
                                                   placeholder="Enter publication title">
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="type">Publication Type <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('type') is-invalid @enderror"
                                                            id="type" name="type" required>
                                                        <option value="">Select Type</option>
                                                        <option value="article" {{ old('type') == 'article' ? 'selected' : '' }}>Journal Article</option>
                                                        <option value="conference" {{ old('type') == 'conference' ? 'selected' : '' }}>Conference Paper</option>
                                                        <option value="patent" {{ old('type') == 'patent' ? 'selected' : '' }}>Patent</option>
                                                        <option value="book" {{ old('type') == 'book' ? 'selected' : '' }}>Book</option>
                                                        <option value="poster" {{ old('type') == 'poster' ? 'selected' : '' }}>Poster</option>
                                                    </select>
                                                    @error('type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status">Status <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('status') is-invalid @enderror"
                                                            id="status" name="status" required>
                                                        <option value="">Select Status</option>
                                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                        <option value="submitted" {{ old('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                                        <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                                                        <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                                    </select>
                                                    @error('status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="authors">Authors <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('authors') is-invalid @enderror"
                                                      id="authors" name="authors" rows="3" required
                                                      placeholder="Enter authors separated by commas">{{ old('authors') }}</textarea>
                                            @error('authors')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Publication Details -->
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Publication Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="journal">Journal/Venue</label>
                                                    <input type="text" class="form-control @error('journal') is-invalid @enderror"
                                                           id="journal" name="journal" value="{{ old('journal') }}"
                                                           placeholder="Journal or venue name">
                                                    @error('journal')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="publication_year">Publication Year <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control @error('publication_year') is-invalid @enderror"
                                                           id="publication_year" name="publication_year" value="{{ old('publication_year', date('Y')) }}"
                                                           min="1900" max="{{ date('Y') + 5 }}" required>
                                                    @error('publication_year')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="volume">Volume</label>
                                                    <input type="text" class="form-control @error('volume') is-invalid @enderror"
                                                           id="volume" name="volume" value="{{ old('volume') }}">
                                                    @error('volume')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="issue">Issue</label>
                                                    <input type="text" class="form-control @error('issue') is-invalid @enderror"
                                                           id="issue" name="issue" value="{{ old('issue') }}">
                                                    @error('issue')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pages">Pages</label>
                                                    <input type="text" class="form-control @error('pages') is-invalid @enderror"
                                                           id="pages" name="pages" value="{{ old('pages') }}"
                                                           placeholder="e.g., 123-145">
                                                    @error('pages')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="doi">DOI</label>
                                                    <input type="text" class="form-control @error('doi') is-invalid @enderror"
                                                           id="doi" name="doi" value="{{ old('doi') }}"
                                                           placeholder="e.g., 10.1000/182">
                                                    @error('doi')
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
                                <!-- Additional Details -->
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Additional Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="publisher">Publisher</label>
                                            <input type="text" class="form-control @error('publisher') is-invalid @enderror"
                                                   id="publisher" name="publisher" value="{{ old('publisher') }}">
                                            @error('publisher')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="conference">Conference</label>
                                            <input type="text" class="form-control @error('conference') is-invalid @enderror"
                                                   id="conference" name="conference" value="{{ old('conference') }}">
                                            @error('conference')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- File Upload -->
                                <div class="card card-outline card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">File Upload</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="pdf_file">PDF File</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('pdf_file') is-invalid @enderror"
                                                       id="pdf_file" name="pdf_file" accept=".pdf">
                                                <label class="custom-file-label" for="pdf_file">Choose file</label>
                                            </div>
                                            <small class="form-text text-muted">Upload PDF file (max 10MB)</small>
                                            @error('pdf_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i>Create Publication
                                </button>
                                <a href="{{ route('publications.index') }}" class="btn btn-secondary ml-2">
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
    // Update file input label
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    // Dynamic form behavior based on publication type
    $('#type').on('change', function() {
        const type = $(this).val();
        const journalField = $('#journal').closest('.form-group');
        const conferenceField = $('#conference').closest('.form-group');
        const publisherField = $('#publisher').closest('.form-group');

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
                toastr.error('File size must be less than 10MB');
                $(this).val('');
                return;
            }

            // Check file type
            if (file.type !== 'application/pdf') {
                toastr.error('Only PDF files are allowed');
                $(this).val('');
                return;
            }
        }
    });

    // DOI format validation
    $('#doi').on('blur', function() {
        const doi = $(this).val();
        if (doi && !doi.match(/^10\.\d+\/.+/)) {
            toastr.warning('DOI format should be like: 10.1000/182');
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;

        // Check required fields
        $('input[required], select[required], textarea[required]').each(function() {
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
});
</script>
@endpush