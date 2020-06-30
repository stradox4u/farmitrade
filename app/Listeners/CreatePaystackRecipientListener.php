<?php

namespace App\Listeners;

use App\Bank;
use App\Events\ProfileUpdatedEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePaystackRecipientListener implements ShouldQueue
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
     * @param  ProfileUpdatedEvent  $event
     * 
     * @return void
     */
    public function handle(ProfileUpdatedEvent $event)
    {
        // Check if the user's account has been verified, and do so if not
        $profile = $event->profile;
        if(!$event->profile->account_verified)
        {
            event(new ProfileCreatedEvent($profile));
        }

        // Connect to Paystack Api to generate recipient code
        $url = "https://api.paystack.co/transferrecipient";

        $bank = Bank::where('bank_name', 'like', $event->profile->bank_name)->first();
        $bankCode = $bank->code;

        $fields = [

            'type' => "nuban",

            'name' => $event->profile->user->name,

            'account_number' => $event->profile->account_number,

            'bank_code' => $bankCode,

            'currency' => "NGN"

        ];

        $fields_string = http_build_query($fields);

        //open connection

        $ch = curl_init();

        

        //set the url, number of POST vars, POST data

        curl_setopt($ch,CURLOPT_URL, $url);

        curl_setopt($ch,CURLOPT_POST, true);

        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

            "Authorization: Bearer " .  config('paystack.secret_key'),

            "Cache-Control: no-cache",

        ));

        

        //So that curl_exec returns the contents of the cURL; rather than echoing it

        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

        

        //execute post

        $result = curl_exec($ch);

        $response = json_decode($result, true);

        // Put recipient code to database
        if($response['message'] == 'Transfer recipient created successfully')
        {
            $recipientCode = $response['data']['recipient_code'];

            $event->profile->update([
                'recipient_code' => $recipientCode,
                'bank_name' => Hash::make($event->profile->bank_name),
                'account_number' => Hash::make($event->profile->account_number),
            ]);

            logger($event->profile->user->name . ' has generated a recipient code. The code is ' . $recipientCode);
        }
    }
}
