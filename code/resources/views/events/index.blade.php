@extends('layouts.adminlte')

@section('title', 'Events')
@section('page-title', 'Events Management')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.admin-lte') }}">Home</a></li>
<li class="breadcrumb-item active">Events</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark">{{ __('Events Management') }}</h2>
            <p class="text-muted mb-0">{{ __('Manage scientific events, conferences, and workshops') }}</p>
        </div>
        @can('create', App\Models\Event::class)
        <a href="{{ route('events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>{{ __('Create Event') }}
        </a>
        @endcan
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('events.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="{{ __('Search events...') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">{{ __('Event Type') }}</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="conference" {{ request('type') == 'conference' ? 'selected' : '' }}>{{ __('Conference') }}</option>
                        <option value="workshop" {{ request('type') == 'workshop' ? 'selected' : '' }}>{{ __('Workshop') }}</option>
                        <option value="seminar" {{ request('type') == 'seminar' ? 'selected' : '' }}>{{ __('Seminar') }}</option>
                        <option value="training" {{ request('type') == 'training' ? 'selected' : '' }}>{{ __('Training') }}</option>
                        <option value="meeting" {{ request('type') == 'meeting' ? 'selected' : '' }}>{{ __('Meeting') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                        <option value="registration_open" {{ request('status') == 'registration_open' ? 'selected' : '' }}>{{ __('Registration Open') }}</option>
                        <option value="registration_closed" {{ request('status') == 'registration_closed' ? 'selected' : '' }}>{{ __('Registration Closed') }}</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date" class="form-label">{{ __('Date') }}</label>
                    <input type="date" class="form-control" id="date" name="date"
                           value="{{ request('date') }}">
                </div>
            </form>
        </div>
    </div>

    <!-- Results Info -->
    @if(isset($events) && $events->total() > 0)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-muted">
                {{ __('Showing :from to :to of :total events', [
                    'from' => $events->firstItem(),
                    'to' => $events->lastItem(),
                    'total' => $events->total()
                ]) }}
            </div>
            <div class="d-flex align-items-center">
                <label class="form-label mb-0 me-2">{{ __('Per page:') }}</label>
                <form method="GET" action="{{ route('events.index') }}" class="d-inline">
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

    <!-- Events Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Event') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Location') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Registrations') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events ?? [] as $event)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @php
                                                $typeColors = [
                                                    'conference' => 'primary',
                                                    'workshop' => 'success',
                                                    'seminar' => 'info',
                                                    'training' => 'warning',
                                                    'meeting' => 'secondary'
                                                ];
                                                $typeIcons = [
                                                    'conference' => 'fas fa-users',
                                                    'workshop' => 'fas fa-tools',
                                                    'seminar' => 'fas fa-presentation',
                                                    'training' => 'fas fa-graduation-cap',
                                                    'meeting' => 'fas fa-calendar'
                                                ];
                                                $color = $typeColors[$event->type] ?? 'secondary';
                                                $icon = $typeIcons[$event->type] ?? 'fas fa-calendar';
                                            @endphp
                                            <div class="rounded d-flex align-items-center justify-content-center bg-{{ $color }} text-white" style="width: 40px; height: 40px;">
                                                <i class="{{ $icon }}"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $event->title }}</div>
                                            @if($event->organizer)
                                                <small class="text-muted">{{ $event->organizer }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $typeLabels = [
                                            'conference' => __('Conference'),
                                            'workshop' => __('Workshop'),
                                            'seminar' => __('Seminar'),
                                            'training' => __('Training'),
                                            'meeting' => __('Meeting')
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $typeLabels[$event->type] ?? $event->type }}</span>
                                </td>
                                <td>
                                    @if($event->start_date)
                                        <div>
                                            <div class="fw-medium">{{ $event->start_date->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $event->start_date->format('H:i') }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">{{ __('Not set') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas {{ $event->is_virtual ? 'fa-video' : 'fa-map-marker-alt' }} text-muted me-1"></i>
                                        <span>{{ $event->location ?: __('Virtual') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'draft' => 'secondary',
                                            'published' => 'info',
                                            'registration_open' => 'success',
                                            'registration_closed' => 'warning',
                                            'completed' => 'primary',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusIcons = [
                                            'draft' => 'fas fa-file-alt',
                                            'published' => 'fas fa-eye',
                                            'registration_open' => 'fas fa-user-plus',
                                            'registration_closed' => 'fas fa-user-slash',
                                            'completed' => 'fas fa-check-circle',
                                            'cancelled' => 'fas fa-ban'
                                        ];
                                        $statusLabels = [
                                            'draft' => __('Draft'),
                                            'published' => __('Published'),
                                            'registration_open' => __('Registration Open'),
                                            'registration_closed' => __('Registration Closed'),
                                            'completed' => __('Completed'),
                                            'cancelled' => __('Cancelled')
                                        ];
                                        $statusColor = $statusColors[$event->status] ?? 'secondary';
                                        $statusIcon = $statusIcons[$event->status] ?? 'fas fa-question-circle';
                                        $statusLabel = $statusLabels[$event->status] ?? $event->status;
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">
                                        <i class="{{ $statusIcon }} me-1"></i>{{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="fw-medium">{{ $event->registrations_count ?? 0 }}</div>
                                    <small class="text-muted">
                                        / {{ $event->max_participants ?? '∞' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-outline-primary" title="{{ __('View') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('update', App\Models\Event::class)
                                            <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-outline-warning" title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @if($event->status === 'registration_open' && (!$event->max_participants || $event->registrations_count < $event->max_participants))
                                            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#registrationModal"
                                                    data-event-id="{{ $event->id }}" data-event-title="{{ $event->title }}" title="{{ __('Register') }}">
                                                <i class="fas fa-user-plus"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-calendar fa-2x mb-2 d-block"></i>
                                    @if(request()->hasAny(['search', 'type', 'status', 'date']))
                                        {{ __('No events found matching your search criteria') }}
                                    @else
                                        {{ __('No events have been added yet') }}
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
    @if(isset($events) && $events->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $events->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Event Registration Modal -->
<div class="modal fade" id="registrationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="#" id="registrationForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Event Registration') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="event_id" id="eventId">

                    <div class="d-flex align-items-center bg-light p-3 rounded mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-primary rounded d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fas fa-calendar text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="fw-bold" id="selectedEventTitle"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">{{ __('Additional Notes (Optional)') }}</label>
                        <textarea class="form-control" name="notes" id="notes" rows="3"
                                  placeholder="{{ __('Any special requirements or questions') }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const registrationModal = document.getElementById('registrationModal');

    registrationModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const eventId = button.getAttribute('data-event-id');
        const eventTitle = button.getAttribute('data-event-title');

        document.getElementById('eventId').value = eventId;
        document.getElementById('selectedEventTitle').textContent = eventTitle;

        // Set the form action with the correct event ID
        const form = document.getElementById('registrationForm');
        form.action = `/events/${eventId}/register`;
    });
});
</script>
@endpush