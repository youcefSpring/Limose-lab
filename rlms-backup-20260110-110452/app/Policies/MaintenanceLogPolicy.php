<?php

namespace App\Policies;

use App\Models\MaintenanceLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MaintenanceLogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('maintenance.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MaintenanceLog $maintenanceLog): bool
    {
        return $user->can('maintenance.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('maintenance.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MaintenanceLog $maintenanceLog): bool
    {
        // Assigned technician can update
        if ($user->id === $maintenanceLog->technician_id) {
            return true;
        }

        return $user->can('maintenance.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MaintenanceLog $maintenanceLog): bool
    {
        return $user->can('maintenance.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MaintenanceLog $maintenanceLog): bool
    {
        return $user->can('maintenance.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MaintenanceLog $maintenanceLog): bool
    {
        return $user->can('maintenance.force-delete');
    }
}
