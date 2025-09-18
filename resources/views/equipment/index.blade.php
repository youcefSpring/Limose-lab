@extends('layouts.app', ['title' => __('Equipment Management')])

@section('content')
<div id="equipment-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Equipment Management') }}</h2>
            <p class="text-muted mb-0">{{ __('Manage laboratory equipment and reservations') }}</p>
        </div>
        @can('create', App\Models\Equipment::class)
        <a href="{{ route('equipment.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>{{ __('Add Equipment') }}
        </a>
        @endcan
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="searchFilter" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchFilter" placeholder="{{ __('Search equipment...') }}">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="categoryFilter" class="form-label">{{ __('Category') }}</label>
                    <select class="form-select" id="categoryFilter">
                        <option value="">{{ __('All Categories') }}</option>
                        <option value="analytical">{{ __('Analytical') }}</option>
                        <option value="microscopy">{{ __('Microscopy') }}</option>
                        <option value="spectroscopy">{{ __('Spectroscopy') }}</option>
                        <option value="chromatography">{{ __('Chromatography') }}</option>
                        <option value="safety">{{ __('Safety') }}</option>
                        <option value="general">{{ __('General') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="operational">{{ __('Operational') }}</option>
                        <option value="maintenance">{{ __('Maintenance') }}</option>
                        <option value="out_of_order">{{ __('Out of Order') }}</option>
                        <option value="reserved">{{ __('Reserved') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="availabilityFilter" class="form-label">{{ __('Availability') }}</label>
                    <select class="form-select" id="availabilityFilter">
                        <option value="">{{ __('All') }}</option>
                        <option value="available">{{ __('Available') }}</option>
                        <option value="reserved">{{ __('Reserved') }}</option>
                        <option value="unavailable">{{ __('Unavailable') }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="equipmentTable" class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Location') }}</th>
                            <th>{{ __('Next Maintenance') }}</th>
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

<!-- Equipment Reservation Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Reserve Equipment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reservationForm">
                    <input type="hidden" id="equipmentId">

                    <!-- Equipment Info -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-primary rounded d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="fas fa-tools text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-bold" id="selectedEquipmentName"></div>
                                    <div class="text-muted small" id="selectedEquipmentModel"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="startDate" class="form-label">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="startDate" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="endDate" class="form-label">{{ __('End Date') }} <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="endDate" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="purpose" class="form-label">{{ __('Purpose') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="purpose" rows="3" placeholder="{{ __('Describe the purpose of this reservation...') }}" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="submitReservation">
                    <span class="spinner-border spinner-border-sm d-none me-2" role="status"></span>
                    {{ __('Reserve') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">{{ __('Confirm Delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-exclamation-triangle text-warning fa-2x me-3"></i>
                    <div>
                        <p class="mb-0">{{ __('Are you sure you want to delete this equipment?') }}</p>
                        <small class="text-muted">{{ __('This action cannot be undone.') }}</small>
                    </div>
                </div>
                <div id="equipmentToDelete"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <span class="spinner-border spinner-border-sm d-none me-2" role="status"></span>
                    {{ __('Delete') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let equipmentTable;
    let selectedEquipment = null;
    let equipmentToDelete = null;

    // Initialize DataTable
    initializeDataTable();

    // Filter event handlers
    $('#searchFilter').on('keyup', function() {
        equipmentTable.search(this.value).draw();
    });

    $('#clearSearch').on('click', function() {
        $('#searchFilter').val('');
        equipmentTable.search('').draw();
    });

    $('#categoryFilter, #statusFilter, #availabilityFilter').on('change', function() {
        equipmentTable.draw();
    });

    // Reservation form handlers
    $('#submitReservation').on('click', function() {
        submitReservation();
    });

    // Delete handlers
    $('#confirmDelete').on('click', function() {
        deleteEquipment();
    });

    function initializeDataTable() {
        equipmentTable = $('#equipmentTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/v1/equipment',
                data: function(d) {
                    d.category = $('#categoryFilter').val();
                    d.status = $('#statusFilter').val();
                    d.availability = $('#availabilityFilter').val();
                }
            },
            columns: [
                {
                    data: 'name',
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-primary rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-tools text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-medium">${row.name}</div>
                                    <div class="text-muted small">${row.model || ''}</div>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'category',
                    render: function(data) {
                        const color = getCategoryColor(data);
                        return `<span class="badge" style="background-color: ${color};">${data}</span>`;
                    }
                },
                {
                    data: 'status',
                    render: function(data) {
                        const color = getStatusColor(data);
                        const icon = getStatusIcon(data);
                        const text = getStatusText(data);
                        return `<span class="badge" style="background-color: ${color};"><i class="${icon} me-1"></i>${text}</span>`;
                    }
                },
                {
                    data: 'location',
                    render: function(data) {
                        return `<div class="d-flex align-items-center"><i class="fas fa-map-marker-alt text-muted me-1"></i>${data}</div>`;
                    }
                },
                {
                    data: 'next_maintenance',
                    render: function(data) {
                        if (!data) {
                            return '<span class="text-muted">{{ __("Not scheduled") }}</span>';
                        }
                        const date = new Date(data);
                        const status = getMaintenanceStatus(data);
                        const statusClass = getMaintenanceStatusClass(data);
                        return `
                            <div>
                                <div class="fw-medium">${date.toLocaleDateString()}</div>
                                <div class="small ${statusClass}">${status}</div>
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
                                <a href="/equipment/${row.id}" class="btn btn-sm btn-outline-primary" title="{{ __('View') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                        `;

                        @can('update', App\Models\Equipment::class)
                        actions += `
                            <a href="/equipment/${row.id}/edit" class="btn btn-sm btn-outline-secondary" title="{{ __('Edit') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        `;
                        @endcan

                        @can('delete', App\Models\Equipment::class)
                        actions += `
                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteEquipment(${row.id}, '${row.name}')" title="{{ __('Delete') }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                        @endcan

                        if (row.status === 'operational') {
                            actions += `
                                <button class="btn btn-sm btn-outline-success" onclick="openReservationModal(${row.id}, '${row.name}', '${row.model || ''}')" title="{{ __('Reserve') }}">
                                    <i class="fas fa-calendar-plus"></i>
                                </button>
                            `;
                        }

                        actions += '</div>';
                        return actions;
                    }
                }
            ],
            language: {
                processing: '<i class="fas fa-spinner fa-spin"></i> {{ __("Loading...") }}',
                emptyTable: '{{ __("No equipment found") }}',
                zeroRecords: '{{ __("No matching equipment found") }}',
                info: '{{ __("Showing _START_ to _END_ of _TOTAL_ equipment") }}',
                infoEmpty: '{{ __("Showing 0 to 0 of 0 equipment") }}',
                infoFiltered: '{{ __("(filtered from _MAX_ total equipment)") }}',
                lengthMenu: '{{ __("Show _MENU_ equipment per page") }}',
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

    // Global functions for button handlers
    window.openReservationModal = function(id, name, model) {
        selectedEquipment = { id: id, name: name, model: model };
        $('#equipmentId').val(id);
        $('#selectedEquipmentName').text(name);
        $('#selectedEquipmentModel').text(model);

        // Reset form
        $('#reservationForm')[0].reset();

        $('#reservationModal').modal('show');
    };

    window.confirmDeleteEquipment = function(id, name) {
        equipmentToDelete = { id: id, name: name };
        $('#equipmentToDelete').html(`<strong>${name}</strong>`);
        $('#deleteModal').modal('show');
    };

    function submitReservation() {
        const form = $('#reservationForm')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const btn = $('#submitReservation');
        const spinner = btn.find('.spinner-border');

        btn.prop('disabled', true);
        spinner.removeClass('d-none');

        const data = {
            equipment_id: $('#equipmentId').val(),
            start_date: $('#startDate').val(),
            end_date: $('#endDate').val(),
            purpose: $('#purpose').val()
        };

        $.post(`/api/v1/equipment/${data.equipment_id}/reservations`, data)
            .done(function(response) {
                if (response.status === 'success') {
                    $('#reservationModal').modal('hide');
                    equipmentTable.ajax.reload();
                    showAlert('success', '{{ __("Equipment reserved successfully") }}');
                } else {
                    showAlert('danger', response.message || '{{ __("Failed to reserve equipment") }}');
                }
            })
            .fail(function(xhr) {
                console.error('Reservation failed:', xhr);
                const message = xhr.responseJSON?.message || '{{ __("Failed to reserve equipment") }}';
                showAlert('danger', message);
            })
            .always(function() {
                btn.prop('disabled', false);
                spinner.addClass('d-none');
            });
    }

    function deleteEquipment() {
        if (!equipmentToDelete) return;

        const btn = $('#confirmDelete');
        const spinner = btn.find('.spinner-border');

        btn.prop('disabled', true);
        spinner.removeClass('d-none');

        $.ajax({
            url: `/api/v1/equipment/${equipmentToDelete.id}`,
            type: 'DELETE',
            success: function(response) {
                if (response.status === 'success') {
                    $('#deleteModal').modal('hide');
                    equipmentTable.ajax.reload();
                    showAlert('success', '{{ __("Equipment deleted successfully") }}');
                } else {
                    showAlert('danger', response.message || '{{ __("Failed to delete equipment") }}');
                }
            },
            error: function(xhr) {
                console.error('Delete failed:', xhr);
                const message = xhr.responseJSON?.message || '{{ __("Failed to delete equipment") }}';
                showAlert('danger', message);
            },
            complete: function() {
                btn.prop('disabled', false);
                spinner.addClass('d-none');
                equipmentToDelete = null;
            }
        });
    }

    // Helper functions
    function getCategoryColor(category) {
        const colors = {
            analytical: '#2196f3',
            microscopy: '#4caf50',
            spectroscopy: '#9c27b0',
            chromatography: '#ff9800',
            safety: '#f44336',
            general: '#757575'
        };
        return colors[category] || '#757575';
    }

    function getStatusColor(status) {
        const colors = {
            operational: '#4caf50',
            maintenance: '#ff9800',
            out_of_order: '#f44336',
            reserved: '#2196f3'
        };
        return colors[status] || '#757575';
    }

    function getStatusIcon(status) {
        const icons = {
            operational: 'fas fa-check-circle',
            maintenance: 'fas fa-tools',
            out_of_order: 'fas fa-times-circle',
            reserved: 'fas fa-calendar-check'
        };
        return icons[status] || 'fas fa-question-circle';
    }

    function getStatusText(status) {
        const texts = {
            operational: '{{ __("Operational") }}',
            maintenance: '{{ __("Maintenance") }}',
            out_of_order: '{{ __("Out of Order") }}',
            reserved: '{{ __("Reserved") }}'
        };
        return texts[status] || status;
    }

    function getMaintenanceStatus(date) {
        const now = new Date();
        const maintenanceDate = new Date(date);
        const diffDays = Math.ceil((maintenanceDate - now) / (1000 * 60 * 60 * 24));

        if (diffDays < 0) return '{{ __("Overdue") }}';
        if (diffDays <= 7) return '{{ __("Due Soon") }}';
        return '{{ __("Scheduled") }}';
    }

    function getMaintenanceStatusClass(date) {
        const now = new Date();
        const maintenanceDate = new Date(date);
        const diffDays = Math.ceil((maintenanceDate - now) / (1000 * 60 * 60 * 24));

        if (diffDays < 0) return 'text-danger';
        if (diffDays <= 7) return 'text-warning';
        return 'text-success';
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

        $('#equipment-container').prepend(alert);

        // Auto dismiss after 5 seconds
        setTimeout(function() {
            alert.alert('close');
        }, 5000);
    }
});
</script>
@endpush