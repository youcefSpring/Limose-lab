<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('users.index');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can('users.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('users.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Users can update their own profile
        if ($user->id === $model->id) {
            return true;
        }

        return $user->can('users.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Cannot delete yourself
        if ($user->id === $model->id) {
            return false;
        }

        return $user->can('users.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->can('users.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->can('users.force-delete');
    }

    /**
     * Determine whether the user can approve other users.
     */
    public function approve(User $user): bool
    {
        return $user->can('users.approve');
    }

    /**
     * Determine whether the user can suspend other users.
     */
    public function suspend(User $user, User $model): bool
    {
        // Cannot suspend yourself
        if ($user->id === $model->id) {
            return false;
        }

        return $user->can('users.suspend');
    }

    /**
     * Determine whether the user can ban other users.
     */
    public function ban(User $user, User $model): bool
    {
        // Cannot ban yourself
        if ($user->id === $model->id) {
            return false;
        }

        return $user->can('users.ban');
    }
}
