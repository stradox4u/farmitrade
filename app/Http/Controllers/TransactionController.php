<?php

namespace App\Http\Controllers;

use App\Listing;
use App\Transaction;
use Illuminate\Http\Request;
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

        // Create Transaction
        $transaction =  new Transaction([
            'transaction_status' => 'processing',
        ]);

        // Retrieve Relevant Listing
        $relevantListing = Listing::where('id', $request['relevant_listing'])->first();

        // Recursively Save Relationships
        $transaction->user_id = $user->id;
        $transaction->listing_id = $relevantListing->id;

        $transaction->push();

        // Send Email to Poster of Listing
        Mail::to($relevantListing->user->email)->send(new InterestInYourListingMail($relevantListing, $user));

        // Link both parties to chat over Twilio

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
