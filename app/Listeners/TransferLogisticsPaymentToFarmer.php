<?php

namespace App\Listeners;

use App\Events\PaymentSuccessfulEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TransferLogisticsPaymentToFarmer implements ShouldQueue
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
        // Get recipient code of the farmer in the relevant transaction
        if($event->payment->transaction->user->user_type == 'farmer')
        {
            $recipientCode = $event->payment->transaction->user->profile->recipient_code;
        } else 
        {
            $recipientCode = $event->payment->transaction->listing->user->recipient_code;
        }

        // Make a call to the Paystack Transfer Api to make the transfer
        $url = "https://api.paystack.co/transfer";

        $fields = [

            'source' => 'balance',

            'amount' => $event->payment->transaction->price_of_logistics,

            'recipient' => $recipientCode,

            'reason' => 'logistics for-' . $event->payment->transaction->transaction_id_for_paystack,
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
        $transaction = $event->payment->transaction;
        $transfer = $transaction->transfers()->create([
            'transfer_purpose' => 'logistics for-' . $transaction->transaction_id_for_paystack,
            'amount' => $transaction->price_of_logistics,
            'reference' => $reference,
            'transfer_code' => $transferCode,
        ]);
    }
}
