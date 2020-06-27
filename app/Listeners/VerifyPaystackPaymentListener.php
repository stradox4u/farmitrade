<?php

namespace App\Listeners;

use App\Payment;
use Yabacon\Paystack\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\WebhookReceivedFromPaystackEvent;

class VerifyPaystackPaymentListener
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
     * @param  WebhookReceivedFromPaystackEvent  $event
     * @return void
     */
    public function handle(WebhookReceivedFromPaystackEvent $event)
    {
        $paystackReference = $event->paystackReference;
        $action = Event::capture();
        http_response_code(200);

        $my_keys = ['test' => config('paystack.secret_key')];

        $owner = $action->discoverOwner($my_keys);

        if($owner)
        {
            switch($action->obj->event)
            {
                // charge.success
                case 'charge.success':
                    if('success' === $action->obj->data->status)
                    {
                        $payment = Payment::where('paystack_reference', $paystackReference);
                        $payment->update([
                            'payment_successful' => true,
                        ]);

                        event(new PaymentSuccessfulEvent($payment));
                    }
                break;

                case 'transfer.success':
                    if('success' === $action->obj->data->status)
                    {

                    }
                break;

                case 'transfer.failed':
                    if('failed' === $action->obj->data->status)
                    {

                    }
                break;
            }
        }
    }
}
