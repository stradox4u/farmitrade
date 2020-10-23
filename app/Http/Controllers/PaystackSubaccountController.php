<?php

namespace App\Http\Controllers;

use App\Bank;
use App\PaystackSubaccount;
use Illuminate\Http\Request;

class PaystackSubaccountController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subaccount.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request data
        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:85'],
            'settlement_bank' => ['required', 'string', 'max:85'],
            'account_number' => ['required', 'string', 'size:10'],
            'percentage_charge' => ['required', 'numeric'],
            'description' => ['required', 'string', 'max:85'],
        ]);

        // Get the bank Code
        $bankCode = Bank::where('name', $data['settlement_bank'])->pluck('code');
        // dd($bankCode);

        // Hit the Paystack api
        $url = "https://api.paystack.co/subaccount";

        $fields = [
            'business_name' => $data['business_name'],
            'settlement_bank' => $bankCode['0'],
            'account_number' => $data['account_number'],
            'percentage_charge' => $data['percentage_charge'],
            'description' => $data['description']
        ];

        $fields_string = http_build_query($fields);

        // open connection
        $ch = curl_init();

        // set the url, number of POST vars, POST data
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

        $response = curl_exec($ch);
        $result = json_decode($response, true);
        // dd($result);

        if($result['status'] === true)
        {
            PaystackSubaccount::updateOrCreate([
                'business_name' => $data['business_name'],
                'settlement_bank' => $bankCode,
                'account_number' => $data['account_number'],
                'percentage_charge' => $data['percentage_charge'],
                'description' => $data['description'],
                'subaccount_code' => $result['data']['subaccount_code']
            ]);
            request()->session()->flash('success', $result['message']);
            return back();
        } else
        {
            request()->session()->flash('warning', $result['message']);
            return back();
        }
    }

}
