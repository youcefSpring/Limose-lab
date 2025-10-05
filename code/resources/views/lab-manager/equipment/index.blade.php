@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('Equipment Management') }}</h1>
            <p class="text-muted mb-0">{{ __('Manage laboratory equipment and reservations') }}</p>
        </div>
        <div>
            <a href="{{ route('lab-manager.equipment.maintenance') }}" class="btn btn-warning me-2">
                <i class="fas fa-tools me-1"></i>{{ __('Maintenance') }}
            </a>
            <a href="{{ route('lab-manager.equipment.reservations') }}" class="btn btn-info me-2">
                <i class="fas fa-calendar me-1"></i>{{ __('Reservations') }}
            </a>
            <button class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>{{ __('Add Equipment') }}
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">{{ __('Search') }}</label>
                    <input type="text" class="form-control" placeholder="{{ __('Equipment name...') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Status') }}</label>
                    <select class="form-select">
                        <option value="">{{ __('All Status') }}</option>
                        <option value="available">{{ __('Available') }}</option>
                        <option value="in_use">{{ __('In Use') }}</option>
                        <option value="maintenance">{{ __('Maintenance') }}</option>
                        <option value="out_of_order">{{ __('Out of Order') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Category') }}</label>
                    <select class="form-select">
                        <option value="">{{ __('All Categories') }}</option>
                        <option value="microscopes">{{ __('Microscopes') }}</option>
                        <option value="centrifuges">{{ __('Centrifuges') }}</option>
                        <option value="analyzers">{{ __('Analyzers') }}</option>
                        <option value="other">{{ __('Other') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Location') }}</label>
                    <select class="form-select">
                        <option value="">{{ __('All Locations') }}</option>
                        <option value="lab_a">{{ __('Lab A') }}</option>
                        <option value="lab_b">{{ __('Lab B') }}</option>
                        <option value="storage">{{ __('Storage') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>{{ __('Filter') }}
                        </button>
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-1"></i>{{ __('Reset') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Equipment Grid -->
    <div class="row">
        <!-- Equipment Card 1 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card equipment-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('High-Power Microscope') }}</h6>
                    <span class="badge bg-success">{{ __('Available') }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Model:') }}</small><br>
                            <strong>Olympus BX53</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('Location:') }}</small><br>
                            <strong>Lab A - Room 101</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Last Maintenance:') }}</small><br>
                            <strong>2 weeks ago</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('Next Due:') }}</small><br>
                            <strong>6 months</strong>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary flex-fill">
                            <i class="fas fa-calendar me-1"></i>{{ __('Reserve') }}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Card 2 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card equipment-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('Centrifuge Unit') }}</h6>
                    <span class="badge bg-danger">{{ __('In Use') }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Model:') }}</small><br>
                            <strong>Eppendorf 5810R</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('Location:') }}</small><br>
                            <strong>Lab B - Room 205</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Current User:') }}</small><br>
                            <strong>Dr. Smith</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('Available:') }}</small><br>
                            <strong>2:30 PM</strong>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-secondary flex-fill" disabled>
                            <i class="fas fa-calendar me-1"></i>{{ __('Reserved') }}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Card 3 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card equipment-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('PCR Machine') }}</h6>
                    <span class="badge bg-warning">{{ __('Maintenance') }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Model:') }}</small><br>
                            <strong>Bio-Rad T100</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('Location:') }}</small><br>
                            <strong>Lab A - Room 103</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Issue:') }}</small><br>
                            <strong>Calibration needed</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('ETA:') }}</small><br>
                            <strong>Tomorrow</strong>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-warning flex-fill">
                            <i class="fas fa-tools me-1"></i>{{ __('Maintenance') }}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Card 4 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card equipment-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('Spectrophotometer') }}</h6>
                    <span class="badge bg-success">{{ __('Available') }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Model:') }}</small><br>
                            <strong>Thermo NanoDrop</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('Location:') }}</small><br>
                            <strong>Lab B - Room 210</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Last Used:') }}</small><br>
                            <strong>3 hours ago</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('Usage Today:') }}</small><br>
                            <strong>4 sessions</strong>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary flex-fill">
                            <i class="fas fa-calendar me-1"></i>{{ __('Reserve') }}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Card 5 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card equipment-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('Autoclave') }}</h6>
                    <span class="badge bg-success">{{ __('Available') }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Model:') }}</small><br>
                            <strong>Tuttnauer 3870EA</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('Location:') }}</small><br>
                            <strong>Sterilization Room</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Cycle Time:') }}</small><br>
                            <strong>45 minutes</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('Capacity:') }}</small><br>
                            <strong>Large Load</strong>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary flex-fill">
                            <i class="fas fa-calendar me-1"></i>{{ __('Reserve') }}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Card 6 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card equipment-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('Incubator') }}</h6>
                    <span class="badge bg-info">{{ __('Occupied') }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Model:') }}</small><br>
                            <strong>Thermo Heratherm</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('Location:') }}</small><br>
                            <strong>Cell Culture Room</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">{{ __('Temperature:') }}</small><br>
                            <strong>37°C</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">{{ __('Time Remaining:') }}</small><br>
                            <strong>2 days</strong>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-info flex-fill">
                            <i class="fas fa-thermometer-half me-1"></i>{{ __('Monitor') }}
                        </button>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        <nav>
            <ul class="pagination">
                <li class="page-item disabled">
                    <span class="page-link">{{ __('Previous') }}</span>
                </li>
                <li class="page-item active">
                    <span class="page-link">1</span>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">{{ __('Next') }}</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<style>
.equipment-card {
    transition: transform 0.2s ease-in-out;
}

.equipment-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.badge {
    font-size: 0.75em;
}
</style>
@endsection