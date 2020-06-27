<?php

namespace App\Jobs;

use App\Bank;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PopulateBanksTableJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(

            CURLOPT_URL => 'https://api.paystack.co/bank',

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_ENCODING => "",

            CURLOPT_MAXREDIRS => 10,

            CURLOPT_TIMEOUT => 30,

            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

            CURLOPT_CUSTOMREQUEST => "GET",

            CURLOPT_HTTPHEADER => array(

            "Authorization: Bearer SECRET_KEY",

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
            $banks = $result['data'];

            foreach($banks as $bank)
            {
                logger($bank['name']);
                $institution = Bank::create([
                    'name' => $bank['name'],
                    'slug' => $bank['slug'],
                    'code' => $bank['code'],
                    'longcode' => $bank['longcode'],
                ]);
            }
        }
    }
}

