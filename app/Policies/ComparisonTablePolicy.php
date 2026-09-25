<?php

namespace App\Policies;

use App\Models\ComparisonTable;
use App\Models\User;

class ComparisonTablePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view comparison-tables');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ComparisonTable $comparisonTable): bool
    {
        return $user->can('view comparison-tables');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create comparison-tables');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ComparisonTable $comparisonTable): bool
    {
        return $user->can('update comparison-tables');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ComparisonTable $comparisonTable): bool
    {
        return $user->can('delete comparison-tables');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ComparisonTable $comparisonTable): bool
    {
        return $user->can('delete comparison-tables');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ComparisonTable $comparisonTable): bool
    {
        return $user->can('delete comparison-tables');
    }
}
