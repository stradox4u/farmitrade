<?php

namespace App\Policies;

use App\User;
use App\Listing;
use Illuminate\Auth\Access\HandlesAuthorization;

class ListingPolicy
{
    /**
     * Determine if the given listing can be read by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Listing  $listing
     * @return bool
     */
    public function read(User $user, Listing $listing)
    {
        return ($user->id === $listing->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine if the given listing can be browsed by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Listing  $listing
     * @return bool
     */
    public function browse(User $user, Listing $listing)
    {
        return ($user->id === $listing->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine if the given listing can be edited by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Listing  $listing
     * @return bool
     */
    public function edit(User $user, Listing $listing)
    {
        return ($user->id === $listing->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine if the given listing can be deleted by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Listing  $listing
     * @return bool
     */
    public function delete(User $user, Listing $listing)
    {
        return ($user->id === $listing->user_id || $user->hasRole('admin'));
    }
}
