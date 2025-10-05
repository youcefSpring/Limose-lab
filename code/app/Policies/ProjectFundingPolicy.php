<?php

namespace App\Policies;

use App\Models\ProjectFunding;
use App\Models\User;

class ProjectFundingPolicy
{
    /**
     * Determine if the given funding can be viewed by the user.
     */
    public function view(User $user, ProjectFunding $funding): bool
    {
        // Admin and lab managers can view all funding
        if ($user->isAdmin() || $user->isLabManager()) {
            return true;
        }

        // Researchers can view funding for their projects
        if ($user->isResearcher() && $user->researcher) {
            return $funding->project->principal_investigator_id === $user->researcher->id ||
                   $funding->project->collaborators()->where('researcher_id', $user->researcher->id)->exists();
        }

        return false;
    }

    /**
     * Determine if the user can view any funding.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isLabManager() || $user->isResearcher();
    }

    /**
     * Determine if the user can create funding.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isLabManager();
    }

    /**
     * Determine if the user can update the funding.
     */
    public function update(User $user, ProjectFunding $funding): bool
    {
        return $user->isAdmin() || $user->isLabManager();
    }

    /**
     * Determine if the user can delete the funding.
     */
    public function delete(User $user, ProjectFunding $funding): bool
    {
        return $user->isAdmin() || $user->isLabManager();
    }

    /**
     * Determine if the user can view analytics for funding.
     */
    public function viewAnalytics(User $user): bool
    {
        return $user->isAdmin() || $user->isLabManager();
    }
}