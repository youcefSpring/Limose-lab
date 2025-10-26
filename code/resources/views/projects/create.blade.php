@extends('layouts.adminlte')

@section('title', 'Add Project')
@section('page-title', 'Add New Project')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
<li class="breadcrumb-item active">Add Project</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Main Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-folder-plus mr-1"></i>
                        Create New Project
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('projects.index') }}" class="btn btn-tool" title="Back to Projects">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Basic Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="title">Project Title <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                           id="title" name="title" value="{{ old('title') }}" required
                                                           placeholder="Enter project title">
                                                    @error('title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="leader_id">Project Leader <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('leader_id') is-invalid @enderror"
                                                            id="leader_id" name="leader_id" required>
                                                        <option value="">Select Project Leader</option>
                                                        @if(isset($researchers))
                                                            @foreach($researchers as $researcher)
                                                                <option value="{{ $researcher->id }}" {{ old('leader_id') == $researcher->id ? 'selected' : '' }}>
                                                                    {{ $researcher->full_name ?? $researcher->name }} ({{ $researcher->research_domain ?? 'N/A' }})
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('leader_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status">Status <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('status') is-invalid @enderror"
                                                            id="status" name="status" required>
                                                        <option value="">Select Status</option>
                                                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                    @error('status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Project Description <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      id="description" name="description" rows="4" required
                                                      placeholder="Describe the project objectives and scope">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Timeline & Budget -->
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Timeline & Budget</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                                           id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                                    @error('start_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_date">End Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                                           id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                                    @error('end_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="budget">Project Budget (USD)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number" class="form-control @error('budget') is-invalid @enderror"
                                                       id="budget" name="budget" value="{{ old('budget') }}"
                                                       step="0.01" min="0" placeholder="0.00">
                                                @error('budget')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-4">
                                <!-- Team Members -->
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Team Members</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="members">Project Members</label>
                                            <select class="form-control @error('members') is-invalid @enderror"
                                                    id="members" name="members[]" multiple>
                                                @if(isset($researchers))
                                                    @foreach($researchers as $researcher)
                                                        <option value="{{ $researcher->id }}" {{ in_array($researcher->id, old('members', [])) ? 'selected' : '' }}>
                                                            {{ $researcher->full_name ?? $researcher->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <small class="form-text text-muted">Select team members (excluding the leader)</small>
                                            @error('members')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="card card-outline card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Additional Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="objectives">Main Objectives</label>
                                            <textarea class="form-control @error('objectives') is-invalid @enderror"
                                                      id="objectives" name="objectives" rows="3"
                                                      placeholder="List main project objectives">{{ old('objectives') }}</textarea>
                                            @error('objectives')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="proposal_file">Project Proposal</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('proposal_file') is-invalid @enderror"
                                                       id="proposal_file" name="proposal_file" accept=".pdf,.doc,.docx">
                                                <label class="custom-file-label" for="proposal_file">Choose file</label>
                                            </div>
                                            <small class="form-text text-muted">PDF, DOC, DOCX - max 10MB</small>
                                            @error('proposal_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>Create Project
                                </button>
                                <a href="{{ route('projects.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times mr-1"></i>Cancel
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">Fields marked with <span class="text-danger">*</span> are required</small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize select2 for better multi-select
    $('#members').select2({
        placeholder: 'Select team members...',
        allowClear: true,
        width: '100%'
    });

    $('#leader_id').select2({
        placeholder: 'Select project leader...',
        allowClear: true,
        width: '100%'
    });

    // Update file input label
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    // Date validation
    $('#start_date, #end_date').on('change', function() {
        const startDate = new Date($('#start_date').val());
        const endDate = new Date($('#end_date').val());

        if (startDate && endDate && startDate >= endDate) {
            toastr.warning('End date must be after start date');
            $('#end_date').focus();
        }
    });

    // Remove leader from members when selected
    $('#leader_id').on('change', function() {
        const leaderId = $(this).val();
        if (leaderId) {
            $('#members option[value="' + leaderId + '"]').prop('disabled', true);
            $('#members').val($('#members').val().filter(val => val !== leaderId));
            $('#members').trigger('change');
        } else {
            $('#members option').prop('disabled', false);
        }
        $('#members').select2('destroy').select2({
            placeholder: 'Select team members...',
            allowClear: true,
            width: '100%'
        });
    });

    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;

        // Check required fields
        $('input[required], select[required], textarea[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            toastr.error('Please fill in all required fields');
        }
    });
});
</script>
@endpush