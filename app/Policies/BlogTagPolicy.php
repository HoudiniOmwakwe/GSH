<?php

namespace App\Policies;

use App\Models\BlogTag;
use App\Models\User;

class BlogTagPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view blog');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BlogTag $blogTag): bool
    {
        return $user->can('view blog');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create blog');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BlogTag $blogTag): bool
    {
        return $user->can('update blog');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BlogTag $blogTag): bool
    {
        return $user->can('delete blog');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BlogTag $blogTag): bool
    {
        return $user->can('delete blog');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BlogTag $blogTag): bool
    {
        return $user->can('delete blog');
    }
}
