<?php

namespace App\Policies;

use App\Models\MaintenanceLog;
use App\Models\User;

class MaintenanceLogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view maintenance logs
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MaintenanceLog $maintenanceLog): bool
    {
        // All authenticated users can view maintenance logs
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admins, technicians, and material managers can create maintenance logs
        return $user->hasAnyRole(['admin', 'technician', 'material_manager']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MaintenanceLog $maintenanceLog): bool
    {
        // Admin can update all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Technicians and material managers can update logs
        return $user->hasAnyRole(['technician', 'material_manager']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MaintenanceLog $maintenanceLog): bool
    {
        // Only admin can delete maintenance logs
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MaintenanceLog $maintenanceLog): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MaintenanceLog $maintenanceLog): bool
    {
        return $user->hasRole('admin');
    }
}
