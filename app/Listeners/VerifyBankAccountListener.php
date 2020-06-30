<?php

namespace App\Listeners;

use App\Bank;
use App\Events\ProfileCreatedEvent;
use App\Events\ProfileUpdatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyBankAccountListener implements ShouldQueue
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
     * @param  ProfileCreatedEvent  $event
     * @return void
     */
    public function handle(ProfileCreatedEvent $event)
    {
        // Connect to Paystack Api to verify account number
        $accountNumber = $event->profile->account_number;
        $bank = Bank::where('bank_name', 'like', $event->profile->bank_name)->first();
        $bankCode = $bank->code;
        $curl = curl_init();

        curl_setopt_array($curl, array(

            CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number= . $accountNumber . &bank_code= . $bankCode . ",

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_ENCODING => "",

            CURLOPT_MAXREDIRS => 10,

            CURLOPT_TIMEOUT => 30,

            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

            CURLOPT_CUSTOMREQUEST => "GET",

            CURLOPT_HTTPHEADER => array(

            "Authorization: Bearer " .  config('paystack.secret_key'),

            "Cache-Control: no-cache",

            ),

        ));

        

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        

        if ($err) {

            logger ("cURL Error #:" . $err);

        } else {

            $result = json_decode($response, true);

            // Update account_verified status in database
            if($result['message'] == 'Account number resolved')
            {
                $profile = $event->profile->update(['account_verified' => true]);
                
                event(new ProfileUpdatedEvent($profile));

                logger($event->profile->user->name . ' has had their account verified.');
            }
            
        }
    }
}
