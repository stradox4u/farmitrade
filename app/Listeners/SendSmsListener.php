<?php

namespace App\Listeners;

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

        // Connect to the BulkSMS api
        $url = "https://www.bulksmsnigeria.com/api/v1/sms/create";

        $fields = [

            'api_token' => config('bulksms.api_key'),

            'from' => 'Farmitrade',

            'to' => $recipient,

            'body' => $message,

            'dnd' => '4',
        ];

        $fields_string = http_build_query($fields);

        //open connection

        $ch = curl_init();

        
        //set the url, number of POST vars, POST data

        curl_setopt($ch,CURLOPT_URL, $url);

        curl_setopt($ch,CURLOPT_POST, true);

        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

            "Authorization: Bearer" . config('bulksms.api_key'),

            "Cache-Control: no-cache",

        ));

        
        //So that curl_exec returns the contents of the cURL; rather than echoing it

        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

        

        //execute post

        $result = curl_exec($ch);

        $response = json_decode($result, true);
        logger($response);
        if($response['data']['status'] == 'success')
        {
            logger('Message successfully sent to ' . $recipient);
        } else
        {
            logger('Message to ' . $recipient . ' failed.');
        }
    }
}
