<?php

namespace App\Policies;

use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view media');
    }

    public function view(User $user, Media $media): bool
    {
        return $user->can('view media');
    }

    public function create(User $user): bool
    {
        return $user->can('create media');
    }

    public function update(User $user, Media $media): bool
    {
        return $user->can('update media');
    }

    public function delete(User $user, Media $media): bool
    {
        return $user->can('delete media');
    }

    public function restore(User $user, Media $media): bool
    {
        return $user->can('delete media');
    }

    public function forceDelete(User $user, Media $media): bool
    {
        return $user->can('delete media');
    }
}
