<?php

namespace App\Policies;

use App\Models\Experiment;
use App\Models\User;

class ExperimentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view experiments
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Experiment $experiment): bool
    {
        // All authenticated users can view experiments
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Researchers, PhD students, and admins can create experiments
        return $user->hasAnyRole(['admin', 'researcher', 'partial_researcher', 'phd_student']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Experiment $experiment): bool
    {
        // Admin can update all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Researcher assigned to the experiment can update it
        return $user->id === $experiment->researcher_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Experiment $experiment): bool
    {
        // Admin can delete all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Researcher can delete their own experiments
        return $user->id === $experiment->researcher_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Experiment $experiment): bool
    {
        // Admin can restore all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Researcher can restore their own experiments
        return $user->id === $experiment->researcher_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Experiment $experiment): bool
    {
        // Only admin can force delete
        return $user->hasRole('admin');
    }
}
