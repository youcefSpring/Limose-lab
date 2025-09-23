<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\EventController as ApiEventController;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event;
use App\Services\EventService;
use App\Services\ResearcherService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService,
        private ResearcherService $researcherService,
        private ApiEventController $apiController
    ) {
       
    }

    /**
     * Display a listing of events
     */
    public function index(Request $request): View
    {
        $filters = $request->only([
            'search', 'type', 'status', 'organizer_id', 'start_date_from', 'start_date_to'
        ]);
        $perPage = min($request->input('per_page', 15), 100);

        $events = $this->eventService->getEvents($filters, $perPage);
        $researchers = $this->researcherService->getResearchers([], 1000);

        return view('events.index', compact('events', 'filters', 'researchers'));
    }

    /**
     * Show the form for creating a new event
     */
    public function create(): View
    {
        $this->authorize('create', Event::class);

        $researchers = $this->researcherService->getResearchers([], 1000);

        return view('events.create', compact('researchers'));
    }

    /**
     * Store a newly created event
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $this->authorize('create', Event::class);

        try {
            $event = $this->eventService->createEvent($request->validated());

            return redirect()
                ->route('events.show', $event)
                ->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create event: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified event
     */
    public function show(Event $event): View
    {
        $this->authorize('view', $event);

        $event->load(['organizer', 'registrations.user', 'speakers']);
        $statistics = $this->eventService->getEventStatistics($event);

        return view('events.show', compact('event', 'statistics'));
    }

    /**
     * Show the form for editing the specified event
     */
    public function edit(Event $event): View
    {
        $this->authorize('update', $event);

        $researchers = $this->researcherService->getResearchers([], 1000);

        return view('events.edit', compact('event', 'researchers'));
    }

    /**
     * Update the specified event
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        try {
            $updatedEvent = $this->eventService->updateEvent($event, $request->validated());

            return redirect()
                ->route('events.show', $updatedEvent)
                ->with('success', 'Event updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update event: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified event
     */
    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        try {
            $this->eventService->deleteEvent($event);

            return redirect()
                ->route('events.index')
                ->with('success', 'Event deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete event: ' . $e->getMessage());
        }
    }

    /**
     * Display event registrations
     */
    public function registrations(Event $event): View
    {
        $this->authorize('view', $event);

        $registrations = $this->eventService->getEventRegistrations($event);

        return view('events.registrations', compact('event', 'registrations'));
    }

    /**
     * Register for an event
     */
    public function register(Event $event): RedirectResponse
    {
        $this->authorize('register', $event);

        try {
            $this->eventService->registerForEvent($event, auth()->user());

            return redirect()
                ->route('events.show', $event)
                ->with('success', 'Successfully registered for the event.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to register for event: ' . $e->getMessage());
        }
    }

    /**
     * Unregister from an event
     */
    public function unregister(Event $event): RedirectResponse
    {
        try {
            $this->eventService->unregisterFromEvent($event, auth()->user());

            return redirect()
                ->route('events.show', $event)
                ->with('success', 'Successfully unregistered from the event.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to unregister from event: ' . $e->getMessage());
        }
    }

    /**
     * Display event speakers
     */
    public function speakers(Event $event): View
    {
        $this->authorize('view', $event);

        $speakers = $this->eventService->getEventSpeakers($event);
        $availableResearchers = $this->researcherService->getResearchers([], 1000);

        return view('events.speakers', compact('event', 'speakers', 'availableResearchers'));
    }

    /**
     * Display event agenda
     */
    public function agenda(Event $event): View
    {
        $this->authorize('view', $event);

        $agenda = $this->eventService->getEventAgenda($event);

        return view('events.agenda', compact('event', 'agenda'));
    }

    /**
     * Display event materials
     */
    public function materials(Event $event): View
    {
        $this->authorize('view', $event);

        $materials = $this->eventService->getEventMaterials($event);

        return view('events.materials', compact('event', 'materials'));
    }

    /**
     * Display events calendar
     */
    public function calendar(Request $request): View
    {
        $filters = $request->only(['type', 'organizer_id']);
        $events = $this->eventService->getCalendarEvents($filters);

        return view('events.calendar', compact('events', 'filters'));
    }

    /**
     * Display event attendance
     */
    public function attendance(Event $event): View
    {
        $this->authorize('manage', $event);

        $attendance = $this->eventService->getEventAttendance($event);

        return view('events.attendance', compact('event', 'attendance'));
    }

    /**
     * Mark attendance for event
     */
    public function markAttendance(Request $request, Event $event): RedirectResponse
    {
        $this->authorize('manage', $event);

        $request->validate([
            'attendees' => 'required|array',
            'attendees.*' => 'exists:users,id'
        ]);

        try {
            $this->eventService->markAttendance($event, $request->attendees);

            return redirect()
                ->route('events.attendance', $event)
                ->with('success', 'Attendance marked successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to mark attendance: ' . $e->getMessage());
        }
    }

    /**
     * Search events (AJAX endpoint)
     */
    public function search(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->apiController->search($request);
        }

        // For non-AJAX requests, redirect to index with search parameters
        return redirect()->route('events.index', $request->only([
            'query', 'type', 'status', 'organizer_id'
        ]));
    }

    /**
     * Export event data
     */
    public function export(Request $request, Event $event)
    {
        $this->authorize('view', $event);

        $format = $request->input('format', 'csv');
        $data = $request->input('data', 'registrations');

        try {
            return $this->eventService->exportEventData($event, $data, $format);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export event data: ' . $e->getMessage());
        }
    }
}