<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Transaction;
use Yabacon\Paystack;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payNow(Request $request)
    {
        // dd(request('amount'));
        $data = $request->validate([
            'email' => ['email', 'required'],
            'orderId' => ['string', 'required'],
            'amount' => ['numeric', 'required'],
            'metadata' => ['string', 'required'],
            'with_insurance' => ['string', 'nullable'],
            'no_insurance' => ['string', 'nullable'],
            'insurance_paid' => ['string', 'required'],
        ]);
            
        // Calculate Paystack Fee to Add to the amount payable
        if($data['amount'] < 250000)
        {
            $paystackFee = round($data['amount'] * 0.015);
        } else
        {
            $paystackFee = round(($data['amount'] * 0.015) + 10000);
        }
        // dd($paystackFee);
        if($paystackFee > 200000)
        {
            $paystackFee = 200000;
        }

        $amount = $data['amount'] + $paystackFee;

        // Initialize transaction
        $paystack = new Paystack(config('paystack.secret_key'));

        try
        {
            $tranx = $paystack->transaction->initialize([
                'email' => $data['email'],
                'orderId' => $data['orderId'],
                'amount' => $amount,
                'metadata' => $data['metadata'],
            ]);
        } catch(\Yabacon\Paystack\Exception\ApiException $e)
        {
            logger($e->getResponseObject());
            request()->session()->flash('error', $e->getMessage());
            return route('home');
        }

        // Put payment to database
        $transaction = Transaction::where('transaction_id_for_paystack', $data['orderId'])->first();
        if($data['insurance_paid'] == 'false')
        {
            $insurancePaid = false;
        } else 
        {
            $insurancePaid = true;
        }
        
        $payment = $transaction->payment()->create([
            'paystack_reference' => $tranx->data->reference,
            'total_amount' => $amount,
            'paystack_fee' => $paystackFee,
            'insurance_paid' => $insurancePaid,
        ]);

        $transaction->update([
            'insurance_premium_paid' => $insurancePaid,
            ]);
        // dd($tranx->data);
        // Redirect to Paystack Checkout
        return redirect($tranx->data->authorization_url);
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback(Request $request)
    {
        $reference = $request->input('reference');
        if($reference)
        {
            $paystack = new Paystack(config('paystack.secret_key'));
            try
            {
                $tranx = $paystack->transaction->verify([
                    'reference' => $reference,
                ]);
            } catch(\Yabacon\Paystack\Exception\ApiException $e)
            {
                logger($e->getMessage());
            }

            if('success' === $tranx->data->status)
            {
                $payment = Payment::where('paystack_reference', $reference);
                $payment->update([
                    'payment_successful' => true,
                ]);
            }
        }
        return view('transactions.success');
    }
}
