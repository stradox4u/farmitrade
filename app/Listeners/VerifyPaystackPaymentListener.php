<?php

namespace App\Listeners;

use App\Payment;
use App\Transfer;
use Yabacon\Paystack\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\WebhookReceivedFromPaystackEvent;

class VerifyPaystackPaymentListener implements ShouldQueue
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
                        $payment = Payment::where('paystack_reference', $paystackReference)->first();
                        $payment->update([
                            'payment_successful' => true,
                        ]);

                        logger('Successful payment logged.');

                        $payment->transaction->update(['transaction_status' => 'paid',]);

                        event(new PaymentSuccessfulEvent($payment));
                    }
                break;

                // transfer.success
                case 'transfer.success':
                    if('success' === $action->obj->data->status)
                    {
                        $transfer = Transfer::where('transfer_code', $action->obj->data->transfer_code)->first();

                        logger('Successful transfer logged.');

                        $transfer->update(['transfer_status' => 'successful']);
                    }
                break;

                // transfer.failed
                case 'transfer.failed':
                    if('failed' === $action->obj->data->status)
                    {
                        $transfer = Transfer::where('transfer_code', $action->obj->data->transfer_code)->first();

                        logger('Failed transfer logged.');

                        $transfer->update(['transfer_status' => 'failed']);

                        // Retry transfer
                        event(new RetryTransferEvent($transfer));
                    }
                break;

                // transfer.reversed
                case 'transfer.reversed':
                    if('reversed' === $action->obj->data->status)
                    {
                        $transfer = Transfer::where('transfer_code', $action->obj->data->transfer_code)->first();

                        logger('Reversed transfer logged');

                        $transfer->update(['transfer_status' => 'reversed']);

                        // Retry Transfer
                        event(new RetryTransferEvent($transfer));
                    }
                break;
            }
        }
    }
}
