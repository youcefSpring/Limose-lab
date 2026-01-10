<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('projects.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        // Project members can view the project
        if ($project->hasMember($user)) {
            return true;
        }

        return $user->can('projects.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('projects.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        // Project owners can update the project
        if ($project->hasOwner($user)) {
            return true;
        }

        return $user->can('projects.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        // Project creator can delete
        if ($user->id === $project->created_by) {
            return true;
        }

        return $user->can('projects.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return $user->can('projects.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return $user->can('projects.force-delete');
    }

    /**
     * Determine whether the user can manage project members.
     */
    public function manageMembers(User $user, Project $project): bool
    {
        return $project->hasOwner($user) || $user->can('projects.manage-members');
    }
}
