<?php

namespace App\Listeners;

use App\Bank;
use App\Profile;
use App\Events\ProfileCreatedEvent;
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
    
        // logger($profile);
        if($profile->account_verified == false)
        {
            event(new ProfileCreatedEvent($profile));
        } else 
        {

            // Connect to Paystack Api to generate recipient code
            $url = "https://api.paystack.co/transferrecipient";

            $bank = Bank::where('name', 'like', $profile->bank_name)->first();
            $bankCode = $bank->code;

            $fields = [

                'type' => "nuban",

                'name' => $profile->user->name,

                'account_number' => $profile->account_number,

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

                $profile->update([
                    'recipient_code' => $recipientCode,
                    'bank_name' => Hash::make($profile->bank_name),
                    'account_number' => Hash::make($profile->account_number),
                ]);

                logger($profile->user->name . ' has generated a recipient code. The code is ' . $recipientCode);
            }
        }
    }
}
