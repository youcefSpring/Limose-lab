<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view reservations
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reservation $reservation): bool
    {
        // Admin can view all, users can view their own
        return $user->hasRole('admin') || $user->id === $reservation->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // All authenticated users can create reservations
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reservation $reservation): bool
    {
        // Admin can update all, users can update their own pending/approved reservations
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->id === $reservation->user_id &&
               in_array($reservation->status, ['pending', 'approved']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reservation $reservation): bool
    {
        // Admin can delete all
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reservation $reservation): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reservation $reservation): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can approve/reject reservations.
     */
    public function approve(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'material_manager']);
    }

    /**
     * Determine whether the user can cancel the reservation.
     */
    public function cancel(User $user, Reservation $reservation): bool
    {
        // Admin can cancel all, users can cancel their own
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->id === $reservation->user_id &&
               in_array($reservation->status, ['pending', 'approved']);
    }
}
