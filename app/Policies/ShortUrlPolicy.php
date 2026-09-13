<?php

namespace App\Policies;

use App\Models\ShortUrl;
use App\Models\User;


class ShortUrlPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShortUrl $shortUrl): bool
    {
        if ($user->isSuperAdmin()){
            return true;
        }
        if($user->isAdmin()){
            return $user->company_id === $shortUrl->company_id;
        }
        if ($user->isMember()){
            return $user->id === $shortUrl->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isMember();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShortUrl $shortUrl): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShortUrl $shortUrl): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShortUrl $shortUrl): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShortUrl $shortUrl): bool
    {
        return false;
    }
}
