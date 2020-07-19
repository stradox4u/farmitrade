<?php

namespace App\Listeners;

use App\Events\PaymentSuccessfulEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateListingStatusListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PaymentSuccessfulEvent  $event
     * @return void
     */
    public function handle(PaymentSuccessfulEvent $event)
    {
        $transaction = $event->payment->transaction;

        // Update listing quantity and/or status
        $newQuantity = $transaction->listing->quantity - $transaction->quantity;

        if($newQuantity <= 0)
        {
            $transaction->listing->update([
                'filled' => true,
                'quantity' => 0,
                ]);
        } else 
        {
            $transaction->listing->update(['quantity' => $newQuantity]);
        }
    }
}
