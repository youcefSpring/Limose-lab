@extends('layouts.app', ['title' => __('Publications Management')])

@section('content')
<div id="publications-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Publications Management') }}</h2>
            <p class="text-muted mb-0">{{ __('Manage research publications and papers') }}</p>
        </div>
        @can('create', App\Models\Publication::class)
        <a href="{{ route('publications.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>{{ __('Add Publication') }}
        </a>
        @endcan
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1" id="totalPublications">-</div>
                    <div class="small">{{ __('Total Publications') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1" id="thisYearPublications">-</div>
                    <div class="small">{{ __('This Year') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1" id="totalCitations">-</div>
                    <div class="small">{{ __('Total Citations') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1" id="averageImpactFactor">-</div>
                    <div class="small">{{ __('Avg Impact Factor') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="searchFilter" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchFilter" placeholder="{{ __('Search publications...') }}">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="typeFilter" class="form-label">{{ __('Type') }}</label>
                    <select class="form-select" id="typeFilter">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="article">{{ __('Article') }}</option>
                        <option value="conference">{{ __('Conference') }}</option>
                        <option value="patent">{{ __('Patent') }}</option>
                        <option value="book">{{ __('Book') }}</option>
                        <option value="poster">{{ __('Poster') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="draft">{{ __('Draft') }}</option>
                        <option value="submitted">{{ __('Submitted') }}</option>
                        <option value="published">{{ __('Published') }}</option>
                        <option value="archived">{{ __('Archived') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="yearFilter" class="form-label">{{ __('Year') }}</label>
                    <input type="number" class="form-control" id="yearFilter" placeholder="{{ __('Publication Year') }}" min="1900" max="{{ date('Y') + 5 }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Publications Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="publicationsTable" class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Authors') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Year') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Journal/Venue') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
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
                <div id="publicationToDelete" class="fw-bold text-primary"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-trash me-2"></i>{{ __('Delete') }}
                </button>
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
    let publicationsTable;
    let selectedPublicationId = null;

    // Initialize DataTable
    function initializeTable() {
        if ($.fn.DataTable.isDataTable('#publicationsTable')) {
            $('#publicationsTable').DataTable().destroy();
        }

        publicationsTable = $('#publicationsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/v1/publications',
                data: function(d) {
                    d.search_term = $('#searchFilter').val();
                    d.type = $('#typeFilter').val();
                    d.status = $('#statusFilter').val();
                    d.year = $('#yearFilter').val();
                },
                error: function(xhr, error, code) {
                    console.error('DataTable AJAX error:', error);
                    showAlert('error', '{{ __("Error loading publications data") }}');
                }
            },
            columns: [
                {
                    data: 'title',
                    name: 'title',
                    render: function(data, type, row) {
                        const icon = getPublicationTypeIcon(row.type);
                        const venue = row.journal || row.conference || row.publisher || '';
                        return `
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="${icon} text-${getPublicationTypeColor(row.type)}" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">${data}</div>
                                    ${venue ? `<small class="text-muted">${venue}</small>` : ''}
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'authors',
                    name: 'authors',
                    render: function(data, type, row) {
                        if (!data || data.length === 0) return '-';
                        const authorsText = data.substring(0, 50) + (data.length > 50 ? '...' : '');
                        return `<span title="${data}">${authorsText}</span>`;
                    }
                },
                {
                    data: 'type',
                    name: 'type',
                    render: function(data, type, row) {
                        return `<span class="badge bg-${getPublicationTypeColor(data)}">${getPublicationTypeText(data)}</span>`;
                    }
                },
                {
                    data: 'publication_year',
                    name: 'publication_year',
                    className: 'text-center'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        return `<span class="badge bg-${getStatusColor(data)}">${getStatusText(data)}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return row.journal || row.conference || row.publisher || '-';
                    },
                    orderable: false
                },
                {
                    data: 'id',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        let actions = `
                            <div class="btn-group" role="group">
                                <a href="/publications/${data}" class="btn btn-sm btn-outline-primary" title="{{ __('View') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                        `;

                        @can('update', App\Models\Publication::class)
                        actions += `
                                <a href="/publications/${data}/edit" class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                        `;
                        @endcan

                        if (row.doi) {
                            actions += `
                                <a href="https://doi.org/${row.doi}" target="_blank" class="btn btn-sm btn-outline-info" title="{{ __('DOI') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            `;
                        }

                        if (row.pdf_path) {
                            actions += `
                                <a href="${row.pdf_path}" target="_blank" class="btn btn-sm btn-outline-success" title="{{ __('Download') }}">
                                    <i class="fas fa-download"></i>
                                </a>
                            `;
                        }

                        @can('delete', App\Models\Publication::class)
                        actions += `
                                <button class="btn btn-sm btn-outline-danger delete-publication" data-id="${data}" data-title="${row.title}" title="{{ __('Delete') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                        `;
                        @endcan

                        actions += '</div>';
                        return actions;
                    }
                }
            ],
            pageLength: 25,
            responsive: true,
            language: {
                processing: "{{ __('Loading...') }}",
                search: "{{ __('Search:') }}",
                lengthMenu: "{{ __('Show _MENU_ entries') }}",
                info: "{{ __('Showing _START_ to _END_ of _TOTAL_ entries') }}",
                infoEmpty: "{{ __('Showing 0 to 0 of 0 entries') }}",
                infoFiltered: "{{ __('(filtered from _MAX_ total entries)') }}",
                paginate: {
                    first: "{{ __('First') }}",
                    last: "{{ __('Last') }}",
                    next: "{{ __('Next') }}",
                    previous: "{{ __('Previous') }}"
                }
            }
        });
    }

    // Load statistics
    function loadStatistics() {
        $.ajax({
            url: '/api/v1/publications/stats',
            method: 'GET',
            success: function(response) {
                if (response.success && response.data) {
                    $('#totalPublications').text(response.data.totalPublications || 0);
                    $('#thisYearPublications').text(response.data.thisYearPublications || 0);
                    $('#totalCitations').text(response.data.totalCitations || 0);
                    $('#averageImpactFactor').text(response.data.averageImpactFactor || '0.0');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading statistics:', error);
            }
        });
    }

    // Filter change handlers
    $('#searchFilter, #typeFilter, #statusFilter, #yearFilter').on('change keyup', function() {
        if (publicationsTable) {
            publicationsTable.ajax.reload();
        }
    });

    // Clear search
    $('#clearSearch').click(function() {
        $('#searchFilter').val('');
        if (publicationsTable) {
            publicationsTable.ajax.reload();
        }
    });

    // Delete publication handler
    $(document).on('click', '.delete-publication', function() {
        selectedPublicationId = $(this).data('id');
        const publicationTitle = $(this).data('title');
        $('#publicationToDelete').text(publicationTitle);
        $('#deleteModal').modal('show');
    });

    // Confirm delete
    $('#confirmDelete').click(function() {
        if (selectedPublicationId) {
            const button = $(this);
            const originalText = button.html();

            button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __("Deleting...") }}');

            $.ajax({
                url: `/api/v1/publications/${selectedPublicationId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    showAlert('success', '{{ __("Publication deleted successfully") }}');
                    publicationsTable.ajax.reload();
                    loadStatistics();
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting publication:', error);
                    showAlert('error', '{{ __("Error deleting publication") }}');
                },
                complete: function() {
                    button.prop('disabled', false).html(originalText);
                    selectedPublicationId = null;
                }
            });
        }
    });

    // Helper functions
    function getPublicationTypeIcon(type) {
        const icons = {
            'article': 'fas fa-file-alt',
            'conference': 'fas fa-users',
            'patent': 'fas fa-lightbulb',
            'book': 'fas fa-book',
            'poster': 'fas fa-image'
        };
        return icons[type] || 'fas fa-file';
    }

    function getPublicationTypeColor(type) {
        const colors = {
            'article': 'primary',
            'conference': 'success',
            'patent': 'warning',
            'book': 'info',
            'poster': 'secondary'
        };
        return colors[type] || 'secondary';
    }

    function getPublicationTypeText(type) {
        const texts = {
            'article': '{{ __("Article") }}',
            'conference': '{{ __("Conference") }}',
            'patent': '{{ __("Patent") }}',
            'book': '{{ __("Book") }}',
            'poster': '{{ __("Poster") }}'
        };
        return texts[type] || type;
    }

    function getStatusColor(status) {
        const colors = {
            'draft': 'secondary',
            'submitted': 'warning',
            'published': 'success',
            'archived': 'dark'
        };
        return colors[status] || 'secondary';
    }

    function getStatusText(status) {
        const texts = {
            'draft': '{{ __("Draft") }}',
            'submitted': '{{ __("Submitted") }}',
            'published': '{{ __("Published") }}',
            'archived': '{{ __("Archived") }}'
        };
        return texts[status] || status;
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
        $('#publications-container').prepend(alertHtml);

        // Auto-hide after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }

    // Initialize everything
    initializeTable();
    loadStatistics();
});
</script>
@endpush