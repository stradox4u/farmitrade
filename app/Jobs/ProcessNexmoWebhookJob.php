<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessNexmoWebhookJob extends SpatieProcessWebhookJob implements ShouldQueue
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

        $recipient = $payload['msisdn'];
        $status = $payload['status'];
        $code = $payload['err-code'];

        if($status == 'delivered')
        {
            logger($recipient . ': Text message, delivered successfully');
        } else 
        {
            logger($recipient . ': Problem delivering text message. Error is:' . $status . '. Error code:' . $code);
        }
    }
}
