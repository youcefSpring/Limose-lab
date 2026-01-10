<?php

namespace App\Policies;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PublicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Researchers, PhD students, and admins can view publications
        return $user->hasAnyRole(['admin', 'researcher', 'partial_researcher', 'phd_student']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Publication $publication): bool
    {
        // Admin can view all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Public publications can be viewed by anyone
        if ($publication->visibility === 'public') {
            return true;
        }

        // Owner can view their own publications
        return $user->id === $publication->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Researchers, PhD students, and admins can create publications
        return $user->hasAnyRole(['admin', 'researcher', 'partial_researcher', 'phd_student']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Publication $publication): bool
    {
        // Admin can update all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Owner can update their own publications
        return $user->id === $publication->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Publication $publication): bool
    {
        // Admin can delete all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Owner can delete their own publications
        return $user->id === $publication->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Publication $publication): bool
    {
        // Admin can restore all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Owner can restore their own publications
        return $user->id === $publication->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Publication $publication): bool
    {
        // Only admin can force delete
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can approve/reject publications.
     */
    public function approve(User $user, Publication $publication): bool
    {
        // Only admin can approve/reject publications
        return $user->hasRole('admin');
    }
}
