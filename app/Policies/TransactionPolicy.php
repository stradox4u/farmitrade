<?php

namespace App\Policies;

use App\User;
use App\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    /**
     * Determine if the given transaction can be read by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return bool
     */
    public function read(User $user, Transaction $transaction)
    {
        return ($user->id === $transaction->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine if the given transaction can be browsed by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return bool
     */
    public function browse(User $user, Transaction $transaction)
    {
        return ($user->id === $transaction->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine if the given transaction can be edited by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return bool
     */
    public function edit(User $user, Transaction $transaction)
    {
        return ($user->id === $transaction->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine if the given transaction can be deleted by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return bool
     */
    public function delete(User $user, Transaction $transaction)
    {
        return ($user->id === $transaction->user_id || $user->hasRole('admin'));
    }
}
