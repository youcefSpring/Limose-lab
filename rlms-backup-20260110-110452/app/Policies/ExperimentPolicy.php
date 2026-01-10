<?php

namespace App\Policies;

use App\Models\Experiment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExperimentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('experiments.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Experiment $experiment): bool
    {
        // Experiment owner or project member can view
        if ($user->id === $experiment->user_id || $experiment->project->hasMember($user)) {
            return true;
        }

        return $user->can('experiments.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('experiments.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Experiment $experiment): bool
    {
        // Experiment owner can update
        if ($user->id === $experiment->user_id) {
            return true;
        }

        return $user->can('experiments.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Experiment $experiment): bool
    {
        // Experiment owner can delete
        if ($user->id === $experiment->user_id) {
            return true;
        }

        return $user->can('experiments.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Experiment $experiment): bool
    {
        return $user->can('experiments.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Experiment $experiment): bool
    {
        return $user->can('experiments.force-delete');
    }
}
