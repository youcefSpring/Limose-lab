@extends('layouts.adminlte')])

@section('content')
<div id="publications-show-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Publication Details') }}</h2>
            <p class="text-muted mb-0">{{ __('View publication information and metrics') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('publications.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Publications') }}
            </a>
            @can('update', $publication ?? null)
            <a href="{{ route('publications.edit', $publication->id ?? 1) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>{{ __('Edit') }}
            </a>
            @endcan
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Publication Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>{{ __('Publication Information') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h4 class="fw-bold text-primary">{{ $publication->title ?? 'Sample Publication Title' }}</h4>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('Type') }}</label>
                            <div>
                                <span class="badge bg-primary">{{ ucfirst($publication->type ?? 'article') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('Status') }}</label>
                            <div>
                                <span class="badge bg-success">{{ ucfirst($publication->status ?? 'published') }}</span>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">{{ __('Authors') }}</label>
                            <p class="mb-0">{{ $publication->authors ?? 'John Doe, Jane Smith, Bob Johnson' }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('Journal/Venue') }}</label>
                            <p class="mb-0">{{ $publication->journal ?? $publication->conference ?? $publication->publisher ?? 'Nature Communications' }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('Publication Year') }}</label>
                            <p class="mb-0">{{ $publication->publication_year ?? '2024' }}</p>
                        </div>

                        @if(($publication->volume ?? null) || ($publication->issue ?? null) || ($publication->pages ?? null))
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">{{ __('Volume/Issue/Pages') }}</label>
                            <p class="mb-0">
                                @if($publication->volume ?? null)Volume {{ $publication->volume }}@endif
                                @if($publication->issue ?? null)@if($publication->volume ?? null), @endif Issue {{ $publication->issue }}@endif
                                @if($publication->pages ?? null)@if(($publication->volume ?? null) || ($publication->issue ?? null)), @endif Pages {{ $publication->pages }}@endif
                            </p>
                        </div>
                        @endif

                        @if($publication->doi ?? null)
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">{{ __('DOI') }}</label>
                            <p class="mb-0">
                                <a href="https://doi.org/{{ $publication->doi }}" target="_blank" class="text-decoration-none">
                                    {{ $publication->doi }}
                                    <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            </p>
                        </div>
                        @endif

                        @if($publication->abstract ?? null)
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">{{ __('Abstract') }}</label>
                            <p class="mb-0">{{ $publication->abstract }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Keywords & Categories -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tags me-2"></i>{{ __('Keywords & Categories') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">{{ __('Keywords') }}</label>
                            <div>
                                @php
                                    $keywords = explode(',', $publication->keywords ?? 'machine learning, artificial intelligence, data science, research, technology');
                                @endphp
                                @foreach($keywords as $keyword)
                                    <span class="badge bg-secondary me-1 mb-1">{{ trim($keyword) }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('Research Domain') }}</label>
                            <p class="mb-0">{{ $publication->research_domain ?? 'Computer Science' }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('Subject Area') }}</label>
                            <p class="mb-0">{{ $publication->subject_area ?? 'Artificial Intelligence' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-link me-2"></i>{{ __('Related Information') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('Created By') }}</label>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <i class="fas fa-user-circle fa-2x text-muted"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $publication->creator->name ?? 'Dr. John Doe' }}</div>
                                    <small class="text-muted">{{ $publication->creator->email ?? 'john.doe@university.edu' }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('Related Project') }}</label>
                            <p class="mb-0">
                                @if($publication->project ?? null)
                                    <a href="{{ route('projects.show', $publication->project->id) }}" class="text-decoration-none">
                                        {{ $publication->project->title }}
                                    </a>
                                @else
                                    <span class="text-muted">{{ __('No related project') }}</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('Created Date') }}</label>
                            <p class="mb-0">{{ ($publication->created_at ?? now())->format('M d, Y') }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('Last Updated') }}</label>
                            <p class="mb-0">{{ ($publication->updated_at ?? now())->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Metrics -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>{{ __('Publication Metrics') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="h4 fw-bold text-primary">{{ $publication->citations_count ?? '25' }}</div>
                            <div class="small text-muted">{{ __('Citations') }}</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h4 fw-bold text-success">{{ $publication->downloads_count ?? '150' }}</div>
                            <div class="small text-muted">{{ __('Downloads') }}</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h4 fw-bold text-info">{{ $publication->views_count ?? '450' }}</div>
                            <div class="small text-muted">{{ __('Views') }}</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h4 fw-bold text-warning">{{ $publication->impact_factor ?? '3.2' }}</div>
                            <div class="small text-muted">{{ __('Impact Factor') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Files & Downloads -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-download me-2"></i>{{ __('Files & Downloads') }}
                    </h6>
                </div>
                <div class="card-body">
                    @if($publication->pdf_path ?? null)
                    <div class="d-grid gap-2">
                        <a href="{{ $publication->pdf_path }}" target="_blank" class="btn btn-outline-danger">
                            <i class="fas fa-file-pdf me-2"></i>{{ __('Download PDF') }}
                        </a>
                    </div>
                    @else
                    <p class="text-muted text-center">{{ __('No files available') }}</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>{{ __('Quick Actions') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($publication->doi ?? null)
                        <a href="https://doi.org/{{ $publication->doi }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-2"></i>{{ __('View DOI') }}
                        </a>
                        @endif

                        <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard()">
                            <i class="fas fa-copy me-2"></i>{{ __('Copy Citation') }}
                        </button>

                        <button class="btn btn-outline-info btn-sm" onclick="exportBibTeX()">
                            <i class="fas fa-file-export me-2"></i>{{ __('Export BibTeX') }}
                        </button>

                        @can('delete', $publication ?? null)
                        <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>{{ __('Delete') }}
                        </button>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Citation Format -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-quote-right me-2"></i>{{ __('Citation') }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <strong>APA Format:</strong>
                        <div id="citationText" class="mt-2 p-2 bg-light rounded">
                            {{ ($publication->authors ?? 'Doe, J., Smith, J.') }} ({{ $publication->publication_year ?? '2024' }}).
                            {{ $publication->title ?? 'Sample Publication Title' }}.
                            <em>{{ $publication->journal ?? $publication->conference ?? 'Journal Name' }}</em>@if($publication->volume ?? null), {{ $publication->volume }}@endif@if($publication->issue ?? null)({{ $publication->issue }})@endif@if($publication->pages ?? null), {{ $publication->pages }}@endif.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Confirm Delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure you want to delete this publication? This action cannot be undone.') }}</p>
                <div class="fw-bold text-primary">{{ $publication->title ?? 'Sample Publication' }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form method="POST" action="{{ route('publications.destroy', $publication->id ?? 1) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>{{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard() {
    const citationText = document.getElementById('citationText').innerText;
    navigator.clipboard.writeText(citationText).then(function() {
        showAlert('success', '{{ __("Citation copied to clipboard") }}');
    });
}

function exportBibTeX() {
    // Sample BibTeX format
    const bibtex = `@article{sample2024,
    title={Sample Publication Title},
    author={Doe, John and Smith, Jane},
    journal={Journal Name},
    year={2024},
    publisher={Publisher}
}`;

    const blob = new Blob([bibtex], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'citation.bib';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);

    showAlert('success', '{{ __("BibTeX exported successfully") }}');
}

function confirmDelete() {
    $('#deleteModal').modal('show');
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    // Remove existing alerts
    $('.alert').remove();

    // Add new alert at the top of the container
    $('#publications-show-container').prepend(alertHtml);

    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}
</script>
@endpush