@extends('layouts.app', ['title' => __('Project Management')])

@section('content')
<div id="projects-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Research Projects') }}</h2>
            <p class="text-muted mb-0">{{ __('Explore ongoing and completed research initiatives') }}</p>
        </div>
        @auth
            @if(auth()->user()->isResearcher() || auth()->user()->isAdmin() || auth()->user()->isLabManager())
                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('New Project') }}
                </a>
            @endif
        @endauth
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-folder fa-2x opacity-75"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0" data-stat="total_projects">0</h5>
                            <p class="card-text small opacity-75 mb-0">{{ __('Total Projects') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-play-circle fa-2x opacity-75"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0" data-stat="active_projects">0</h5>
                            <p class="card-text small opacity-75 mb-0">{{ __('Active Projects') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0" data-stat="pending_projects">0</h5>
                            <p class="card-text small opacity-75 mb-0">{{ __('Pending Projects') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0" data-stat="completed_projects">0</h5>
                            <p class="card-text small opacity-75 mb-0">{{ __('Completed Projects') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="searchFilter" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchFilter" placeholder="{{ __('Search projects...') }}">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="statusFilter" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="active">{{ __('Active') }}</option>
                        <option value="completed">{{ __('Completed') }}</option>
                        <option value="suspended">{{ __('Suspended') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="leaderFilter" class="form-label">{{ __('Leader') }}</label>
                    <select class="form-select" id="leaderFilter">
                        <option value="">{{ __('All Leaders') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="budgetFilter" class="form-label">{{ __('Budget') }}</label>
                    <select class="form-select" id="budgetFilter">
                        <option value="">{{ __('All') }}</option>
                        <option value="0-10000">{{ __('Under $10K') }}</option>
                        <option value="10000-50000">{{ __('$10K - $50K') }}</option>
                        <option value="50000-100000">{{ __('$50K - $100K') }}</option>
                        <option value="100000-999999999">{{ __('Over $100K') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('View Mode') }}</label>
                    <div class="d-flex justify-content-between">
                        <div class="btn-group w-75" role="group">
                            <button type="button" class="btn btn-outline-primary active" id="gridView">
                                <i class="fas fa-th-large me-1"></i>{{ __('Grid') }}
                            </button>
                            <button type="button" class="btn btn-outline-primary" id="listView">
                                <i class="fas fa-list me-1"></i>{{ __('List') }}
                            </button>
                        </div>
                        <button type="button" class="btn btn-outline-secondary" id="exportProjects">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Container -->
    <div id="projects-content">
        <!-- Grid View -->
        <div id="projects-grid" class="row">
            <!-- Projects will be loaded here -->
        </div>

        <!-- List View -->
        <div id="projects-list" class="d-none">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="projectsTable" class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Project') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Leader') }}</th>
                                    <th>{{ __('Progress') }}</th>
                                    <th>{{ __('Budget') }}</th>
                                    <th>{{ __('Timeline') }}</th>
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

        <!-- Loading State -->
        <div id="loading-state" class="text-center py-5 d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">{{ __('Loading...') }}</span>
            </div>
            <div class="mt-2">{{ __('Loading projects...') }}</div>
        </div>

        <!-- No Results -->
        <div id="no-results" class="text-center py-5 d-none">
            <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">{{ __('No projects found') }}</h5>
            <p class="text-muted">{{ __('Try adjusting your search criteria or create a new project') }}</p>
            @auth
                @if(auth()->user()->isResearcher() || auth()->user()->isAdmin() || auth()->user()->isLabManager())
                    <a href="{{ route('projects.create') }}" class="btn btn-primary">
                        {{ __('Create First Project') }}
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <!-- Pagination -->
    <nav id="pagination-container" class="d-flex justify-content-center mt-4 d-none">
        <ul class="pagination" id="pagination">
            <!-- Pagination will be generated here -->
        </ul>
    </nav>
</div>

<!-- Project Details Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="projectModalBody">
                <!-- Project details will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentViewMode = 'grid';
    let currentPage = 1;
    let projectsTable = null;
    let totalPages = 1;

    // Initialize
    loadProjectStats();
    loadLeaders();
    loadProjects();

    // View mode toggle
    $('#gridView').on('click', function() {
        switchViewMode('grid');
    });

    $('#listView').on('click', function() {
        switchViewMode('list');
    });

    // Filter event handlers
    $('#searchFilter').on('keyup', debounce(function() {
        currentPage = 1;
        loadProjects();
    }, 300));

    $('#clearSearch').on('click', function() {
        $('#searchFilter').val('');
        currentPage = 1;
        loadProjects();
    });

    $('#statusFilter, #leaderFilter, #budgetFilter').on('change', function() {
        currentPage = 1;
        loadProjects();
    });

    // Export handler
    $('#exportProjects').on('click', function() {
        exportProjects();
    });

    function switchViewMode(mode) {
        currentViewMode = mode;

        if (mode === 'grid') {
            $('#gridView').addClass('active');
            $('#listView').removeClass('active');
            $('#projects-grid').removeClass('d-none');
            $('#projects-list').addClass('d-none');

            // Destroy table if exists
            if (projectsTable) {
                projectsTable.destroy();
                projectsTable = null;
            }

            loadProjects();
        } else {
            $('#listView').addClass('active');
            $('#gridView').removeClass('active');
            $('#projects-list').removeClass('d-none');
            $('#projects-grid').addClass('d-none');

            initializeDataTable();
        }
    }

    function loadProjectStats() {
        $.get('/api/v1/analytics/projects')
            .done(function(response) {
                if (response.status === 'success') {
                    const stats = response.data.overview;
                    $('[data-stat="total_projects"]').text(stats.total_projects || 0);
                    $('[data-stat="active_projects"]').text(stats.active_projects || 0);
                    $('[data-stat="pending_projects"]').text(stats.pending_projects || 0);
                    $('[data-stat="completed_projects"]').text(stats.completed_projects || 0);
                }
            })
            .fail(function(xhr) {
                console.error('Failed to load project stats:', xhr);
            });
    }

    function loadLeaders() {
        $.get('/api/v1/researchers?role=leader')
            .done(function(response) {
                if (response.status === 'success') {
                    const select = $('#leaderFilter');
                    response.data.researchers.forEach(function(researcher) {
                        select.append(`<option value="${researcher.id}">${researcher.full_name}</option>`);
                    });
                }
            })
            .fail(function(xhr) {
                console.error('Failed to load leaders:', xhr);
            });
    }

    function loadProjects() {
        if (currentViewMode === 'list' && projectsTable) {
            projectsTable.ajax.reload();
            return;
        }

        showLoading();

        const params = {
            page: currentPage,
            per_page: currentViewMode === 'grid' ? 12 : 15,
            search: $('#searchFilter').val(),
            status: $('#statusFilter').val(),
            leader_id: $('#leaderFilter').val(),
            budget_range: $('#budgetFilter').val()
        };

        // Remove empty params
        Object.keys(params).forEach(key => {
            if (!params[key]) delete params[key];
        });

        $.get('/api/v1/projects', params)
            .done(function(response) {
                if (response.status === 'success') {
                    const data = response.data;

                    if (currentViewMode === 'grid') {
                        renderProjectsGrid(data.projects);
                    }

                    updatePagination(data.pagination);
                    hideLoading();

                    if (data.projects.length === 0) {
                        showNoResults();
                    }
                } else {
                    hideLoading();
                    showNoResults();
                }
            })
            .fail(function(xhr) {
                console.error('Failed to load projects:', xhr);
                hideLoading();
                showAlert('danger', '{{ __("Failed to load projects") }}');
            });
    }

    function renderProjectsGrid(projects) {
        const container = $('#projects-grid');
        container.empty();

        if (projects.length === 0) {
            showNoResults();
            return;
        }

        projects.forEach(function(project) {
            const projectCard = createProjectCard(project);
            container.append(projectCard);
        });
    }

    function createProjectCard(project) {
        const progress = project.progress_percentage || 0;
        const progressColor = progress < 30 ? 'danger' : progress < 70 ? 'warning' : 'success';

        return $(`
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm project-card">
                    <div class="card-header d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1 fw-bold">${project.title}</h6>
                            <span class="badge" style="background-color: ${getStatusColor(project.status)};">
                                ${getStatusText(project.status)}
                            </span>
                        </div>
                        ${canEditProject() ? `
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/projects/${project.id}/edit">
                                        <i class="fas fa-edit me-2"></i>${'{{ __("Edit") }}'}
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" onclick="archiveProject(${project.id})">
                                        <i class="fas fa-archive me-2"></i>${'{{ __("Archive") }}'}
                                    </a></li>
                                </ul>
                            </div>
                        ` : ''}
                    </div>
                    <div class="card-body">
                        <!-- Project Leader -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 me-2">
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                </div>
                            </div>
                            <div>
                                <div class="fw-medium small">${project.principal_investigator.name}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">${'{{ __("Project Leader") }}'}</div>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="card-text text-muted small" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            ${project.description || '{{ __("No description available") }}'}
                        </p>

                        <!-- Project Info -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="text-muted" style="font-size: 0.75rem;">{{ __('Budget') }}</div>
                                <div class="fw-medium small">${project.budget ? formatCurrency(project.budget) : '{{ __("Not specified") }}'}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted" style="font-size: 0.75rem;">{{ __('Timeline') }}</div>
                                <div class="fw-medium small">${formatDateShort(project.start_date)} - ${formatDateShort(project.end_date)}</div>
                            </div>
                        </div>

                        <!-- Progress -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size: 0.75rem;">{{ __('Progress') }}</span>
                                <span style="font-size: 0.75rem;">${progress}%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-${progressColor}" style="width: ${progress}%"></div>
                            </div>
                        </div>

                        <!-- Team Stats -->
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="h6 fw-bold text-primary mb-0">${project.members_count || 0}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">{{ __('Members') }}</div>
                            </div>
                            <div class="col-6">
                                <div class="h6 fw-bold text-success mb-0">${project.publications_count || 0}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">{{ __('Publications') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-center">
                        <a href="/projects/${project.id}" class="btn btn-primary btn-sm">
                            {{ __('View Details') }}
                        </a>
                    </div>
                </div>
            </div>
        `);
    }

    function initializeDataTable() {
        if (projectsTable) return;

        projectsTable = $('#projectsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/v1/projects',
                data: function(d) {
                    d.search = $('#searchFilter').val();
                    d.status = $('#statusFilter').val();
                    d.leader_id = $('#leaderFilter').val();
                    d.budget_range = $('#budgetFilter').val();
                }
            },
            columns: [
                {
                    data: 'title',
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-primary rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-folder text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-medium">${row.title}</div>
                                    <div class="text-muted small">${truncateText(row.description, 50)}</div>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'status',
                    render: function(data) {
                        return `<span class="badge" style="background-color: ${getStatusColor(data)};">${getStatusText(data)}</span>`;
                    }
                },
                {
                    data: 'principal_investigator',
                    render: function(data) {
                        return `
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-medium">${data.name}</div>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'progress_percentage',
                    render: function(data) {
                        const percentage = data || 0;
                        const color = percentage < 30 ? 'danger' : percentage < 70 ? 'warning' : 'success';
                        return `
                            <div style="min-width: 100px;">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>${percentage}%</small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-${color}" style="width: ${percentage}%"></div>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'budget',
                    render: function(data) {
                        return data ? formatCurrency(data) : '<span class="text-muted">{{ __("Not specified") }}</span>';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        const startDate = formatDateShort(row.start_date);
                        const endDate = formatDateShort(row.end_date);
                        const daysRemaining = calculateDaysRemaining(row.end_date);
                        const daysClass = daysRemaining < 30 ? 'text-danger' : daysRemaining < 90 ? 'text-warning' : 'text-success';

                        return `
                            <div>
                                <div class="small">${startDate} - ${endDate}</div>
                                <div class="small ${daysClass}">${daysRemaining} {{ __("days remaining") }}</div>
                            </div>
                        `;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        let actions = `
                            <div class="btn-group" role="group">
                                <a href="/projects/${row.id}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                        `;

                        if (canEditProject()) {
                            actions += `
                                <a href="/projects/${row.id}/edit" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            `;
                        }

                        actions += '</div>';
                        return actions;
                    }
                }
            ],
            language: {
                processing: '<i class="fas fa-spinner fa-spin"></i> {{ __("Loading...") }}',
                emptyTable: '{{ __("No projects found") }}',
                zeroRecords: '{{ __("No matching projects found") }}',
                info: '{{ __("Showing _START_ to _END_ of _TOTAL_ projects") }}',
                infoEmpty: '{{ __("Showing 0 to 0 of 0 projects") }}',
                infoFiltered: '{{ __("(filtered from _MAX_ total projects)") }}',
                lengthMenu: '{{ __("Show _MENU_ projects per page") }}',
                search: '{{ __("Search:") }}',
                paginate: {
                    first: '{{ __("First") }}',
                    last: '{{ __("Last") }}',
                    next: '{{ __("Next") }}',
                    previous: '{{ __("Previous") }}'
                }
            },
            pageLength: 15,
            responsive: true,
            order: [[0, 'asc']]
        });
    }

    function updatePagination(pagination) {
        totalPages = pagination.total_pages;
        currentPage = pagination.current_page;

        if (totalPages <= 1) {
            $('#pagination-container').addClass('d-none');
            return;
        }

        $('#pagination-container').removeClass('d-none');
        const paginationElement = $('#pagination');
        paginationElement.empty();

        // Previous button
        paginationElement.append(`
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage - 1}">{{ __('Previous') }}</a>
            </li>
        `);

        // Page numbers
        const startPage = Math.max(1, currentPage - 2);
        const endPage = Math.min(totalPages, currentPage + 2);

        if (startPage > 1) {
            paginationElement.append(`<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`);
            if (startPage > 2) {
                paginationElement.append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationElement.append(`
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `);
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationElement.append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
            }
            paginationElement.append(`<li class="page-item"><a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a></li>`);
        }

        // Next button
        paginationElement.append(`
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage + 1}">{{ __('Next') }}</a>
            </li>
        `);

        // Handle pagination clicks
        paginationElement.off('click').on('click', 'a.page-link', function(e) {
            e.preventDefault();
            const page = parseInt($(this).data('page'));
            if (page && page !== currentPage && page >= 1 && page <= totalPages) {
                currentPage = page;
                loadProjects();
            }
        });
    }

    function showLoading() {
        $('#loading-state').removeClass('d-none');
        $('#no-results').addClass('d-none');
    }

    function hideLoading() {
        $('#loading-state').addClass('d-none');
    }

    function showNoResults() {
        $('#no-results').removeClass('d-none');
    }

    function exportProjects() {
        const params = {
            search: $('#searchFilter').val(),
            status: $('#statusFilter').val(),
            leader_id: $('#leaderFilter').val(),
            budget_range: $('#budgetFilter').val(),
            format: 'excel'
        };

        // Remove empty params
        Object.keys(params).forEach(key => {
            if (!params[key]) delete params[key];
        });

        const btn = $('#exportProjects');
        const originalHtml = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

        $.get('/api/v1/projects/export', params)
            .done(function(response, status, xhr) {
                // Create download link
                const blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `projects-${new Date().toISOString().split('T')[0]}.xlsx`);
                document.body.appendChild(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);
            })
            .fail(function(xhr) {
                console.error('Export failed:', xhr);
                showAlert('danger', '{{ __("Export failed. Please try again.") }}');
            })
            .always(function() {
                btn.html(originalHtml).prop('disabled', false);
            });
    }

    // Global functions
    window.archiveProject = function(projectId) {
        if (confirm('{{ __("Are you sure you want to archive this project?") }}')) {
            $.post(`/api/v1/projects/${projectId}/archive`)
                .done(function(response) {
                    if (response.status === 'success') {
                        loadProjects();
                        loadProjectStats();
                        showAlert('success', '{{ __("Project archived successfully") }}');
                    }
                })
                .fail(function(xhr) {
                    console.error('Archive failed:', xhr);
                    showAlert('danger', '{{ __("Failed to archive project") }}');
                });
        }
    };

    // Helper functions
    function canEditProject() {
        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isLabManager())
                return true;
            @endif
        @endauth
        return false;
    }

    function getStatusColor(status) {
        const colors = {
            pending: '#ffc107',
            active: '#198754',
            completed: '#0d6efd',
            suspended: '#dc3545'
        };
        return colors[status] || '#6c757d';
    }

    function getStatusText(status) {
        const texts = {
            pending: '{{ __("Pending") }}',
            active: '{{ __("Active") }}',
            completed: '{{ __("Completed") }}',
            suspended: '{{ __("Suspended") }}'
        };
        return texts[status] || status;
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('{{ app()->getLocale() }}', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    }

    function formatDateShort(date) {
        return new Date(date).toLocaleDateString('{{ app()->getLocale() }}', {
            year: '2-digit',
            month: 'short'
        });
    }

    function calculateDaysRemaining(endDate) {
        const today = new Date();
        const end = new Date(endDate);
        const diffTime = end - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return Math.max(0, diffDays);
    }

    function truncateText(text, length) {
        if (!text) return '';
        return text.length > length ? text.substring(0, length) + '...' : text;
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';

        const alert = $(`
            <div class="alert ${alertClass} alert-dismissible fade show alert-slide" role="alert">
                <i class="${iconClass} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

        $('#projects-container').prepend(alert);

        setTimeout(function() {
            alert.alert('close');
        }, 5000);
    }
});
</script>
@endpush

@push('styles')
<style>
.project-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.project-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endpush