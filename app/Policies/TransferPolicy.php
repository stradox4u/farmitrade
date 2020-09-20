<?php

namespace App\Policies;

use App\User;
use App\Transfer;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferPolicy
{
    /**
     * Determine if the given transfer can be read by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Transfer  $transfer
     * @return bool
     */
    public function read(User $user, Transfer $transfer)
    {
        return ($user->hasRole('admin'));
    }

    /**
     * Determine if the given transfer can be browsed by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Transfer  $transfer
     * @return bool
     */
    public function browse(User $user, Transfer $transfer)
    {
        return ($user->hasRole('admin'));
    }

    /**
     * Determine if the given transfer can be edited by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Transfer  $transfer
     * @return bool
     */
    public function edit(User $user, Transfer $transfer)
    {
        return ($user->hasRole('admin'));
    }

    /**
     * Determine if the given transfer can be deleted by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Transfer  $transfer
     * @return bool
     */
    public function delete(User $user, Transfer $transfer)
    {
        return ($user->hasRole('admin'));
    }
}
