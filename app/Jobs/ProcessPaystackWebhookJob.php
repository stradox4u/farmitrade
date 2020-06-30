<?php

namespace App\Jobs;

use App\Payment;
use App\Transfer;
use Yabacon\Paystack;
use Yabacon\Paystack\Event;
use Illuminate\Bus\Queueable;
use App\Events\RetryTransferEvent;
use Illuminate\Support\Collection;
use App\Events\PaymentSuccessfulEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Events\WebhookReceivedFromPaystackEvent;
use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessPaystackWebhookJob extends SpatieProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ($this->webhookCall);

        $payload = json_decode($this->webhookCall, true)['payload'];

        $paystackReference = $payload['data']['reference'];

        logger($paystackReference);

        // event(new WebhookReceivedFromPaystackEvent($paystackReference));
        $action = Event::capture();
        http_response_code(200);
        logger($action->obj);

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
