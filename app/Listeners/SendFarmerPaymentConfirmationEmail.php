<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Events\PaymentSuccessfulEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\FarmerPaymentConfirmationEmail;

class SendFarmerPaymentConfirmationEmail implements ShouldQueue
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

        if($payment->transaction->user->user_type == 'farmer')
        {
            Mail::to($payment->transaction->user->email)->send(new FarmerPaymentConfirmationEmail($payment));
        } else 
        {
            Mail::to($payment->transaction->listing->user->email)->send(new FarmerPaymentConfirmationEmail($payment));
        }
    }
}
