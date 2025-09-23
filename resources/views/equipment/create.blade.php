@extends('layouts.app', ['title' => __('Add Equipment')])

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Add Equipment') }}</h2>
            <p class="text-muted mb-0">{{ __('Register new laboratory equipment') }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('equipment.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Main Form -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>{{ __('Basic Information') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">{{ __('Equipment Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="model" class="form-label">{{ __('Model') }}</label>
                                <input type="text" class="form-control @error('model') is-invalid @enderror"
                                       id="model" name="model" value="{{ old('model') }}">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="serial_number" class="form-label">{{ __('Serial Number') }}</label>
                                <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                                       id="serial_number" name="serial_number" value="{{ old('serial_number') }}">
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="">{{ __('Select a category') }}</option>
                                    <option value="analytical" {{ old('category') == 'analytical' ? 'selected' : '' }}>{{ __('Analytical') }}</option>
                                    <option value="microscopy" {{ old('category') == 'microscopy' ? 'selected' : '' }}>{{ __('Microscopy') }}</option>
                                    <option value="spectroscopy" {{ old('category') == 'spectroscopy' ? 'selected' : '' }}>{{ __('Spectroscopy') }}</option>
                                    <option value="chromatography" {{ old('category') == 'chromatography' ? 'selected' : '' }}>{{ __('Chromatography') }}</option>
                                    <option value="safety" {{ old('category') == 'safety' ? 'selected' : '' }}>{{ __('Safety') }}</option>
                                    <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>{{ __('General') }}</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location and Status -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ __('Location and Status') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">{{ __('Location') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                       id="location" name="location" value="{{ old('location') }}" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="operational" {{ old('status', 'operational') == 'operational' ? 'selected' : '' }}>{{ __('Operational') }}</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                                    <option value="out_of_order" {{ old('status') == 'out_of_order' ? 'selected' : '' }}>{{ __('Out of Order') }}</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase and Financial Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-dollar-sign me-2"></i>{{ __('Purchase Information') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="purchase_date" class="form-label">{{ __('Purchase Date') }}</label>
                                <input type="date" class="form-control @error('purchase_date') is-invalid @enderror"
                                       id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="purchase_price" class="form-label">{{ __('Purchase Price') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror"
                                           id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}">
                                    @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="supplier" class="form-label">{{ __('Supplier') }}</label>
                                <input type="text" class="form-control @error('supplier') is-invalid @enderror"
                                       id="supplier" name="supplier" value="{{ old('supplier') }}">
                                @error('supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="warranty_expiry" class="form-label">{{ __('Warranty Expiry') }}</label>
                                <input type="date" class="form-control @error('warranty_expiry') is-invalid @enderror"
                                       id="warranty_expiry" name="warranty_expiry" value="{{ old('warranty_expiry') }}">
                                @error('warranty_expiry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Instructions -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-book-open me-2"></i>{{ __('Usage Instructions') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="usage_instructions" class="form-label">{{ __('Usage Instructions') }}</label>
                            <textarea class="form-control @error('usage_instructions') is-invalid @enderror"
                                      id="usage_instructions" name="usage_instructions" rows="6"
                                      placeholder="{{ __('Provide detailed instructions on how to use this equipment safely and effectively') }}">{{ old('usage_instructions') }}</textarea>
                            <div class="form-text">{{ __('Provide detailed instructions on how to use this equipment safely and effectively') }}</div>
                            @error('usage_instructions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Maintenance Schedule -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-check me-2"></i>{{ __('Maintenance Schedule') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="maintenance_interval" class="form-label">{{ __('Maintenance Interval (days)') }}</label>
                                <input type="number" class="form-control @error('maintenance_interval') is-invalid @enderror"
                                       id="maintenance_interval" name="maintenance_interval" value="{{ old('maintenance_interval') }}">
                                <div class="form-text">{{ __('How often should this equipment be maintained?') }}</div>
                                @error('maintenance_interval')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="next_maintenance" class="form-label">{{ __('Next Maintenance Date') }}</label>
                                <input type="date" class="form-control @error('next_maintenance') is-invalid @enderror"
                                       id="next_maintenance" name="next_maintenance" value="{{ old('next_maintenance') }}">
                                @error('next_maintenance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Save Actions -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Actions') }}</h5>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="fas fa-save me-2"></i>{{ __('Save Equipment') }}
                        </button>
                        <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary w-100">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>

                <!-- Equipment Image -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Equipment Image') }}</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div id="imagePreview" class="d-flex align-items-center justify-content-center bg-light rounded" style="width: 150px; height: 150px; margin: 0 auto;">
                                <i class="fas fa-camera fa-3x text-muted"></i>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lightbulb me-2"></i>{{ __('Tips') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <small class="text-muted">{{ __('Provide detailed usage instructions to help users operate the equipment safely') }}</small>
                            </li>
                            <li class="mb-2">
                                <small class="text-muted">{{ __('Set up regular maintenance schedules to ensure equipment longevity') }}</small>
                            </li>
                            <li>
                                <small class="text-muted">{{ __('Include warranty information for future reference') }}</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" style="max-width: 100%; max-height: 100%; object-fit: cover;">`;
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = '<i class="fas fa-camera fa-3x text-muted"></i>';
    }
}
</script>
@endpush