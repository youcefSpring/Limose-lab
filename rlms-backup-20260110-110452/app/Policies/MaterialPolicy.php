<?php

namespace App\Policies;

use App\Models\Material;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MaterialPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('materials.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Material $material): bool
    {
        return $user->can('materials.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('materials.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Material $material): bool
    {
        return $user->can('materials.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Material $material): bool
    {
        return $user->can('materials.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Material $material): bool
    {
        return $user->can('materials.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Material $material): bool
    {
        return $user->can('materials.force-delete');
    }
}
