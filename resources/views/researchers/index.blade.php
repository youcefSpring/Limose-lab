@extends('layouts.app', ['title' => __('Researchers Management')])

@section('content')
<div id="researchers-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Researchers') }}</h2>
            <p class="text-muted mb-0">{{ __('Manage and browse research team members') }}</p>
        </div>
        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                <a href="{{ route('researchers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('Add Researcher') }}
                </a>
            @endif
        @endauth
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="searchFilter" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchFilter" placeholder="{{ __('Search researchers...') }}">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="domainFilter" class="form-label">{{ __('Research Domain') }}</label>
                    <select class="form-select" id="domainFilter">
                        <option value="">{{ __('All Domains') }}</option>
                        <!-- Options will be loaded dynamically -->
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="active">{{ __('Active') }}</option>
                        <option value="inactive">{{ __('Inactive') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary" id="clearFilters" title="{{ __('Clear Filters') }}">
                            <i class="fas fa-filter"></i>
                        </button>
                        <button class="btn btn-outline-success" id="exportResearchers" title="{{ __('Export') }}">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Researchers Grid -->
    <div id="researchersGrid" class="row g-4">
        <!-- Researchers will be loaded here -->
    </div>

    <!-- Loading State -->
    <div id="loadingState" class="text-center py-5 d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">{{ __('Loading...') }}</span>
        </div>
        <div class="mt-3">{{ __('Loading researchers...') }}</div>
    </div>

    <!-- No Results -->
    <div id="noResults" class="text-center py-5 d-none">
        <i class="fas fa-user-friends text-muted" style="font-size: 4rem;"></i>
        <h4 class="text-muted mt-3">{{ __('No researchers found') }}</h4>
        <p class="text-muted">{{ __('Try adjusting your search criteria or clear filters') }}</p>
        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                <a href="{{ route('researchers.create') }}" class="btn btn-primary mt-3">
                    {{ __('Add First Researcher') }}
                </a>
            @endif
        @endauth
    </div>

    <!-- Pagination -->
    <nav id="paginationContainer" class="mt-4 d-none">
        <ul class="pagination justify-content-center">
            <!-- Pagination will be generated here -->
        </ul>
    </nav>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let researchers = [];
    let pagination = {
        current_page: 1,
        total_pages: 1,
        total_items: 0,
        per_page: 12
    };
    let searchTimeout;

    // Initialize the page
    initializePage();

    // Filter change handlers
    $('#searchFilter').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            pagination.current_page = 1;
            loadResearchers();
        }, 500);
    });

    $('#clearSearch').on('click', function() {
        $('#searchFilter').val('');
        pagination.current_page = 1;
        loadResearchers();
    });

    $('#domainFilter, #statusFilter').on('change', function() {
        pagination.current_page = 1;
        loadResearchers();
    });

    $('#clearFilters').on('click', function() {
        $('#searchFilter').val('');
        $('#domainFilter').val('');
        $('#statusFilter').val('');
        pagination.current_page = 1;
        loadResearchers();
    });

    $('#exportResearchers').on('click', function() {
        exportResearchers();
    });

    function initializePage() {
        loadResearchDomains();
        loadResearchers();
    }

    function loadResearchers() {
        showLoading();

        const filters = {
            search: $('#searchFilter').val(),
            research_domain: $('#domainFilter').val(),
            status: $('#statusFilter').val(),
            page: pagination.current_page,
            per_page: pagination.per_page
        };

        // Remove empty filters
        Object.keys(filters).forEach(key => {
            if (!filters[key]) {
                delete filters[key];
            }
        });

        $.ajax({
            url: '/api/v1/researchers',
            method: 'GET',
            data: filters,
            success: function(response) {
                if (response.success && response.data) {
                    researchers = response.data.researchers || [];
                    pagination = response.data.pagination || pagination;
                    renderResearchers();
                    renderPagination();
                } else {
                    showError('{{ __("Failed to load researchers") }}');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading researchers:', error);
                showError('{{ __("Failed to load researchers") }}');
            },
            complete: function() {
                hideLoading();
            }
        });
    }

    function loadResearchDomains() {
        $.ajax({
            url: '/api/v1/researchers/domains',
            method: 'GET',
            success: function(response) {
                if (response.success && response.data && response.data.domains) {
                    const domainFilter = $('#domainFilter');
                    response.data.domains.forEach(function(domain) {
                        domainFilter.append(`<option value="${domain.name}">${domain.name}</option>`);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading research domains:', error);
            }
        });
    }

    function renderResearchers() {
        const grid = $('#researchersGrid');
        const noResults = $('#noResults');

        if (researchers.length === 0) {
            grid.addClass('d-none');
            noResults.removeClass('d-none');
            return;
        }

        grid.removeClass('d-none');
        noResults.addClass('d-none');

        let html = '';
        researchers.forEach(function(researcher) {
            html += createResearcherCard(researcher);
        });

        grid.html(html);
    }

    function createResearcherCard(researcher) {
        const photoUrl = researcher.photo_url || '/images/default-avatar.png';
        const bio = researcher.bio || '{{ __("No biography available") }}';
        const truncatedBio = bio.length > 120 ? bio.substring(0, 120) + '...' : bio;

        let externalLinks = '';
        if (researcher.orcid_id || researcher.google_scholar_url) {
            externalLinks = '<div class="mt-2">';
            if (researcher.orcid_id) {
                externalLinks += `<a href="https://orcid.org/${researcher.orcid_id}" target="_blank" class="btn btn-sm btn-outline-success me-1">ORCID</a>`;
            }
            if (researcher.google_scholar_url) {
                externalLinks += `<a href="${researcher.google_scholar_url}" target="_blank" class="btn btn-sm btn-outline-primary">Scholar</a>`;
            }
            externalLinks += '</div>';
        }

        let actions = `<a href="/researchers/${researcher.id}" class="btn btn-sm btn-primary">{{ __('View Profile') }}</a>`;

        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager() || (auth()->user()->researcher && auth()->user()->researcher->id))
            if ({{ auth()->user()->isAdmin() ? 'true' : 'false' }} ||
                {{ auth()->user()->isLabManager() ? 'true' : 'false' }} ||
                ({{ auth()->user()->researcher ? auth()->user()->researcher->id : 'null' }} === researcher.id)) {
                actions += `<a href="/researchers/${researcher.id}/edit" class="btn btn-sm btn-outline-secondary ms-1"><i class="fas fa-edit"></i></a>`;
            }
            @endif
        @endauth

        return `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 researcher-card shadow-sm">
                    <div class="card-body text-center">
                        <!-- Photo -->
                        <div class="mb-3">
                            <img src="${photoUrl}" alt="${researcher.full_name}"
                                 class="rounded-circle" width="80" height="80"
                                 style="object-fit: cover;">
                        </div>

                        <!-- Name and Title -->
                        <h6 class="card-title fw-bold mb-1">${researcher.full_name}</h6>
                        <p class="text-muted small mb-2">${researcher.title || ''}</p>

                        <!-- Research Domain -->
                        <span class="badge bg-primary-subtle text-primary mb-2">${researcher.research_domain || ''}</span>

                        <!-- Bio -->
                        <p class="text-muted small mb-3" style="height: 60px; overflow: hidden;">${truncatedBio}</p>

                        <!-- Statistics -->
                        <div class="row text-center mb-3">
                            <div class="col-6">
                                <div class="fw-bold text-primary">${researcher.projects_count || 0}</div>
                                <small class="text-muted">{{ __('Projects') }}</small>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold text-success">${researcher.publications_count || 0}</div>
                                <small class="text-muted">{{ __('Publications') }}</small>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mb-2">
                            ${actions}
                        </div>

                        <!-- External Links -->
                        ${externalLinks}
                    </div>
                </div>
            </div>
        `;
    }

    function renderPagination() {
        const container = $('#paginationContainer');
        const paginationList = container.find('.pagination');

        if (pagination.total_pages <= 1) {
            container.addClass('d-none');
            return;
        }

        container.removeClass('d-none');
        let html = '';

        // Previous button
        if (pagination.current_page > 1) {
            html += `<li class="page-item"><a class="page-link" href="#" data-page="${pagination.current_page - 1}">{{ __('Previous') }}</a></li>`;
        } else {
            html += `<li class="page-item disabled"><span class="page-link">{{ __('Previous') }}</span></li>`;
        }

        // Page numbers
        const startPage = Math.max(1, pagination.current_page - 3);
        const endPage = Math.min(pagination.total_pages, pagination.current_page + 3);

        if (startPage > 1) {
            html += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
            if (startPage > 2) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            if (i === pagination.current_page) {
                html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
            } else {
                html += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            }
        }

        if (endPage < pagination.total_pages) {
            if (endPage < pagination.total_pages - 1) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
            html += `<li class="page-item"><a class="page-link" href="#" data-page="${pagination.total_pages}">${pagination.total_pages}</a></li>`;
        }

        // Next button
        if (pagination.current_page < pagination.total_pages) {
            html += `<li class="page-item"><a class="page-link" href="#" data-page="${pagination.current_page + 1}">{{ __('Next') }}</a></li>`;
        } else {
            html += `<li class="page-item disabled"><span class="page-link">{{ __('Next') }}</span></li>`;
        }

        paginationList.html(html);

        // Pagination click handlers
        paginationList.off('click', '.page-link').on('click', '.page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page && page !== pagination.current_page) {
                pagination.current_page = page;
                loadResearchers();
                $('html, body').animate({ scrollTop: 0 }, 'smooth');
            }
        });
    }

    function exportResearchers() {
        const filters = {
            search: $('#searchFilter').val(),
            research_domain: $('#domainFilter').val(),
            status: $('#statusFilter').val()
        };

        // Remove empty filters
        Object.keys(filters).forEach(key => {
            if (!filters[key]) {
                delete filters[key];
            }
        });

        // Create form and submit
        const form = $('<form>', {
            method: 'GET',
            action: '/api/v1/researchers/export'
        });

        Object.keys(filters).forEach(key => {
            form.append($('<input>', {
                type: 'hidden',
                name: key,
                value: filters[key]
            }));
        });

        $('body').append(form);
        form.submit();
        form.remove();
    }

    function showLoading() {
        $('#loadingState').removeClass('d-none');
        $('#researchersGrid').addClass('d-none');
        $('#noResults').addClass('d-none');
    }

    function hideLoading() {
        $('#loadingState').addClass('d-none');
    }

    function showError(message) {
        const alertHtml = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        $('.alert').remove();
        $('#researchers-container').prepend(alertHtml);

        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
@endpush

@push('styles')
<style>
.researcher-card {
    transition: transform 0.2s ease-in-out;
}

.researcher-card:hover {
    transform: translateY(-4px);
}

.researcher-card .card-title {
    word-break: break-word;
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .researcher-card {
        margin-bottom: 16px;
    }
}
</style>
@endpush