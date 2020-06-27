<?php

namespace App\Http\Controllers;

use App\Listing;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
use App\Mail\MakePaymentNowEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\InterestInYourListingMail;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request['relevant_listing']);
        $user = auth()->user();

        // Retrieve Relevant Listing
        $relevantListing = Listing::where('id', $request['relevant_listing'])->first();

        // Create Transaction
        $transaction =  new Transaction([
            'transaction_status' => 'processing',
            'produce' => $relevantListing->produce,
            'unit' => $relevantListing->unit,
        ]);


        // Recursively Save Relationships
        $transaction->user_id = $user->id;
        $transaction->listing_id = $relevantListing->id;

        $transaction->push();

        // Send Email to Poster of Listing
        Mail::to($relevantListing->user->email)->send(new InterestInYourListingMail($relevantListing, $user));

        // Return view with success notification
        request()->session()->flash('success', 'The poster has been contacted successfully.');
        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        if(auth()->user()->user_type == 'buyer')
        {
            if(($transaction->user_id == auth()->id() || $transaction->listing->user_id == auth()->id()))
            {
                $transaction = Transaction::where('id', $transaction->id)->first();
                return view('transactions.show', compact('transaction'));
            }
        } else
        {
            request()->session()->flash('warning', 'Sorry, only the relevant buyer is allowed access to this page.');
            return back();
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        if(auth()->user()->user_type == 'farmer')
        {
            if(($transaction->user_id == auth()->id() || $transaction->listing->user_id == auth()->id()))
            {
                $transaction = Transaction::where('id', $transaction->id)->first();
                return view('transactions.edit', compact('transaction'));
            }
        } else 
        {
            request()->session()->flash('warning', 'Sorry, only the relevant farmer is allowed access to this page.');
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'produce' => ['required', 'string', 'max:85'],
            'unit' => ['required', 'string', 'max:85'],
            'quantity' => ['required', 'numeric'],
            'price_of_goods' => ['numeric', 'required'],
            'price_of_logistics' => ['numeric', 'required'],
            'delivery_timeframe' => ['numeric', 'required'],
        ]);

        // Calculate Insurance Premium based on 0.65% of value of goods
        $insurancePremium = round($data['price_of_goods'] * 0.0065 * 100);

        // Calculate Platform Fee based on 5% of value of goods
        $platformFee = round($data['price_of_goods'] * 0.05 * 100);

        // Convert prices to kobo before putting to database---------
        $goodsPrice = round($data['price_of_goods'] * 100);
        $logisticsPrice = round($data['price_of_logistics'] * 100);

        // Generate a unique transaction id
        $transactionId = $transaction->user_id . '-' . $transaction->listing->user_id . '-' . $transaction->produce . '/' . $transaction->quantity . '/' . $transaction->unit . '-' . Carbon::now()->toDateTimeString();

        // Update Transaction in database
        $transaction->update([
            'produce' => $data['produce'],
            'unit' => $data['unit'],
            'quantity' => $data['quantity'],
            'price_of_goods' => $goodsPrice,
            'price_of_logistics' => $logisticsPrice,
            'insurance_premium' => $insurancePremium,
            'platform_fee' => $platformFee,
            'transaction_id_for_paystack' => $transactionId,
            'delivery_timeframe' => $data['delivery_timeframe'],
        ]);

        if($transaction->user->user_type == 'buyer')
        {
            $buyerEmail = $transaction->user->email;
        } else
        {
            $buyerEmail = $transaction->listing->user->email;
        }

        // Send buyer email with link with which to make payment
        Mail::to($buyerEmail)->send(new MakePaymentNowEmail($transaction));

        return redirect(route('home'));
    }
}
