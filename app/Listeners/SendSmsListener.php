<?php

namespace App\Listeners;

use App\Mail\NexmoBalanceLowMail;
use Nexmo\Client\Credentials\Basic;
use Illuminate\Support\Facades\Mail;
use App\Events\SendNotificationSmsEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSmsListener implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle(SendNotificationSmsEvent $event)
    {
        $recipient = $event->recipient;
        $message = $event->message;

        $basic  = new Basic(config('nexmo.api_key'), config('nexmo.secret'));
        $client = new \Nexmo\Client($basic);


        try {
            $message = $client->message()->send([
                'to' => $recipient,
                'from' => 'Farmitrade NG',
                'text' => $message,
            ]);
            $response = $message->getResponseData();
        
            if($response['messages'][0]['status'] == 0) {
                logger('SMS sent successfully to ' . $recipient);
            } else {
                logger('The message to ' . $recipient . ' failed with status: ' . $response['messages'][0]['status']);
            }

            if($response['messages'][0]['remaining-balance'] <= 1)
            {
                Mail::to('smsmanager@farmitrade.com.ng')->send(new NexmoBalanceLowMail);
            }
        } catch (Exception $e) {
            logger('The message to ' . $recipient . ' was not sent. Error: ' . $e->getMessage());
        }
    }
}
