<?php

namespace App\Policies;

use App\Models\Casino;
use App\Models\User;

class CasinoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view casinos');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Casino $casino): bool
    {
        return $user->can('view casinos');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create casinos');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Casino $casino): bool
    {
        return $user->can('update casinos');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Casino $casino): bool
    {
        return $user->can('delete casinos');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Casino $casino): bool
    {
        return $user->can('delete casinos');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Casino $casino): bool
    {
        return $user->can('delete casinos');
    }
}
