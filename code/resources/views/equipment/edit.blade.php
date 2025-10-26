@extends('layouts.adminlte')])

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('equipment.show', $equipment) }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Edit Equipment') }}</h2>
            <p class="text-muted mb-0">{{ __('Update equipment information') }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('equipment.update', $equipment) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                                       id="name" name="name" value="{{ old('name', $equipment->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="model" class="form-label">{{ __('Model') }}</label>
                                <input type="text" class="form-control @error('model') is-invalid @enderror"
                                       id="model" name="model" value="{{ old('model', $equipment->model) }}">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="serial_number" class="form-label">{{ __('Serial Number') }}</label>
                                <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                                       id="serial_number" name="serial_number" value="{{ old('serial_number', $equipment->serial_number) }}">
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="">{{ __('Select a category') }}</option>
                                    <option value="analytical" {{ old('category', $equipment->category) == 'analytical' ? 'selected' : '' }}>{{ __('Analytical') }}</option>
                                    <option value="microscopy" {{ old('category', $equipment->category) == 'microscopy' ? 'selected' : '' }}>{{ __('Microscopy') }}</option>
                                    <option value="spectroscopy" {{ old('category', $equipment->category) == 'spectroscopy' ? 'selected' : '' }}>{{ __('Spectroscopy') }}</option>
                                    <option value="chromatography" {{ old('category', $equipment->category) == 'chromatography' ? 'selected' : '' }}>{{ __('Chromatography') }}</option>
                                    <option value="safety" {{ old('category', $equipment->category) == 'safety' ? 'selected' : '' }}>{{ __('Safety') }}</option>
                                    <option value="general" {{ old('category', $equipment->category) == 'general' ? 'selected' : '' }}>{{ __('General') }}</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="3">{{ old('description', $equipment->description) }}</textarea>
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
                                       id="location" name="location" value="{{ old('location', $equipment->location) }}" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="operational" {{ old('status', $equipment->status) == 'operational' ? 'selected' : '' }}>{{ __('Operational') }}</option>
                                    <option value="maintenance" {{ old('status', $equipment->status) == 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                                    <option value="out_of_order" {{ old('status', $equipment->status) == 'out_of_order' ? 'selected' : '' }}>{{ __('Out of Order') }}</option>
                                    <option value="reserved" {{ old('status', $equipment->status) == 'reserved' ? 'selected' : '' }}>{{ __('Reserved') }}</option>
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
                                       id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $equipment->purchase_date ? $equipment->purchase_date->format('Y-m-d') : '') }}">
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="purchase_price" class="form-label">{{ __('Purchase Price') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror"
                                           id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $equipment->purchase_price) }}">
                                    @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="supplier" class="form-label">{{ __('Supplier') }}</label>
                                <input type="text" class="form-control @error('supplier') is-invalid @enderror"
                                       id="supplier" name="supplier" value="{{ old('supplier', $equipment->supplier) }}">
                                @error('supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="warranty_expiry" class="form-label">{{ __('Warranty Expiry') }}</label>
                                <input type="date" class="form-control @error('warranty_expiry') is-invalid @enderror"
                                       id="warranty_expiry" name="warranty_expiry" value="{{ old('warranty_expiry', $equipment->warranty_expiry ? $equipment->warranty_expiry->format('Y-m-d') : '') }}">
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
                                      placeholder="{{ __('Provide detailed instructions on how to use this equipment safely and effectively') }}">{{ old('usage_instructions', $equipment->usage_instructions) }}</textarea>
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
                                       id="maintenance_interval" name="maintenance_interval" value="{{ old('maintenance_interval', $equipment->maintenance_interval) }}">
                                <div class="form-text">{{ __('How often should this equipment be maintained?') }}</div>
                                @error('maintenance_interval')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="next_maintenance" class="form-label">{{ __('Next Maintenance Date') }}</label>
                                <input type="date" class="form-control @error('next_maintenance') is-invalid @enderror"
                                       id="next_maintenance" name="next_maintenance" value="{{ old('next_maintenance', $equipment->next_maintenance ? $equipment->next_maintenance->format('Y-m-d') : '') }}">
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
                            <i class="fas fa-save me-2"></i>{{ __('Update Equipment') }}
                        </button>
                        <a href="{{ route('equipment.show', $equipment) }}" class="btn btn-outline-secondary w-100 mb-3">
                            {{ __('Cancel') }}
                        </a>
                        @can('delete', App\Models\Equipment::class)
                        <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>{{ __('Delete Equipment') }}
                        </button>
                        @endcan
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
                                @if($equipment->image_url)
                                    <img src="{{ $equipment->image_url }}" class="img-fluid rounded" style="max-width: 100%; max-height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-camera fa-3x text-muted"></i>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($equipment->image_url)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remove_image" name="remove_image" value="1">
                                <label class="form-check-label text-danger" for="remove_image">
                                    {{ __('Remove current image') }}
                                </label>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Quick Stats') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="small">{{ __('Total Reservations') }}</span>
                            <span class="badge bg-primary">{{ $equipment->reservations_count ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="small">{{ __('Maintenance Count') }}</span>
                            <span class="badge bg-warning">{{ $equipment->maintenance_count ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small">{{ __('Last Updated') }}</span>
                            <span class="small text-muted">{{ $equipment->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Delete Confirmation Modal -->
@can('delete', App\Models\Equipment::class)
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
                        <small class="text-muted">{{ __('This action cannot be undone and will remove all associated reservations and maintenance records.') }}</small>
                    </div>
                </div>
                <div class="fw-bold">{{ $equipment->name }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form method="POST" action="{{ route('equipment.destroy', $equipment) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const removeCheckbox = document.getElementById('remove_image');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" style="max-width: 100%; max-height: 100%; object-fit: cover;">`;
        };

        reader.readAsDataURL(input.files[0]);

        // Uncheck remove image checkbox when new image is selected
        if (removeCheckbox) {
            removeCheckbox.checked = false;
        }
    } else {
        // Reset to original state if no file selected
        @if($equipment->image_url)
            preview.innerHTML = `<img src="{{ $equipment->image_url }}" class="img-fluid rounded" style="max-width: 100%; max-height: 100%; object-fit: cover;">`;
        @else
            preview.innerHTML = '<i class="fas fa-camera fa-3x text-muted"></i>';
        @endif
    }
}

// Handle remove image checkbox
document.addEventListener('DOMContentLoaded', function() {
    const removeCheckbox = document.getElementById('remove_image');
    const preview = document.getElementById('imagePreview');

    if (removeCheckbox) {
        removeCheckbox.addEventListener('change', function() {
            if (this.checked) {
                preview.innerHTML = '<i class="fas fa-camera fa-3x text-muted"></i>';
            } else {
                preview.innerHTML = `<img src="{{ $equipment->image_url }}" class="img-fluid rounded" style="max-width: 100%; max-height: 100%; object-fit: cover;">`;
            }
        });
    }
});
</script>
@endpush