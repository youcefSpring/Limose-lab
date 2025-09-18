@extends('layouts.app', ['title' => __('Funding Management')])

@section('content')
<div id="funding-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Funding Management') }}</h2>
            <p class="text-muted mb-0">{{ __('Track grants, funding opportunities, and budget allocation') }}</p>
        </div>
        @can('create', App\Models\Funding::class)
        <a href="{{ route('funding.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>{{ __('Add Funding') }}
        </a>
        @endcan
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1" id="totalFunding">-</div>
                    <div class="small">{{ __('Total Funding') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1" id="activeFunding">-</div>
                    <div class="small">{{ __('Active Grants') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1" id="budgetUsed">-</div>
                    <div class="small">{{ __('Budget Used') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body text-center">
                    <div class="h4 fw-bold mb-1" id="availableBudget">-</div>
                    <div class="small">{{ __('Available Budget') }}</div>
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
                        <input type="text" class="form-control" id="searchFilter" placeholder="{{ __('Search funding...') }}">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="typeFilter" class="form-label">{{ __('Funding Type') }}</label>
                    <select class="form-select" id="typeFilter">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="government_grant">{{ __('Government Grant') }}</option>
                        <option value="private_foundation">{{ __('Private Foundation') }}</option>
                        <option value="industry_partnership">{{ __('Industry Partnership') }}</option>
                        <option value="internal_funding">{{ __('Internal Funding') }}</option>
                        <option value="international_grant">{{ __('International Grant') }}</option>
                        <option value="crowdfunding">{{ __('Crowdfunding') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="applied">{{ __('Applied') }}</option>
                        <option value="under_review">{{ __('Under Review') }}</option>
                        <option value="awarded">{{ __('Awarded') }}</option>
                        <option value="active">{{ __('Active') }}</option>
                        <option value="completed">{{ __('Completed') }}</option>
                        <option value="rejected">{{ __('Rejected') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="yearFilter" class="form-label">{{ __('Year') }}</label>
                    <input type="number" class="form-control" id="yearFilter" placeholder="{{ __('Year') }}" min="2000" max="{{ date('Y') + 5 }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Funding Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="fundingTable" class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Duration') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('PI') }}</th>
                            <th>{{ __('Budget Used') }}</th>
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

    <!-- Delete Confirmation Dialog -->
    <v-dialog v-model="deleteDialog" max-width="400">
        <v-card>
            <v-card-title class="text-h5">{{ __('Confirm Delete') }}</v-card-title>
            <v-card-text>
                {{ __('Are you sure you want to delete this funding record? This action cannot be undone.') }}
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="deleteDialog = false">
                    {{ __('Cancel') }}
                </v-btn>
                <v-btn color="error" @click="deleteFunding" :loading="deleteLoading">
                    {{ __('Delete') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- Add Expense Dialog -->
    <v-dialog v-model="expenseDialog" max-width="600">
        <v-card>
            <v-card-title>
                <span class="text-h5">{{ __('Add Expense') }}</span>
            </v-card-title>
            <v-card-text>
                <div v-if="selectedFunding">
                    <div class="d-flex align-center mb-4">
                        <v-avatar :color="getFundingTypeColor(selectedFunding.type)" class="mr-3">
                            <v-icon>@{{ getFundingTypeIcon(selectedFunding.type) }}</v-icon>
                        </v-avatar>
                        <div>
                            <div class="font-weight-medium">@{{ selectedFunding.title }}</div>
                            <div class="text-caption text-grey">
                                {{ __('Available:') }} @{{ formatCurrency(getAvailableBudget(selectedFunding)) }}
                            </div>
                        </div>
                    </div>

                    <v-form ref="expenseForm">
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="expenseForm.amount"
                                    :label="'{{ __('Amount') }}'"
                                    type="number"
                                    variant="outlined"
                                    required
                                    prefix="$"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model="expenseForm.date"
                                    :label="'{{ __('Date') }}'"
                                    type="date"
                                    variant="outlined"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-select
                                    v-model="expenseForm.category"
                                    :items="expenseCategories"
                                    :label="'{{ __('Category') }}'"
                                    variant="outlined"
                                    required
                                ></v-select>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    v-model="expenseForm.description"
                                    :label="'{{ __('Description') }}'"
                                    variant="outlined"
                                    rows="3"
                                    required
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-form>
                </div>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="expenseDialog = false">
                    {{ __('Cancel') }}
                </v-btn>
                <v-btn color="primary" @click="submitExpense" :loading="expenseLoading">
                    {{ __('Add Expense') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- Statistics Cards -->
    <v-row class="mt-6">
        <v-col cols="12" md="3">
            <v-card>
                <v-card-text class="text-center">
                    <div class="text-h4 font-weight-bold text-primary">@{{ formatCurrency(stats.totalFunding) }}</div>
                    <div class="text-body-2 text-grey">{{ __('Total Funding') }}</div>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" md="3">
            <v-card>
                <v-card-text class="text-center">
                    <div class="text-h4 font-weight-bold text-success">@{{ stats.activeFunding }}</div>
                    <div class="text-body-2 text-grey">{{ __('Active Grants') }}</div>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" md="3">
            <v-card>
                <v-card-text class="text-center">
                    <div class="text-h4 font-weight-bold text-info">@{{ formatCurrency(stats.budgetUsed) }}</div>
                    <div class="text-body-2 text-grey">{{ __('Budget Used') }}</div>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" md="3">
            <v-card>
                <v-card-text class="text-center">
                    <div class="text-h4 font-weight-bold text-warning">@{{ formatCurrency(stats.availableBudget) }}</div>
                    <div class="text-body-2 text-grey">{{ __('Available Budget') }}</div>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let fundingTable;
    let selectedFundingId = null;
    let selectedFunding = null;

    // Initialize DataTable
    function initializeTable() {
        if ($.fn.DataTable.isDataTable('#fundingTable')) {
            $('#fundingTable').DataTable().destroy();
        }

        fundingTable = $('#fundingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/v1/funding',
                data: function(d) {
                    d.search_term = $('#searchFilter').val();
                    d.type = $('#typeFilter').val();
                    d.status = $('#statusFilter').val();
                    d.year = $('#yearFilter').val();
                },
                error: function(xhr, error, code) {
                    console.error('DataTable AJAX error:', error);
                    showAlert('error', '{{ __("Error loading funding data") }}');
                }
            },
            columns: [
                {
                    data: 'title',
                    name: 'title',
                    render: function(data, type, row) {
                        const icon = getFundingTypeIcon(row.type);
                        const color = getFundingTypeColor(row.type);
                        return `
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="rounded d-flex align-items-center justify-content-center bg-${color} text-white" style="width: 40px; height: 40px;">
                                        <i class="${icon}"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold">${data}</div>
                                    <small class="text-muted">${row.funding_agency || ''}</small>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'type',
                    name: 'type',
                    render: function(data, type, row) {
                        const color = getFundingTypeColor(data);
                        const text = getFundingTypeText(data);
                        return `<span class="badge bg-${color}">${text}</span>`;
                    }
                },
                {
                    data: 'amount',
                    name: 'amount',
                    className: 'text-center',
                    render: function(data, type, row) {
                        const formatted = formatCurrency(data);
                        let currencyNote = '';
                        if (row.currency && row.currency !== 'USD') {
                            currencyNote = `<br><small class="text-muted">${row.currency}</small>`;
                        }
                        return `<div class="fw-medium">${formatted}${currencyNote}</div>`;
                    }
                },
                {
                    data: 'start_date',
                    name: 'start_date',
                    render: function(data, type, row) {
                        let html = `<div>${formatDate(data)}</div>`;
                        if (row.end_date) {
                            html += `<small class="text-muted">{{ __('to') }} ${formatDate(row.end_date)}</small><br>`;
                        }
                        const status = getDurationStatus(row);
                        const statusClass = getDurationStatusClass(row);
                        if (status) {
                            html += `<small class="${statusClass}">${status}</small>`;
                        }
                        return html;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        const color = getStatusColor(data);
                        const icon = getStatusIcon(data);
                        const text = getStatusText(data);
                        return `<span class="badge bg-${color}"><i class="${icon} me-1"></i>${text}</span>`;
                    }
                },
                {
                    data: 'principal_investigator',
                    name: 'principal_investigator',
                    render: function(data, type, row) {
                        if (data) {
                            return `
                                <div>${data.name}</div>
                                <small class="text-muted">${data.department || ''}</small>
                            `;
                        }
                        return '<span class="text-muted">-</span>';
                    }
                },
                {
                    data: 'budget_used',
                    name: 'budget_used',
                    className: 'text-center',
                    render: function(data, type, row) {
                        const percentage = getBudgetUsedPercentage(row);
                        const color = getBudgetUsedColor(row);
                        const used = formatCurrency(data || 0);
                        const total = formatCurrency(row.amount);
                        return `
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <div class="progress me-2" style="width: 50px; height: 6px;">
                                    <div class="progress-bar bg-${color}" style="width: ${percentage}%"></div>
                                </div>
                                <small>${percentage}%</small>
                            </div>
                            <small class="text-muted">${used} / ${total}</small>
                        `;
                    }
                },
                {
                    data: 'id',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        let actions = `
                            <div class="btn-group" role="group">
                                <a href="/funding/${data}" class="btn btn-sm btn-outline-primary" title="{{ __('View') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                        `;

                        @can('update', App\Models\Funding::class)
                        actions += `
                                <a href="/funding/${data}/edit" class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                        `;
                        @endcan

                        @can('delete', App\Models\Funding::class)
                        actions += `
                                <button class="btn btn-sm btn-outline-danger delete-funding" data-id="${data}" data-title="${row.title}" title="{{ __('Delete') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                        `;
                        @endcan

                        if (row.status === 'active') {
                            actions += `
                                <button class="btn btn-sm btn-outline-success add-expense" data-id="${data}" title="{{ __('Add Expense') }}">
                                    <i class="fas fa-plus"></i>
                                </button>
                            `;
                        }

                        actions += `
                                <a href="/api/v1/funding/${data}/report" target="_blank" class="btn btn-sm btn-outline-info" title="{{ __('Report') }}">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                            </div>
                        `;
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
            url: '/api/v1/funding/stats',
            method: 'GET',
            success: function(response) {
                if (response.success && response.data) {
                    $('#totalFunding').text(formatCurrency(response.data.totalFunding || 0));
                    $('#activeFunding').text(response.data.activeFunding || 0);
                    $('#budgetUsed').text(formatCurrency(response.data.budgetUsed || 0));
                    $('#availableBudget').text(formatCurrency(response.data.availableBudget || 0));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading statistics:', error);
            }
        });
    }

    // Filter change handlers
    $('#searchFilter, #typeFilter, #statusFilter, #yearFilter').on('change keyup', function() {
        if (fundingTable) {
            fundingTable.ajax.reload();
        }
    });

    // Clear search
    $('#clearSearch').click(function() {
        $('#searchFilter').val('');
        if (fundingTable) {
            fundingTable.ajax.reload();
        }
    });

    // Delete funding handler
    $(document).on('click', '.delete-funding', function() {
        selectedFundingId = $(this).data('id');
        const fundingTitle = $(this).data('title');
        $('#fundingToDelete').text(fundingTitle);
        $('#deleteModal').modal('show');
    });

    // Confirm delete
    $('#confirmDelete').click(function() {
        if (selectedFundingId) {
            const button = $(this);
            const originalText = button.html();

            button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __("Deleting...") }}');

            $.ajax({
                url: `/api/v1/funding/${selectedFundingId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    showAlert('success', '{{ __("Funding deleted successfully") }}');
                    fundingTable.ajax.reload();
                    loadStatistics();
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting funding:', error);
                    showAlert('error', '{{ __("Error deleting funding") }}');
                },
                complete: function() {
                    button.prop('disabled', false).html(originalText);
                    selectedFundingId = null;
                }
            });
        }
    });

    // Add expense handler
    $(document).on('click', '.add-expense', function() {
        const fundingId = $(this).data('id');
        // Get funding details from the table
        const rowData = fundingTable.row($(this).closest('tr')).data();
        selectedFunding = rowData;
        selectedFundingId = fundingId;

        $('#selectedFundingTitle').text(rowData.title);
        const available = rowData.amount - (rowData.budget_used || 0);
        $('#selectedFundingAvailable').text('{{ __("Available:") }} ' + formatCurrency(available));

        // Reset form
        $('#expenseForm')[0].reset();
        $('#expenseDate').val(new Date().toISOString().split('T')[0]);

        $('#expenseModal').modal('show');
    });

    // Submit expense
    $('#submitExpense').click(function() {
        const form = $('#expenseForm')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const button = $(this);
        const spinner = button.find('.spinner-border');

        button.prop('disabled', true);
        spinner.removeClass('d-none');

        const data = {
            amount: $('#expenseAmount').val(),
            date: $('#expenseDate').val(),
            category: $('#expenseCategory').val(),
            description: $('#expenseDescription').val(),
            funding_id: selectedFundingId
        };

        $.ajax({
            url: `/api/v1/funding/${selectedFundingId}/expenses`,
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#expenseModal').modal('hide');
                showAlert('success', '{{ __("Expense added successfully") }}');
                fundingTable.ajax.reload();
                loadStatistics();
            },
            error: function(xhr, status, error) {
                console.error('Error adding expense:', error);
                const message = xhr.responseJSON?.message || '{{ __("Error adding expense") }}';
                showAlert('error', message);
            },
            complete: function() {
                button.prop('disabled', false);
                spinner.addClass('d-none');
            }
        });
    });

    // Helper functions
    function getFundingTypeIcon(type) {
        const icons = {
            'government_grant': 'fas fa-university',
            'private_foundation': 'fas fa-building',
            'industry_partnership': 'fas fa-industry',
            'internal_funding': 'fas fa-home',
            'international_grant': 'fas fa-globe',
            'crowdfunding': 'fas fa-users'
        };
        return icons[type] || 'fas fa-dollar-sign';
    }

    function getFundingTypeColor(type) {
        const colors = {
            'government_grant': 'primary',
            'private_foundation': 'success',
            'industry_partnership': 'warning',
            'internal_funding': 'info',
            'international_grant': 'secondary',
            'crowdfunding': 'danger'
        };
        return colors[type] || 'secondary';
    }

    function getFundingTypeText(type) {
        const texts = {
            'government_grant': '{{ __("Government Grant") }}',
            'private_foundation': '{{ __("Private Foundation") }}',
            'industry_partnership': '{{ __("Industry Partnership") }}',
            'internal_funding': '{{ __("Internal Funding") }}',
            'international_grant': '{{ __("International Grant") }}',
            'crowdfunding': '{{ __("Crowdfunding") }}'
        };
        return texts[type] || type;
    }

    function getStatusColor(status) {
        const colors = {
            'applied': 'info',
            'under_review': 'warning',
            'awarded': 'success',
            'active': 'primary',
            'completed': 'secondary',
            'rejected': 'danger'
        };
        return colors[status] || 'secondary';
    }

    function getStatusIcon(status) {
        const icons = {
            'applied': 'fas fa-paper-plane',
            'under_review': 'fas fa-clock',
            'awarded': 'fas fa-trophy',
            'active': 'fas fa-check-circle',
            'completed': 'fas fa-flag-checkered',
            'rejected': 'fas fa-times'
        };
        return icons[status] || 'fas fa-question-circle';
    }

    function getStatusText(status) {
        const texts = {
            'applied': '{{ __("Applied") }}',
            'under_review': '{{ __("Under Review") }}',
            'awarded': '{{ __("Awarded") }}',
            'active': '{{ __("Active") }}',
            'completed': '{{ __("Completed") }}',
            'rejected': '{{ __("Rejected") }}'
        };
        return texts[status] || status;
    }

    function formatDate(date) {
        if (!date) return '';
        return new Date(date).toLocaleDateString();
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    }

    function getDurationStatus(item) {
        if (!item.start_date || !item.end_date) return '';

        const now = new Date();
        const endDate = new Date(item.end_date);
        const diffDays = Math.ceil((endDate - now) / (1000 * 60 * 60 * 24));

        if (diffDays < 0) return '{{ __("Expired") }}';
        if (diffDays <= 30) return `{{ __("Expires in") }} ${diffDays} {{ __("days") }}`;
        return '{{ __("Active") }}';
    }

    function getDurationStatusClass(item) {
        if (!item.start_date || !item.end_date) return '';

        const now = new Date();
        const endDate = new Date(item.end_date);
        const diffDays = Math.ceil((endDate - now) / (1000 * 60 * 60 * 24));

        if (diffDays < 0) return 'text-danger';
        if (diffDays <= 30) return 'text-warning';
        return 'text-success';
    }

    function getBudgetUsedPercentage(item) {
        if (!item.amount || !item.budget_used) return 0;
        return Math.round((item.budget_used / item.amount) * 100);
    }

    function getBudgetUsedColor(item) {
        const percentage = getBudgetUsedPercentage(item);
        if (percentage >= 90) return 'danger';
        if (percentage >= 75) return 'warning';
        return 'success';
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
        $('#funding-container').prepend(alertHtml);

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