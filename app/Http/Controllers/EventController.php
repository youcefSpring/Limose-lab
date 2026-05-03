<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Mail\EventRSVPConfirmation;
use App\Models\Event;
use App\Models\Setting;
use App\Services\CacheService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct(
        private CacheService $cacheService
    ) {}

    public function index(Request $request): View
    {
        $query = Event::with('creator');

        $filter = $request->get('filter');
        if ($filter === 'upcoming') {
            $query->where('event_date', '>', now());
        } elseif ($filter === 'past') {
            $query->where('event_date', '<=', now());
        }

        $events = $query->withCount('attendees')
            ->orderBy('event_date', 'desc')
            ->paginate(20);

        return view('events.index', compact('events'));
    }

    public function create(): View
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($validated);
        $this->cacheService->clearEventCaches();

        return redirect()->route('events.index')
            ->with('success', __('Event created successfully.'));
    }

    public function show(Event $event): View
    {
        $event->load(['creator', 'attendees', 'comments.user']);
        $event->loadCount('attendees');

        $event->is_user_attending = $event->attendees()
            ->where('user_id', auth()->id())
            ->exists();

        return view('events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);
        $this->cacheService->clearEventCaches();

        return redirect()->route('events.show', $event)
            ->with('success', __('Event updated successfully.'));
    }

    public function destroy(Event $event): RedirectResponse
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();
        $this->cacheService->clearEventCaches();

        return redirect()->route('events.index')
            ->with('success', __('Event deleted successfully.'));
    }

    public function rsvp(Event $event): RedirectResponse
    {
        $user = auth()->user();

        if ($event->attendees()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('warning', __('You are already registered for this event.'));
        }

        if ($event->capacity && $event->attendees()->count() >= $event->capacity) {
            return redirect()->back()->with('error', __('This event is full.'));
        }

        $event->attendees()->attach($user->id, ['status' => 'confirmed']);
        $this->sendRsvpNotifications($event, $user);
        $this->cacheService->clearEventCaches();

        return redirect()->back()->with('success', __('You have successfully registered for this event.'));
    }

    public function cancelRsvp(Event $event): RedirectResponse
    {
        $event->attendees()->detach(auth()->id());
        $this->cacheService->clearEventCaches();

        return redirect()->back()->with('success', __('Your RSVP has been cancelled.'));
    }

    public function addComment(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $event->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
        ]);

        return redirect()->back()->with('success', __('Comment added successfully.'));
    }

    private function sendRsvpNotifications(Event $event, $user): void
    {
        if (! Setting::get('notify_user_on_event_rsvp', true)) {
            return;
        }

        Mail::to($user->email)->send(new EventRSVPConfirmation($event, $user));

        if (Setting::get('notify_admin_on_submission', true)) {
            $adminEmail = Setting::get('admin_notification_email');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new EventRSVPConfirmation($event, $user));
            }
        }
    }
}
