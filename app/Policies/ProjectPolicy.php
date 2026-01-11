<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view projects
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        // All authenticated users can view projects
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Researchers, PhD students, and admins can create projects
        return $user->hasAnyRole(['admin', 'researcher', 'partial_researcher', 'phd_student']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        // Admin can update all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Project creator can update their own projects
        return $user->id === $project->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        // Admin can delete all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Project creator can delete their own projects
        return $user->id === $project->created_by;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        // Admin can restore all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Project creator can restore their own projects
        return $user->id === $project->created_by;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        // Only admin can force delete
        return $user->hasRole('admin');
    }
}
