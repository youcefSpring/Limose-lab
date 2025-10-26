@extends('layouts.adminlte')])

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="h3 fw-bold text-dark">{{ __('Equipment Details') }}</h2>
                <p class="text-muted mb-0">{{ __('View and manage equipment information') }}</p>
            </div>
        </div>
        <div class="btn-group">
            @can('update', $equipment)
            <a href="{{ route('equipment.edit', $equipment) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>{{ __('Edit') }}
            </a>
            @endcan
            @if($equipment->status === 'operational')
            <a href="{{ route('equipment.reserve', $equipment) }}" class="btn btn-success">
                <i class="fas fa-calendar-plus me-2"></i>{{ __('Reserve') }}
            </a>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Equipment Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div>
                            <h3 class="h6 mb-0">{{ $equipment->name }}</h3>
                            <div class="small text-muted">{{ __('Equipment Information') }}</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">{{ __('Model') }}</label>
                                <div class="fw-medium">{{ $equipment->model ?? __('Not specified') }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">{{ __('Manufacturer') }}</label>
                                <div class="fw-medium">{{ $equipment->manufacturer ?? __('Not specified') }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">{{ __('Type') }}</label>
                                <div class="fw-medium">{{ $equipment->type ?? __('Not specified') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small">{{ __('Location') }}</label>
                                <div class="fw-medium">{{ $equipment->location ?? __('Not specified') }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">{{ __('Status') }}</label>
                                <div>
                                    <span class="badge bg-{{ $equipment->status === 'operational' ? 'success' : ($equipment->status === 'maintenance' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($equipment->status ?? 'unknown') }}
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">{{ __('Serial Number') }}</label>
                                <div class="fw-medium">{{ $equipment->serial_number ?? __('Not specified') }}</div>
                            </div>
                        </div>
                    </div>

                    @if($equipment->description)
                    <div class="mt-3">
                        <label class="form-label text-muted small">{{ __('Description') }}</label>
                        <div class="fw-medium">{{ $equipment->description }}</div>
                    </div>
                    @endif

                    @if($equipment->specifications)
                    <div class="mt-3">
                        <label class="form-label text-muted small">{{ __('Specifications') }}</label>
                        <div class="fw-medium">{{ $equipment->specifications }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Usage Statistics -->
            @if(isset($statistics))
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>{{ __('Usage Statistics') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ $statistics['total_reservations'] ?? 0 }}</h4>
                                <div class="small text-muted">{{ __('Total Reservations') }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-end">
                                <h4 class="text-success mb-1">{{ $statistics['active_reservations'] ?? 0 }}</h4>
                                <div class="small text-muted">{{ __('Active Reservations') }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-end">
                                <h4 class="text-warning mb-1">{{ $statistics['maintenance_records'] ?? 0 }}</h4>
                                <div class="small text-muted">{{ __('Maintenance Records') }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-info mb-1">{{ $statistics['utilization_rate'] ?? 0 }}%</h4>
                            <div class="small text-muted">{{ __('Utilization Rate') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Reservations -->
            @if($equipment->reservations && $equipment->reservations->count() > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar me-2"></i>{{ __('Recent Reservations') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Researcher') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Purpose') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($equipment->reservations->take(5) as $reservation)
                                <tr>
                                    <td>
                                        @if($reservation->researcher)
                                        <a href="{{ route('researchers.show', $reservation->researcher) }}" class="text-decoration-none">
                                            {{ $reservation->researcher->first_name }} {{ $reservation->researcher->last_name }}
                                        </a>
                                        @else
                                        {{ __('Unknown') }}
                                        @endif
                                    </td>
                                    <td>{{ $reservation->start_datetime ? $reservation->start_datetime->format('M d, Y H:i') : __('Not set') }}</td>
                                    <td>{{ $reservation->end_datetime ? $reservation->end_datetime->format('M d, Y H:i') : __('Not set') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $reservation->status === 'confirmed' ? 'success' : ($reservation->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($reservation->status ?? 'unknown') }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($reservation->purpose ?? __('No purpose'), 50) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('equipment.reservations', ['equipment_id' => $equipment->id]) }}" class="btn btn-outline-primary btn-sm">
                            {{ __('View All Reservations') }}
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>{{ __('Quick Actions') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($equipment->status === 'operational')
                        <a href="{{ route('equipment.reserve', $equipment) }}" class="btn btn-success">
                            <i class="fas fa-calendar-plus me-2"></i>{{ __('Make Reservation') }}
                        </a>
                        @endif

                        <a href="{{ route('equipment.calendar', $equipment) }}" class="btn btn-outline-primary">
                            <i class="fas fa-calendar-alt me-2"></i>{{ __('View Calendar') }}
                        </a>

                        @can('update', $equipment)
                        <a href="{{ route('equipment.maintenance', $equipment) }}" class="btn btn-outline-warning">
                            <i class="fas fa-wrench me-2"></i>{{ __('Maintenance Log') }}
                        </a>
                        @endcan

                        <a href="{{ route('equipment.usage', $equipment) }}" class="btn btn-outline-info">
                            <i class="fas fa-chart-line me-2"></i>{{ __('Usage Reports') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Equipment Details -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>{{ __('Additional Information') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">{{ __('Purchase Date') }}</label>
                        <div class="fw-medium">{{ $equipment->purchase_date ? $equipment->purchase_date->format('M d, Y') : __('Not specified') }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small">{{ __('Warranty Expiry') }}</label>
                        <div class="fw-medium">{{ $equipment->warranty_expiry ? $equipment->warranty_expiry->format('M d, Y') : __('Not specified') }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small">{{ __('Last Maintenance') }}</label>
                        <div class="fw-medium">
                            @if($equipment->maintenanceRecords && $equipment->maintenanceRecords->count() > 0)
                                {{ $equipment->maintenanceRecords->first()->performed_at->format('M d, Y') }}
                            @else
                                {{ __('No maintenance records') }}
                            @endif
                        </div>
                    </div>

                    @if($equipment->responsible_person)
                    <div class="mb-3">
                        <label class="form-label text-muted small">{{ __('Responsible Person') }}</label>
                        <div class="fw-medium">{{ $equipment->responsible_person }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection