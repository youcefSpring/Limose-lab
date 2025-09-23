<?php

namespace App\Policies;

use App\Models\Researcher;
use App\Models\User;

class ResearcherPolicy
{
    /**
     * Determine if the given researcher can be viewed by the user.
     */
    public function view(User $user, Researcher $researcher): bool
    {
        // Admin and lab managers can view all researchers
        if ($user->isAdmin() || $user->isLabManager()) {
            return true;
        }

        // Researchers can view their own profile and other researchers
        if ($user->isResearcher()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can view any researchers.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isLabManager() || $user->isResearcher();
    }

    /**
     * Determine if the user can create researchers.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isLabManager();
    }

    /**
     * Determine if the user can update the researcher.
     */
    public function update(User $user, Researcher $researcher): bool
    {
        // Admin and lab managers can update all researchers
        if ($user->isAdmin() || $user->isLabManager()) {
            return true;
        }

        // Researchers can update their own profile
        if ($user->isResearcher()) {
            return $researcher->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the researcher.
     */
    public function delete(User $user, Researcher $researcher): bool
    {
        return $user->isAdmin() || $user->isLabManager();
    }
}