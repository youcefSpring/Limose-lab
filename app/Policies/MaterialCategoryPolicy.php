<?php

namespace App\Policies;

use App\Models\MaterialCategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MaterialCategoryPolicy
{
    /**
     * Determine whether the user can manage categories.
     */
    public function manage(User $user): bool
    {
        // Admin always has permission, or users with specific permission
        return $user->hasRole('admin') || $user->hasPermissionTo('categories.manage');
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin always has permission, or users with specific permission
        return $user->hasRole('admin') || $user->hasPermissionTo('categories.manage');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MaterialCategory $materialCategory): bool
    {
        // Admin always has permission, or users with specific permission
        return $user->hasRole('admin') || $user->hasPermissionTo('categories.manage');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin always has permission, or users with specific permission
        return $user->hasRole('admin') || $user->hasPermissionTo('categories.manage');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MaterialCategory $materialCategory): bool
    {
        // Admin always has permission, or users with specific permission
        return $user->hasRole('admin') || $user->hasPermissionTo('categories.manage');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MaterialCategory $materialCategory): bool
    {
        // Admin always has permission, or users with specific permission
        return $user->hasRole('admin') || $user->hasPermissionTo('categories.manage');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MaterialCategory $materialCategory): bool
    {
        // Admin always has permission, or users with specific permission
        return $user->hasRole('admin') || $user->hasPermissionTo('categories.manage');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MaterialCategory $materialCategory): bool
    {
        // Admin always has permission, or users with specific permission
        return $user->hasRole('admin') || $user->hasPermissionTo('categories.manage');
    }
}
