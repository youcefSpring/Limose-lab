<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::with('creator');

        // Filter by time period
        $filter = $request->get('filter');
        if ($filter === 'upcoming') {
            $query->where('event_date', '>', now());
        } elseif ($filter === 'past') {
            $query->where('event_date', '<=', now());
        }

        $events = $query->withCount('attendees')->orderBy('event_date', 'desc')->paginate(10);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'event_type' => 'required|in:seminar,workshop,conference,meeting',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($validated);

        return redirect()->route('events.index')->with('success', __('Event created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['creator', 'attendees', 'comments.user']);
        $event->loadCount('attendees');

        // Check if current user is attending
        $event->isUserAttending = $event->attendees->contains(auth()->id());

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'event_type' => 'required|in:seminar,workshop,conference,meeting',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image) {
                \Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('events.show', $event)->with('success', __('Event updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->image) {
            \Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', __('Event deleted successfully.'));
    }

    /**
     * RSVP to an event.
     */
    public function rsvp(Event $event)
    {
        $user = auth()->user();

        if ($event->attendees->contains($user->id)) {
            return redirect()->back()->with('warning', __('You are already registered for this event.'));
        }

        if ($event->capacity && $event->attendees->count() >= $event->capacity) {
            return redirect()->back()->with('error', __('This event is full.'));
        }

        $event->attendees()->attach($user->id, ['status' => 'confirmed']);

        return redirect()->back()->with('success', __('You have successfully registered for this event.'));
    }

    /**
     * Cancel RSVP for an event.
     */
    public function cancelRsvp(Event $event)
    {
        $event->attendees()->detach(auth()->id());

        return redirect()->back()->with('success', __('Your RSVP has been cancelled.'));
    }

    /**
     * Add a comment to an event.
     */
    public function addComment(Request $request, Event $event)
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
}
