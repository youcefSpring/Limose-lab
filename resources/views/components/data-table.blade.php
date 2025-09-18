@props([
    'id' => 'dataTable',
    'headers' => [],
    'ajaxUrl' => '',
    'searchable' => true,
    'filterable' => false,
    'exportable' => false,
    'selectable' => false,
    'pageLength' => 15,
    'responsive' => true,
    'serverSide' => true,
    'processing' => true,
    'order' => [[0, 'asc']],
    'language' => null
])

<div class="data-table-wrapper">
    @if($filterable)
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row" id="{{ $id }}-filters">
                {{ $filters ?? '' }}
            </div>
        </div>
    </div>
    @endif

    <div class="card shadow-sm">
        @if($searchable || $exportable)
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                @if($searchable)
                <div class="d-flex align-items-center">
                    <label for="{{ $id }}-search" class="form-label mb-0 me-2">{{ __('Search:') }}</label>
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control" id="{{ $id }}-search" placeholder="{{ __('Search...') }}">
                        <button class="btn btn-outline-secondary" type="button" id="{{ $id }}-clear-search">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif

                @if($exportable)
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="{{ $id }}-export-csv">
                        <i class="fas fa-file-csv me-1"></i>{{ __('CSV') }}
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="{{ $id }}-export-excel">
                        <i class="fas fa-file-excel me-1"></i>{{ __('Excel') }}
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="{{ $id }}-export-pdf">
                        <i class="fas fa-file-pdf me-1"></i>{{ __('PDF') }}
                    </button>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table id="{{ $id }}" class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            @if($selectable)
                            <th width="30">
                                <input type="checkbox" class="form-check-input" id="{{ $id }}-select-all">
                            </th>
                            @endif
                            @foreach($headers as $header)
                            <th @if(isset($header['width'])) width="{{ $header['width'] }}" @endif
                                @if(isset($header['class'])) class="{{ $header['class'] }}" @endif>
                                {{ $header['title'] }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>

        @if($selectable)
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span id="{{ $id }}-selected-count">0</span> {{ __('selected') }}
                </div>
                <div class="btn-group" role="group">
                    {{ $bulkActions ?? '' }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#{{ $id }}').DataTable({
        processing: {{ $processing ? 'true' : 'false' }},
        serverSide: {{ $serverSide ? 'true' : 'false' }},
        responsive: {{ $responsive ? 'true' : 'false' }},
        pageLength: {{ $pageLength }},
        order: @json($order),
        @if($ajaxUrl)
        ajax: {
            url: '{{ $ajaxUrl }}',
            data: function(d) {
                // Add filter parameters
                @if($filterable)
                $('#{{ $id }}-filters input, #{{ $id }}-filters select').each(function() {
                    const name = $(this).attr('name') || $(this).attr('id');
                    const value = $(this).val();
                    if (name && value) {
                        d[name] = value;
                    }
                });
                @endif
            }
        },
        @endif
        columns: [
            @if($selectable)
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<input type="checkbox" class="form-check-input row-select" value="' + row.id + '">';
                }
            },
            @endif
            @foreach($headers as $index => $header)
            {
                data: '{{ $header['data'] ?? 'column_' . $index }}',
                @if(isset($header['orderable']))
                orderable: {{ $header['orderable'] ? 'true' : 'false' }},
                @endif
                @if(isset($header['searchable']))
                searchable: {{ $header['searchable'] ? 'true' : 'false' }},
                @endif
                @if(isset($header['render']))
                render: {!! $header['render'] !!},
                @endif
                @if(isset($header['className']))
                className: '{{ $header['className'] }}',
                @endif
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ],
        @if($language)
        language: @json($language),
        @else
        language: {
            processing: '<div class="d-flex align-items-center"><i class="fas fa-spinner fa-spin me-2"></i>{{ __("Loading...") }}</div>',
            emptyTable: '{{ __("No data available") }}',
            zeroRecords: '{{ __("No matching records found") }}',
            info: '{{ __("Showing _START_ to _END_ of _TOTAL_ entries") }}',
            infoEmpty: '{{ __("Showing 0 to 0 of 0 entries") }}',
            infoFiltered: '{{ __("(filtered from _MAX_ total entries)") }}',
            lengthMenu: '{{ __("Show _MENU_ entries per page") }}',
            search: '',
            searchPlaceholder: '{{ __("Search...") }}',
            paginate: {
                first: '{{ __("First") }}',
                last: '{{ __("Last") }}',
                next: '{{ __("Next") }}',
                previous: '{{ __("Previous") }}'
            }
        },
        @endif
        dom: @if($searchable || $exportable) 'rt<"d-flex justify-content-between align-items-center mt-3"<"d-flex align-items-center"li><"d-flex align-items-center"p>>' @else '<"d-flex justify-content-between align-items-center mb-3"l>rt<"d-flex justify-content-between align-items-center mt-3"ip>' @endif
    });

    @if($searchable)
    // Custom search
    $('#{{ $id }}-search').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('#{{ $id }}-clear-search').on('click', function() {
        $('#{{ $id }}-search').val('');
        table.search('').draw();
    });
    @endif

    @if($filterable)
    // Filter handlers
    $('#{{ $id }}-filters input, #{{ $id }}-filters select').on('change keyup', function() {
        table.draw();
    });
    @endif

    @if($selectable)
    // Select all functionality
    $('#{{ $id }}-select-all').on('change', function() {
        const isChecked = $(this).prop('checked');
        $('.row-select:visible').prop('checked', isChecked);
        updateSelectedCount();
    });

    // Individual row selection
    $(document).on('change', '.row-select', function() {
        updateSelectedCount();

        // Update select all checkbox
        const totalVisible = $('.row-select:visible').length;
        const selectedVisible = $('.row-select:visible:checked').length;

        $('#{{ $id }}-select-all').prop('checked', totalVisible > 0 && selectedVisible === totalVisible);
        $('#{{ $id }}-select-all').prop('indeterminate', selectedVisible > 0 && selectedVisible < totalVisible);
    });

    function updateSelectedCount() {
        const count = $('.row-select:checked').length;
        $('#{{ $id }}-selected-count').text(count);
    }

    // Get selected rows
    window.getSelectedRows = function() {
        return $('.row-select:checked').map(function() {
            return $(this).val();
        }).get();
    };
    @endif

    @if($exportable)
    // Export functionality
    $('#{{ $id }}-export-csv').on('click', function() {
        exportTable('csv');
    });

    $('#{{ $id }}-export-excel').on('click', function() {
        exportTable('excel');
    });

    $('#{{ $id }}-export-pdf').on('click', function() {
        exportTable('pdf');
    });

    function exportTable(format) {
        const btn = $(`#{{ $id }}-export-${format}`);
        const originalHtml = btn.html();

        btn.html('<i class="fas fa-spinner fa-spin me-1"></i>{{ __("Exporting...") }}').prop('disabled', true);

        // Get current table parameters
        const params = table.ajax.params();
        params.export_format = format;

        $.get('{{ $ajaxUrl }}', params)
            .done(function(response, status, xhr) {
                // Create download link
                const blob = new Blob([response], {
                    type: format === 'csv' ? 'text/csv' :
                          format === 'excel' ? 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' :
                          'application/pdf'
                });

                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;

                const extension = format === 'excel' ? 'xlsx' : format;
                link.setAttribute('download', `{{ $id }}-export-${new Date().toISOString().split('T')[0]}.${extension}`);

                document.body.appendChild(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);
            })
            .fail(function(xhr) {
                console.error('Export failed:', xhr);
                alert('{{ __("Export failed. Please try again.") }}');
            })
            .always(function() {
                btn.html(originalHtml).prop('disabled', false);
            });
    }
    @endif

    // Store table reference globally
    window['{{ $id }}Table'] = table;
});
</script>

<style scoped>
.data-table-wrapper .table th {
    font-weight: 600;
    background-color: var(--bs-gray-100);
    border-bottom: 2px solid var(--bs-gray-300);
    vertical-align: middle;
}

.data-table-wrapper .table td {
    vertical-align: middle;
}

.data-table-wrapper .table-hover tbody tr:hover {
    background-color: var(--bs-gray-50);
}

/* Loading overlay */
.data-table-wrapper .dataTables_processing {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid var(--bs-gray-300);
    border-radius: 0.375rem;
    padding: 1rem 1.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

/* Pagination styling */
.data-table-wrapper .dataTables_paginate .paginate_button {
    padding: 0.375rem 0.75rem;
    margin-left: -1px;
    border: 1px solid var(--bs-gray-300);
    background-color: var(--bs-white);
    color: var(--bs-primary);
    text-decoration: none;
    border-radius: 0;
}

.data-table-wrapper .dataTables_paginate .paginate_button:hover {
    background-color: var(--bs-gray-100);
    border-color: var(--bs-gray-400);
}

.data-table-wrapper .dataTables_paginate .paginate_button.current {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: var(--bs-white);
}

.data-table-wrapper .dataTables_paginate .paginate_button.disabled {
    color: var(--bs-gray-500);
    background-color: var(--bs-white);
    border-color: var(--bs-gray-300);
    cursor: not-allowed;
}

/* RTL support */
[dir="rtl"] .data-table-wrapper .table th,
[dir="rtl"] .data-table-wrapper .table td {
    text-align: right;
}

[dir="rtl"] .data-table-wrapper .dataTables_paginate {
    direction: rtl;
}
</style>