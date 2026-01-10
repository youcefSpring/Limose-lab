<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventService
{
    /**
     * Create a new event.
     *
     * @param User $creator
     * @param array $data
     * @return Event
     */
    public function createEvent(User $creator, array $data): Event
    {
        return DB::transaction(function () use ($creator, $data) {
            // Handle image upload if provided
            if (isset($data['image'])) {
                $data['image'] = $this->uploadImage($data['image']);
            }

            $event = Event::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'event_date' => $data['event_date'],
                'event_time' => $data['event_time'],
                'location' => $data['location'],
                'capacity' => $data['capacity'] ?? null,
                'event_type' => $data['event_type'] ?? 'public',
                'target_roles' => $data['target_roles'] ?? [],
                'image' => $data['image'] ?? null,
                'created_by' => $creator->id,
            ]);

            return $event->fresh('creator');
        });
    }

    /**
     * Update an event.
     *
     * @param Event $event
     * @param array $data
     * @return Event
     */
    public function updateEvent(Event $event, array $data): Event
    {
        // Handle image upload if provided
        if (isset($data['image'])) {
            // Delete old image
            if ($event->image) {
                $this->deleteImage($event->image);
            }
            $data['image'] = $this->uploadImage($data['image']);
        }

        $event->update([
            'title' => $data['title'] ?? $event->title,
            'description' => $data['description'] ?? $event->description,
            'event_date' => $data['event_date'] ?? $event->event_date,
            'event_time' => $data['event_time'] ?? $event->event_time,
            'location' => $data['location'] ?? $event->location,
            'capacity' => $data['capacity'] ?? $event->capacity,
            'event_type' => $data['event_type'] ?? $event->event_type,
            'target_roles' => $data['target_roles'] ?? $event->target_roles,
            'image' => $data['image'] ?? $event->image,
        ]);

        return $event->fresh();
    }

    /**
     * Delete an event.
     *
     * @param Event $event
     * @return bool
     */
    public function deleteEvent(Event $event): bool
    {
        // Delete image if exists
        if ($event->image) {
            $this->deleteImage($event->image);
        }

        return $event->delete();
    }

    /**
     * Cancel an event.
     *
     * @param Event $event
     * @return Event
     */
    public function cancelEvent(Event $event): Event
    {
        $event->update(['cancelled_at' => now()]);
        return $event->fresh();
    }

    /**
     * Reactivate a cancelled event.
     *
     * @param Event $event
     * @return Event
     */
    public function reactivateEvent(Event $event): Event
    {
        $event->update(['cancelled_at' => null]);
        return $event->fresh();
    }

    /**
     * Register a user for an event (RSVP).
     *
     * @param Event $event
     * @param User $user
     * @return array
     */
    public function registerAttendee(Event $event, User $user): array
    {
        // Check if event is cancelled
        if ($event->isCancelled()) {
            return $this->errorResponse('Cannot register for a cancelled event');
        }

        // Check if event is in the past
        if ($event->event_date < now()) {
            return $this->errorResponse('Cannot register for past events');
        }

        // Check if user can attend (role-based)
        if (!$event->canUserAttend($user)) {
            return $this->errorResponse('This event is not available for your role');
        }

        // Check if user already registered
        if ($event->hasUserRegistered($user)) {
            return $this->errorResponse('You are already registered for this event');
        }

        // Check capacity
        if (!$event->hasCapacity()) {
            return $this->errorResponse('Event is at full capacity');
        }

        // Register user
        $event->attendees()->attach($user->id, [
            'status' => 'pending',
            'registered_at' => now(),
        ]);

        return [
            'success' => true,
            'message' => 'Successfully registered for the event',
        ];
    }

    /**
     * Confirm attendance.
     *
     * @param Event $event
     * @param User $user
     * @return array
     */
    public function confirmAttendance(Event $event, User $user): array
    {
        if (!$event->hasUserRegistered($user)) {
            return $this->errorResponse('User is not registered for this event');
        }

        $event->attendees()->updateExistingPivot($user->id, ['status' => 'confirmed']);

        return [
            'success' => true,
            'message' => 'Attendance confirmed',
        ];
    }

    /**
     * Cancel attendance.
     *
     * @param Event $event
     * @param User $user
     * @return array
     */
    public function cancelAttendance(Event $event, User $user): array
    {
        if (!$event->hasUserRegistered($user)) {
            return $this->errorResponse('User is not registered for this event');
        }

        $event->attendees()->detach($user->id);

        return [
            'success' => true,
            'message' => 'Registration cancelled',
        ];
    }

    /**
     * Get upcoming events.
     *
     * @param User|null $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUpcomingEvents(?User $user = null)
    {
        $query = Event::upcoming()->with('creator', 'attendees');

        // Filter by role if user provided
        if ($user) {
            $userRoles = $user->getRoleNames()->toArray();
            $query->where(function ($q) use ($userRoles) {
                $q->where('event_type', 'public')
                    ->orWhere(function ($subQuery) use ($userRoles) {
                        $subQuery->where('event_type', 'restricted');
                        foreach ($userRoles as $role) {
                            $subQuery->orWhereJsonContains('target_roles', $role);
                        }
                    });
            });
        } else {
            $query->public();
        }

        return $query->orderBy('event_date')->get();
    }

    /**
     * Get past events.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPastEvents()
    {
        return Event::past()
            ->with('creator', 'attendees')
            ->orderBy('event_date', 'desc')
            ->get();
    }

    /**
     * Get user's registered events.
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserEvents(User $user)
    {
        return $user->events()
            ->with('creator')
            ->orderBy('event_date', 'desc')
            ->get();
    }

    /**
     * Search events by keyword.
     *
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchEvents(string $keyword)
    {
        return Event::where('title', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->orWhere('location', 'like', "%{$keyword}%")
            ->with('creator', 'attendees')
            ->orderBy('event_date', 'desc')
            ->get();
    }

    /**
     * Get event statistics.
     *
     * @param Event $event
     * @return array
     */
    public function getEventStatistics(Event $event): array
    {
        $totalAttendees = $event->attendees()->count();
        $confirmedAttendees = $event->confirmedAttendees()->count();
        $pendingAttendees = $event->attendees()->wherePivot('status', 'pending')->count();

        $capacityPercentage = null;
        if ($event->capacity) {
            $capacityPercentage = ($totalAttendees / $event->capacity) * 100;
        }

        return [
            'total_attendees' => $totalAttendees,
            'confirmed_attendees' => $confirmedAttendees,
            'pending_attendees' => $pendingAttendees,
            'capacity' => $event->capacity,
            'capacity_percentage' => $capacityPercentage,
            'is_full' => !$event->hasCapacity(),
            'is_cancelled' => $event->isCancelled(),
            'days_until_event' => now()->diffInDays($event->event_date, false),
        ];
    }

    /**
     * Upload event image.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string Path to stored image
     */
    private function uploadImage($file): string
    {
        $path = $file->store('events', 'public');
        return $path;
    }

    /**
     * Delete event image.
     *
     * @param string $path
     * @return bool
     */
    private function deleteImage(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    /**
     * Helper method to format error response.
     *
     * @param string $message
     * @return array
     */
    private function errorResponse(string $message): array
    {
        return [
            'success' => false,
            'errors' => [$message],
        ];
    }
}
