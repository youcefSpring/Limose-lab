<?php

namespace App\Helpers;

use App\Models\User;

class PermissionHelper
{
    /**
     * Check if user can manage materials.
     *
     * @param User $user
     * @return bool
     */
    public static function canManageMaterials(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'material_manager']);
    }

    /**
     * Check if user can approve reservations.
     *
     * @param User $user
     * @return bool
     */
    public static function canApproveReservations(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'material_manager']);
    }

    /**
     * Check if user can create projects.
     *
     * @param User $user
     * @return bool
     */
    public static function canCreateProjects(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'researcher', 'phd_student']);
    }

    /**
     * Check if user can manage events.
     *
     * @param User $user
     * @return bool
     */
    public static function canManageEvents(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'material_manager']);
    }

    /**
     * Check if user can approve user registrations.
     *
     * @param User $user
     * @return bool
     */
    public static function canApproveUsers(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Check if user can assign roles.
     *
     * @param User $user
     * @return bool
     */
    public static function canAssignRoles(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Check if user can manage maintenance.
     *
     * @param User $user
     * @return bool
     */
    public static function canManageMaintenance(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'material_manager', 'technician']);
    }

    /**
     * Check if user can perform maintenance tasks.
     *
     * @param User $user
     * @return bool
     */
    public static function canPerformMaintenance(User $user): bool
    {
        return $user->hasRole('technician');
    }

    /**
     * Check if user can view all projects.
     *
     * @param User $user
     * @return bool
     */
    public static function canViewAllProjects(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Check if user can view restricted events.
     *
     * @param User $user
     * @return bool
     */
    public static function canViewRestrictedEvents(User $user): bool
    {
        return !$user->hasRole('guest');
    }

    /**
     * Check if user can add experiments.
     *
     * @param User $user
     * @return bool
     */
    public static function canAddExperiments(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'researcher', 'phd_student', 'partial_researcher']);
    }

    /**
     * Check if user can view all reservations.
     *
     * @param User $user
     * @return bool
     */
    public static function canViewAllReservations(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'material_manager']);
    }

    /**
     * Get user role priority (lower number = higher priority).
     *
     * @param User $user
     * @return int
     */
    public static function getRolePriority(User $user): int
    {
        if ($user->hasRole('admin')) return 1;
        if ($user->hasRole('material_manager')) return 2;
        if ($user->hasRole('researcher')) return 3;
        if ($user->hasRole('phd_student')) return 4;
        if ($user->hasRole('partial_researcher')) return 5;
        if ($user->hasRole('technician')) return 6;
        if ($user->hasRole('guest')) return 7;

        return 999; // No role
    }

    /**
     * Check if user has higher priority than another user.
     *
     * @param User $user1
     * @param User $user2
     * @return bool
     */
    public static function hasHigherPriority(User $user1, User $user2): bool
    {
        return self::getRolePriority($user1) < self::getRolePriority($user2);
    }
}
