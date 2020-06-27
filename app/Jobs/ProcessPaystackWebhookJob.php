<?php

namespace App\Jobs;

use Yabacon\Paystack;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
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

        event(new WebhookReceivedFromPaystackEvent($paystackReference));
    }
}
