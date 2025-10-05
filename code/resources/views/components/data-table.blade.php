@props([
    'id' => 'dataTable',
    'headers' => [],
    'data' => [],
    'searchable' => true,
    'filterable' => false,
    'exportable' => false,
    'selectable' => false,
    'sortable' => true,
    'responsive' => true,
    'currentPage' => 1,
    'totalPages' => 1,
    'perPage' => 15,
    'total' => 0,
    'searchQuery' => '',
    'sortBy' => '',
    'sortDirection' => 'asc',
    'baseUrl' => '',
])

<div class="data-table-wrapper">
    @if($filterable)
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ $baseUrl }}" class="row g-3">
                <input type="hidden" name="page" value="1">
                {{ $filters ?? '' }}
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i>{{ __('Apply Filters') }}
                    </button>
                </div>
                <div class="col-auto">
                    <a href="{{ $baseUrl }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>{{ __('Clear') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
    @endif

    <div class="card shadow-sm">
        @if($searchable || $exportable)
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                @if($searchable)
                <form method="GET" action="{{ $baseUrl }}" class="d-flex align-items-center">
                    <label for="{{ $id }}-search" class="form-label mb-0 me-2">{{ __('Search:') }}</label>
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control" id="{{ $id }}-search" name="search"
                               value="{{ $searchQuery }}" placeholder="{{ __('Search...') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if($searchQuery)
                        <a href="{{ $baseUrl }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </form>
                @endif

                @if($exportable)
                <div class="btn-group" role="group">
                    <a href="{{ $baseUrl }}?export=csv&{{ http_build_query(request()->except('export')) }}"
                       class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-file-csv me-1"></i>{{ __('CSV') }}
                    </a>
                    <a href="{{ $baseUrl }}?export=excel&{{ http_build_query(request()->except('export')) }}"
                       class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-file-excel me-1"></i>{{ __('Excel') }}
                    </a>
                    <a href="{{ $baseUrl }}?export=pdf&{{ http_build_query(request()->except('export')) }}"
                       class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-file-pdf me-1"></i>{{ __('PDF') }}
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="card-body">
            @if($total > 0)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-muted">
                        {{ __('Showing :from to :to of :total results', [
                            'from' => ($currentPage - 1) * $perPage + 1,
                            'to' => min($currentPage * $perPage, $total),
                            'total' => $total
                        ]) }}
                    </div>
                    @if($total > $perPage)
                    <form method="GET" action="{{ $baseUrl }}" class="d-flex align-items-center">
                        @foreach(request()->except('per_page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <label class="form-label mb-0 me-2">{{ __('Show:') }}</label>
                        <select name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </form>
                    @endif
                </div>
            @endif

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
                                @if($sortable && isset($header['sortable']) && $header['sortable'])
                                    <a href="{{ $baseUrl }}?{{ http_build_query(array_merge(request()->all(), [
                                        'sort' => $header['field'],
                                        'direction' => $sortBy == $header['field'] && $sortDirection == 'asc' ? 'desc' : 'asc'
                                    ])) }}" class="text-decoration-none text-dark">
                                        {{ $header['title'] }}
                                        @if($sortBy == $header['field'])
                                            <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                        @endif
                                    </a>
                                @else
                                    {{ $header['title'] }}
                                @endif
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                        <tr>
                            @if($selectable)
                            <td>
                                <input type="checkbox" class="form-check-input row-select"
                                       value="{{ $row->id ?? $loop->index }}">
                            </td>
                            @endif

                            {{ $slot }}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($headers) + ($selectable ? 1 : 0) }}" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                {{ __('No data available') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($selectable && count($data) > 0)
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

        @if($totalPages > 1)
        <div class="card-footer bg-light">
            <nav aria-label="Table pagination">
                <ul class="pagination pagination-sm justify-content-center mb-0">
                    {{-- Previous Page Link --}}
                    @if($currentPage > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $baseUrl }}?{{ http_build_query(array_merge(request()->all(), ['page' => $currentPage - 1])) }}">
                                {{ __('Previous') }}
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">{{ __('Previous') }}</span>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $start = max(1, $currentPage - 2);
                        $end = min($totalPages, $currentPage + 2);
                    @endphp

                    @if($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $baseUrl }}?{{ http_build_query(array_merge(request()->all(), ['page' => 1])) }}">1</a>
                        </li>
                        @if($start > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for($i = $start; $i <= $end; $i++)
                        @if($i == $currentPage)
                            <li class="page-item active">
                                <span class="page-link">{{ $i }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $baseUrl }}?{{ http_build_query(array_merge(request()->all(), ['page' => $i])) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor

                    @if($end < $totalPages)
                        @if($end < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $baseUrl }}?{{ http_build_query(array_merge(request()->all(), ['page' => $totalPages])) }}">{{ $totalPages }}</a>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if($currentPage < $totalPages)
                        <li class="page-item">
                            <a class="page-link" href="{{ $baseUrl }}?{{ http_build_query(array_merge(request()->all(), ['page' => $currentPage + 1])) }}">
                                {{ __('Next') }}
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">{{ __('Next') }}</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
        @endif
    </div>
</div>

@if($selectable)
<script>
$(document).ready(function() {
    // Select all functionality (client-side only)
    $('#{{ $id }}-select-all').on('change', function() {
        const isChecked = $(this).prop('checked');
        $('.row-select').prop('checked', isChecked);
        updateSelectedCount();
    });

    // Individual row selection
    $(document).on('change', '.row-select', function() {
        updateSelectedCount();

        // Update select all checkbox
        const total = $('.row-select').length;
        const selected = $('.row-select:checked').length;

        $('#{{ $id }}-select-all').prop('checked', total > 0 && selected === total);
        $('#{{ $id }}-select-all').prop('indeterminate', selected > 0 && selected < total);
    });

    function updateSelectedCount() {
        const count = $('.row-select:checked').length;
        $('#{{ $id }}-selected-count').text(count);
    }

    // Get selected rows (for bulk actions)
    window.getSelectedRows = function() {
        return $('.row-select:checked').map(function() {
            return $(this).val();
        }).get();
    };
});
</script>
@endif

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