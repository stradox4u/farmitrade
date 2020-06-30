<?php

namespace App\Listeners;

use App\Events\ProduceReceivedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransferProducePaymentToFarmerListener implements ShouldQueue
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
     * @param  object ProduceReceivedEvent $event
     * @return void
     */
    public function handle(ProduceReceivedEvent $event)
    {
        // Get recipient code of the farmer in the relevant transaction
        if($event->transaction->user->user_type == 'farmer')
        {
            $recipientCode = $event->transaction->user->profile->recipient_code;
        } else 
        {
            $recipientCode = $event->transaction->listing->user->recipient_code;
        }

        // Make a call to the Paystack Transfer Api to make the transfer
        $url = "https://api.paystack.co/transfer";

        $fields = [

            'source' => 'balance',

            'amount' => $event->transaction->price_of_goods,

            'recipient' => $recipientCode,

            'reason' => 'produce payment-' . $event->transaction->transaction_id_for_paystack,
        ];

        $fields_string = http_build_query($fields);

        //open connection

        $ch = curl_init();

        
        //set the url, number of POST vars, POST data

        curl_setopt($ch,CURLOPT_URL, $url);

        curl_setopt($ch,CURLOPT_POST, true);

        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

            "Authorization: Bearer " . config('paystack.secret_key'),

            "Cache-Control: no-cache",

        ));

        
        //So that curl_exec returns the contents of the cURL; rather than echoing it

        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

        

        //execute post

        $result = curl_exec($ch);

        $response = json_decode($result, true);
        $reference = $response['data']['reference'];
        $transferCode = $response['data']['transfer_code'];

        // Put Transfer to Table
        $transaction = $event->transaction;
        $transfer = $transaction->transfers()->create([
            'transfer_purpose' => 'produce-' . $transaction->transaction_id_for_paystack,
            'amount' => $transaction->price_of_goods,
            'reference' => $reference,
            'transfer_code' => $transferCode,
        ]);
    }
}
