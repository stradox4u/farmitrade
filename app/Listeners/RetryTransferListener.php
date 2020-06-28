<?php

namespace App\Listeners;

use App\Events\RetryTransferEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetryTransferListener implements ShouldQueue
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
     * @param  object RetryTransferEvent $event
     * @return void
     */
    public function handle(RetryTransferEvent $event)
    {
        $transfer = $event->transfer;

        if($transfer->transaction->user->user_type == 'farmer')
        {
            $recipientCode = $transfer->transaction->user->profile->recipient_code;
        } else 
        {
            $recipientCode = $transfer->transaction->listing->user->profile->recipient_code;
        }

        // Make a call to the Paystack Transfer Api to make the transfer
        $url = "https://api.paystack.co/transfer";

        $fields = [

            'source' => 'balance',

            'amount' => $event->transaction->price_of_goods,

            'recipient' => $recipientCode,

            'reason' => $transfer->transfer_purpose,

            'reference' => $transfer->reference,
        ];

        $fields_string = http_build_query($fields);

        //open connection

        $ch = curl_init();

        
        //set the url, number of POST vars, POST data

        curl_setopt($ch,CURLOPT_URL, $url);

        curl_setopt($ch,CURLOPT_POST, true);

        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

            "Authorization: Bearer SECRET_KEY",

            "Cache-Control: no-cache",

        ));

        
        //So that curl_exec returns the contents of the cURL; rather than echoing it

        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

        

        //execute post

        $result = curl_exec($ch);

        $response = json_decode($result, true);
        logger($response);
    }
}
