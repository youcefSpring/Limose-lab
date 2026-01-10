<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('events.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Event $event): bool
    {
        return $user->can('events.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('events.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
        // Event organizer can update
        if ($user->id === $event->created_by) {
            return true;
        }

        return $user->can('events.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        // Event organizer can delete
        if ($user->id === $event->created_by) {
            return true;
        }

        return $user->can('events.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Event $event): bool
    {
        return $user->can('events.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Event $event): bool
    {
        return $user->can('events.force-delete');
    }

    /**
     * Determine whether the user can RSVP to event.
     */
    public function rsvp(User $user, Event $event): bool
    {
        return $event->canUserAttend($user) && $event->hasCapacity();
    }
}
