<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Events\PaymentSuccessfulEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBuyerPaymentConfirmationEmail implements ShouldQueue
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
     * @param  PaymentSuccessfulEvent  $event
     * @return void
     */
    public function handle(PaymentSuccessfulEvent $event)
    {
        $payment = $event->payment;
        if($payment->insurance_paid == true)
        {
            // Transfer the insurance premium to the insurer

            // Send the insurer an email notifying them of the same
        }
    }
}
