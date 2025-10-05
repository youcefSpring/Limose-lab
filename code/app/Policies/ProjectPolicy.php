<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine if the given project can be viewed by the user.
     */
    public function view(User $user, Project $project): bool
    {
        // Admin and lab managers can view all projects
        if ($user->isAdmin() || $user->isLabManager()) {
            return true;
        }

        // Researchers can view projects they are associated with
        if ($user->isResearcher()) {
            return $project->principal_investigator_id === $user->researcher?->id ||
                   $project->collaborators()->where('researcher_id', $user->researcher?->id)->exists();
        }

        return false;
    }

    /**
     * Determine if the user can view any projects.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isLabManager() || $user->isResearcher();
    }

    /**
     * Determine if the user can create projects.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isLabManager() || $user->isResearcher();
    }

    /**
     * Determine if the user can update the project.
     */
    public function update(User $user, Project $project): bool
    {
        // Admin and lab managers can update all projects
        if ($user->isAdmin() || $user->isLabManager()) {
            return true;
        }

        // Principal investigator can update their project
        if ($user->isResearcher()) {
            return $project->principal_investigator_id === $user->researcher?->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the project.
     */
    public function delete(User $user, Project $project): bool
    {
        // Only admin and lab managers can delete projects
        if ($user->isAdmin() || $user->isLabManager()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can restore the project.
     */
    public function restore(User $user, Project $project): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can permanently delete the project.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can view analytics for projects.
     */
    public function viewAnalytics(User $user): bool
    {
        return $user->isAdmin() || $user->isLabManager();
    }
}