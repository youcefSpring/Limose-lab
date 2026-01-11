<?php

namespace App\Policies;

use App\Models\Material;
use App\Models\User;

class MaterialPolicy
{
    /**
     * Determine if the user can view any materials.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view materials
    }

    /**
     * Determine if the user can view the material.
     */
    public function view(User $user, Material $material): bool
    {
        return true; // All authenticated users can view a material
    }

    /**
     * Determine if the user can create materials.
     */
    public function create(User $user): bool
    {
        // Admins, material_managers, and technicians can create materials
        return $user->hasAnyRole(['admin', 'material_manager', 'technician']);
    }

    /**
     * Determine if the user can update the material.
     */
    public function update(User $user, Material $material): bool
    {
        // Admins, material_managers, and technicians can update materials
        return $user->hasAnyRole(['admin', 'material_manager', 'technician']);
    }

    /**
     * Determine if the user can delete the material.
     */
    public function delete(User $user, Material $material): bool
    {
        // Only admins can delete materials
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can restore the material.
     */
    public function restore(User $user, Material $material): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can permanently delete the material.
     */
    public function forceDelete(User $user, Material $material): bool
    {
        return $user->hasRole('admin');
    }
}
