<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Events\PaymentSuccessfulEvent;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\BuyerPaymentConfirmationEmail;
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
        if($payment->transaction->user->user_type == 'buyer')
        {
            Mail::to($payment->transaction->user->email)->send(new BuyerPaymentConfirmationEmail($payment));
        } else 
        {
            Mail::to($payment->transaction->listing->user->email)->send(new BuyerPaymentConfirmationEmail($payment));
        }
    }
}
