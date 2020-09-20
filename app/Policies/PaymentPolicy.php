<?php

namespace App\Policies;

use App\Payment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
     /**
     * Determine if the given payment can be read by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return bool
     */
    public function read(User $user, Payment $payment)
    {
        return ($user->id === $payment->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine if the given payment can be browsed by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return bool
     */
    public function browse(User $user, Payment $payment)
    {
        return ($user->id === $payment->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine if the given payment can be edited by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return bool
     */
    public function edit(User $user, Payment $payment)
    {
        return ($user->id === $payment->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine if the given payment can be deleted by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Payment  $payment
     * @return bool
     */
    public function delete(User $user, Payment $payment)
    {
        return ($user->id === $payment->user_id || $user->hasRole('admin'));
    }
}
