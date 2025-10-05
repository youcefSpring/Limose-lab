@extends('layouts.app', ['title' => __('Equipment Management')])

@section('content')
<div class="container-fluid">
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
            <form method="GET" action="{{ route('equipment.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="{{ __('Search equipment...') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">{{ __('Category') }}</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">{{ __('All Categories') }}</option>
                        <option value="analytical" {{ request('category') == 'analytical' ? 'selected' : '' }}>{{ __('Analytical') }}</option>
                        <option value="microscopy" {{ request('category') == 'microscopy' ? 'selected' : '' }}>{{ __('Microscopy') }}</option>
                        <option value="spectroscopy" {{ request('category') == 'spectroscopy' ? 'selected' : '' }}>{{ __('Spectroscopy') }}</option>
                        <option value="chromatography" {{ request('category') == 'chromatography' ? 'selected' : '' }}>{{ __('Chromatography') }}</option>
                        <option value="safety" {{ request('category') == 'safety' ? 'selected' : '' }}>{{ __('Safety') }}</option>
                        <option value="general" {{ request('category') == 'general' ? 'selected' : '' }}>{{ __('General') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="operational" {{ request('status') == 'operational' ? 'selected' : '' }}>{{ __('Operational') }}</option>
                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                        <option value="out_of_order" {{ request('status') == 'out_of_order' ? 'selected' : '' }}>{{ __('Out of Order') }}</option>
                        <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>{{ __('Reserved') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="location" class="form-label">{{ __('Location') }}</label>
                    <input type="text" class="form-control" id="location" name="location"
                           value="{{ request('location') }}" placeholder="{{ __('Filter by location...') }}">
                </div>
            </form>
        </div>
    </div>

    <!-- Results Info -->
    @if(isset($equipment) && $equipment->total() > 0)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted">
                {{ __('Showing :from to :to of :total equipment', [
                    'from' => $equipment->firstItem(),
                    'to' => $equipment->lastItem(),
                    'total' => $equipment->total()
                ]) }}
            </div>
            <div class="d-flex align-items-center">
                <label class="form-label mb-0 me-2">{{ __('Per page:') }}</label>
                <form method="GET" action="{{ route('equipment.index') }}" class="d-inline">
                    @foreach(request()->except('per_page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
            </div>
        </div>
    @endif

    <!-- Equipment Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
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
                        @forelse($equipment ?? [] as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @php
                                                $categoryColors = [
                                                    'analytical' => 'primary',
                                                    'microscopy' => 'success',
                                                    'spectroscopy' => 'info',
                                                    'chromatography' => 'warning',
                                                    'safety' => 'danger',
                                                    'general' => 'secondary'
                                                ];
                                                $color = $categoryColors[$item->category] ?? 'secondary';
                                            @endphp
                                            <div class="rounded d-flex align-items-center justify-content-center bg-{{ $color }} text-white" style="width: 40px; height: 40px;">
                                                <i class="fas fa-tools"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $item->name }}</div>
                                            @if($item->model)
                                                <small class="text-muted">{{ $item->model }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $categoryLabels = [
                                            'analytical' => __('Analytical'),
                                            'microscopy' => __('Microscopy'),
                                            'spectroscopy' => __('Spectroscopy'),
                                            'chromatography' => __('Chromatography'),
                                            'safety' => __('Safety'),
                                            'general' => __('General')
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $categoryLabels[$item->category] ?? $item->category }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'operational' => 'success',
                                            'maintenance' => 'warning',
                                            'out_of_order' => 'danger',
                                            'reserved' => 'primary'
                                        ];
                                        $statusIcons = [
                                            'operational' => 'fas fa-check-circle',
                                            'maintenance' => 'fas fa-tools',
                                            'out_of_order' => 'fas fa-times-circle',
                                            'reserved' => 'fas fa-calendar-check'
                                        ];
                                        $statusLabels = [
                                            'operational' => __('Operational'),
                                            'maintenance' => __('Maintenance'),
                                            'out_of_order' => __('Out of Order'),
                                            'reserved' => __('Reserved')
                                        ];
                                        $statusColor = $statusColors[$item->status] ?? 'secondary';
                                        $statusIcon = $statusIcons[$item->status] ?? 'fas fa-question-circle';
                                        $statusLabel = $statusLabels[$item->status] ?? $item->status;
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">
                                        <i class="{{ $statusIcon }} me-1"></i>{{ $statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                        {{ $item->location }}
                                    </div>
                                </td>
                                <td>
                                    @if($item->next_maintenance)
                                        @php
                                            $now = now();
                                            $maintenanceDate = \Carbon\Carbon::parse($item->next_maintenance);
                                            $diffDays = $maintenanceDate->diffInDays($now, false);
                                            if ($diffDays < 0) {
                                                $status = __('Overdue');
                                                $statusClass = 'text-danger';
                                            } elseif ($diffDays <= 7) {
                                                $status = __('Due Soon');
                                                $statusClass = 'text-warning';
                                            } else {
                                                $status = __('Scheduled');
                                                $statusClass = 'text-success';
                                            }
                                        @endphp
                                        <div>
                                            <div class="fw-medium">{{ $maintenanceDate->format('M d, Y') }}</div>
                                            <div class="small {{ $statusClass }}">{{ $status }}</div>
                                        </div>
                                    @else
                                        <span class="text-muted">{{ __('Not scheduled') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('equipment.show', $item) }}" class="btn btn-sm btn-outline-primary" title="{{ __('View') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('update', App\Models\Equipment::class)
                                            <a href="{{ route('equipment.edit', $item) }}" class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @if($item->status === 'operational')
                                            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#reservationModal"
                                                    data-equipment-id="{{ $item->id }}" data-equipment-name="{{ $item->name }}" data-equipment-model="{{ $item->model }}" title="{{ __('Reserve') }}">
                                                <i class="fas fa-calendar-plus"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-tools fa-2x mb-2 d-block"></i>
                                    @if(request()->hasAny(['search', 'category', 'status', 'location']))
                                        {{ __('No equipment found matching your search criteria') }}
                                    @else
                                        {{ __('No equipment has been added yet') }}
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if(isset($equipment) && $equipment->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $equipment->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Equipment Reservation Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('equipment.reservations.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Reserve Equipment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="equipment_id" id="equipmentId">

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
                            <label for="start_date" class="form-label">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="start_date" id="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">{{ __('End Date') }} <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="end_date" id="end_date" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="purpose" class="form-label">{{ __('Purpose') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="purpose" id="purpose" rows="3" placeholder="{{ __('Describe the purpose of this reservation...') }}" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Reserve') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const reservationModal = document.getElementById('reservationModal');

    reservationModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const equipmentId = button.getAttribute('data-equipment-id');
        const equipmentName = button.getAttribute('data-equipment-name');
        const equipmentModel = button.getAttribute('data-equipment-model');

        document.getElementById('equipmentId').value = equipmentId;
        document.getElementById('selectedEquipmentName').textContent = equipmentName;
        document.getElementById('selectedEquipmentModel').textContent = equipmentModel || '';
    });
});
</script>
@endpush