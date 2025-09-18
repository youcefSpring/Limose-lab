<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Requests\Event\RegisterEventRequest;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ) {}

    /**
     * Display a listing of events
     * GET /api/v1/events
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'search', 'type', 'status', 'upcoming', 'organizer_id',
            'date_from', 'date_to'
        ]);
        $perPage = min($request->input('per_page', 15), 100);

        $events = $this->eventService->getEvents($filters, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'events' => $events->items()->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->getTitle(),
                        'description' => $event->getDescription(),
                        'type' => $event->type,
                        'start_date' => $event->start_date,
                        'end_date' => $event->end_date,
                        'start_time' => $event->start_time,
                        'end_time' => $event->end_time,
                        'location' => $event->getLocation(),
                        'max_participants' => $event->max_participants,
                        'registered_count' => $event->registrations()->count(),
                        'available_spots' => $event->available_spots,
                        'registration_deadline' => $event->registration_deadline,
                        'status' => $event->status,
                        'is_registration_open' => $event->isRegistrationOpen(),
                        'is_full' => $event->isFull(),
                        'organizer' => [
                            'id' => $event->organizer->id,
                            'name' => $event->organizer->name,
                        ],
                        'created_at' => $event->created_at,
                    ];
                }),
                'pagination' => [
                    'current_page' => $events->currentPage(),
                    'total_pages' => $events->lastPage(),
                    'total_items' => $events->total(),
                    'per_page' => $events->perPage(),
                    'has_next_page' => $events->hasMorePages(),
                    'has_previous_page' => $events->currentPage() > 1,
                ]
            ]
        ]);
    }

    /**
     * Store a newly created event
     * POST /api/v1/events
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        $event = $this->eventService->createEvent($request->validated(), auth()->user());

        return response()->json([
            'status' => 'success',
            'data' => [
                'event' => [
                    'id' => $event->id,
                    'title' => $event->getTitle(),
                    'description' => $event->getDescription(),
                    'type' => $event->type,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'location' => $event->getLocation(),
                    'status' => $event->status,
                    'organizer' => [
                        'id' => $event->organizer->id,
                        'name' => $event->organizer->name,
                    ],
                ]
            ],
            'message' => 'Event created successfully'
        ], 201);
    }

    /**
     * Display the specified event
     * GET /api/v1/events/{id}
     */
    public function show(Event $event): JsonResponse
    {
        $statistics = $this->eventService->getEventStatistics($event);

        return response()->json([
            'status' => 'success',
            'data' => [
                'event' => [
                    'id' => $event->id,
                    'title' => $event->getTitle(),
                    'description' => $event->getDescription(),
                    'type' => $event->type,
                    'start_date' => $event->start_date,
                    'end_date' => $event->end_date,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                    'location' => $event->getLocation(),
                    'max_participants' => $event->max_participants,
                    'registration_deadline' => $event->registration_deadline,
                    'status' => $event->status,
                    'is_registration_open' => $event->isRegistrationOpen(),
                    'is_full' => $event->isFull(),
                    'organizer' => [
                        'id' => $event->organizer->id,
                        'name' => $event->organizer->name,
                        'email' => $event->organizer->email,
                    ],
                    'statistics' => $statistics,
                    'user_registration' => auth()->check() ?
                        $event->registrations()->where('user_id', auth()->id())->first() : null,
                    'created_at' => $event->created_at,
                    'updated_at' => $event->updated_at,
                ]
            ]
        ]);
    }

    /**
     * Update the specified event
     * PUT /api/v1/events/{id}
     */
    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        $updatedEvent = $this->eventService->updateEvent($event, $request->validated());

        return response()->json([
            'status' => 'success',
            'data' => [
                'event' => [
                    'id' => $updatedEvent->id,
                    'title' => $updatedEvent->getTitle(),
                    'description' => $updatedEvent->getDescription(),
                    'type' => $updatedEvent->type,
                    'start_date' => $updatedEvent->start_date,
                    'end_date' => $updatedEvent->end_date,
                    'location' => $updatedEvent->getLocation(),
                    'status' => $updatedEvent->status,
                ]
            ],
            'message' => 'Event updated successfully'
        ]);
    }

    /**
     * Remove the specified event
     * DELETE /api/v1/events/{id}
     */
    public function destroy(Event $event): JsonResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser->isAdmin() && !$currentUser->isLabManager() &&
            $currentUser->id !== $event->organizer_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        // Cannot delete events with registrations
        if ($event->registrations()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete event with existing registrations',
                'code' => 'EVENT_HAS_REGISTRATIONS'
            ], 422);
        }

        $event->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Event deleted successfully'
        ]);
    }

    /**
     * Register for event
     * POST /api/v1/events/{id}/register
     */
    public function register(RegisterEventRequest $request, Event $event): JsonResponse
    {
        $registration = $this->eventService->registerForEvent(
            $event,
            auth()->user(),
            $request->validated()
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'registration' => [
                    'id' => $registration->id,
                    'event' => [
                        'id' => $registration->event->id,
                        'title' => $registration->event->getTitle(),
                        'start_date' => $registration->event->start_date,
                        'location' => $registration->event->getLocation(),
                    ],
                    'status' => $registration->status,
                    'registration_date' => $registration->registration_date,
                ]
            ],
            'message' => 'Successfully registered for event'
        ], 201);
    }

    /**
     * Cancel event registration
     * DELETE /api/v1/events/{id}/register
     */
    public function cancelRegistration(Event $event): JsonResponse
    {
        $registration = $event->registrations()->where('user_id', auth()->id())->first();

        if (!$registration) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration not found',
                'code' => 'REGISTRATION_NOT_FOUND'
            ], 404);
        }

        $this->eventService->cancelRegistration($registration);

        return response()->json([
            'status' => 'success',
            'message' => 'Registration cancelled successfully'
        ]);
    }

    /**
     * Get event attendees (organizer/admin only)
     * GET /api/v1/events/{id}/attendees
     */
    public function attendees(Request $request, Event $event): JsonResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser->isAdmin() && !$currentUser->isLabManager() &&
            $currentUser->id !== $event->organizer_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $filters = $request->only(['status', 'attended_only']);
        $attendees = $this->eventService->getEventParticipants($event, $filters);

        return response()->json([
            'status' => 'success',
            'data' => [
                'attendees' => $attendees->map(function ($registration) {
                    return [
                        'id' => $registration->id,
                        'user' => [
                            'id' => $registration->user->id,
                            'name' => $registration->user->name,
                            'email' => $registration->user->email,
                            'role' => $registration->user->role,
                        ],
                        'status' => $registration->status,
                        'registration_date' => $registration->registration_date,
                        'notes' => $registration->notes,
                    ];
                })
            ]
        ]);
    }

    /**
     * Update event status
     * PUT /api/v1/events/{id}/status
     */
    public function updateStatus(Request $request, Event $event): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:draft,published,ongoing,completed,cancelled',
        ]);

        $currentUser = auth()->user();

        if (!$currentUser->isAdmin() && !$currentUser->isLabManager() &&
            $currentUser->id !== $event->organizer_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $updatedEvent = $this->eventService->changeEventStatus($event, $request->status);

        return response()->json([
            'status' => 'success',
            'data' => [
                'event' => [
                    'id' => $updatedEvent->id,
                    'status' => $updatedEvent->status,
                ]
            ],
            'message' => 'Event status updated successfully'
        ]);
    }

    /**
     * Mark participant attendance
     * PUT /api/v1/events/{id}/attendees/{registration_id}/attendance
     */
    public function markAttendance(Event $event, EventRegistration $registration): JsonResponse
    {
        $currentUser = auth()->user();

        if (!$currentUser->isAdmin() && !$currentUser->isLabManager() &&
            $currentUser->id !== $event->organizer_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'code' => 'INSUFFICIENT_PERMISSIONS'
            ], 403);
        }

        $updatedRegistration = $this->eventService->markAttendance($registration);

        return response()->json([
            'status' => 'success',
            'data' => [
                'registration' => [
                    'id' => $updatedRegistration->id,
                    'status' => $updatedRegistration->status,
                ]
            ],
            'message' => 'Attendance marked successfully'
        ]);
    }

    /**
     * Generate certificate
     * POST /api/v1/events/{id}/certificate
     */
    public function generateCertificate(Event $event): JsonResponse
    {
        $currentUser = auth()->user();
        $registration = $event->registrations()->where('user_id', $currentUser->id)->first();

        if (!$registration) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration not found',
                'code' => 'REGISTRATION_NOT_FOUND'
            ], 404);
        }

        try {
            $certificatePath = $this->eventService->generateCertificate($registration);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'certificate' => [
                        'url' => url("storage/{$certificatePath}"),
                        'path' => $certificatePath,
                    ]
                ],
                'message' => 'Certificate generated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'code' => 'CERTIFICATE_GENERATION_FAILED'
            ], 422);
        }
    }

    /**
     * Search events
     * GET /api/v1/events/search
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'type' => 'nullable|string',
            'upcoming' => 'nullable|boolean',
            'published' => 'nullable|boolean',
        ]);

        $events = $this->eventService->searchEvents(
            $request->query,
            $request->only(['type', 'upcoming', 'published'])
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'events' => $events->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->getTitle(),
                        'type' => $event->type,
                        'start_date' => $event->start_date,
                        'location' => $event->getLocation(),
                        'organizer' => $event->organizer->name,
                        'is_registration_open' => $event->isRegistrationOpen(),
                    ];
                })
            ]
        ]);
    }

    /**
     * Get event types
     * GET /api/v1/events/types
     */
    public function types(): JsonResponse
    {
        $types = $this->eventService->getEventTypes();

        return response()->json([
            'status' => 'success',
            'data' => [
                'types' => $types
            ]
        ]);
    }

    /**
     * Get user's event registrations
     * GET /api/v1/events/my-registrations
     */
    public function myRegistrations(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'upcoming']);
        $perPage = min($request->input('per_page', 15), 100);

        $registrations = EventRegistration::with(['event', 'user'])
            ->where('user_id', auth()->id())
            ->when(!empty($filters['status']), function ($query) use ($filters) {
                return $query->where('status', $filters['status']);
            })
            ->when(!empty($filters['upcoming']), function ($query) {
                return $query->whereHas('event', function ($q) {
                    $q->where('start_date', '>=', now());
                });
            })
            ->orderBy('registration_date', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'registrations' => $registrations->items()->map(function ($registration) {
                    return [
                        'id' => $registration->id,
                        'event' => [
                            'id' => $registration->event->id,
                            'title' => $registration->event->getTitle(),
                            'type' => $registration->event->type,
                            'start_date' => $registration->event->start_date,
                            'end_date' => $registration->event->end_date,
                            'location' => $registration->event->getLocation(),
                        ],
                        'status' => $registration->status,
                        'registration_date' => $registration->registration_date,
                        'notes' => $registration->notes,
                        'has_certificate' => $registration->hasCertificate(),
                    ];
                }),
                'pagination' => [
                    'current_page' => $registrations->currentPage(),
                    'total_pages' => $registrations->lastPage(),
                    'total_items' => $registrations->total(),
                    'per_page' => $registrations->perPage(),
                ]
            ]
        ]);
    }
}