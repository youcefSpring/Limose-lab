<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('reservations.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reservation $reservation): bool
    {
        // Users can view their own reservations
        if ($user->id === $reservation->user_id) {
            return true;
        }

        return $user->can('reservations.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('reservations.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reservation $reservation): bool
    {
        // Users can update their own pending reservations
        if ($user->id === $reservation->user_id && $reservation->isPending()) {
            return true;
        }

        return $user->can('reservations.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reservation $reservation): bool
    {
        return $user->can('reservations.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reservation $reservation): bool
    {
        return $user->can('reservations.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reservation $reservation): bool
    {
        return $user->can('reservations.force-delete');
    }

    /**
     * Determine whether the user can approve reservations.
     */
    public function approve(User $user, Reservation $reservation): bool
    {
        return $user->can('reservations.approve') && $reservation->isPending();
    }

    /**
     * Determine whether the user can reject reservations.
     */
    public function reject(User $user, Reservation $reservation): bool
    {
        return $user->can('reservations.reject') && $reservation->isPending();
    }

    /**
     * Determine whether the user can cancel a reservation.
     */
    public function cancel(User $user, Reservation $reservation): bool
    {
        // Users can cancel their own reservations if they can be cancelled
        if ($user->id === $reservation->user_id && $reservation->canBeCancelled()) {
            return true;
        }

        return $user->can('reservations.cancel') && $reservation->canBeCancelled();
    }
}
