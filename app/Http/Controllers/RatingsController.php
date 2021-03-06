<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($transaction)
    {
        return view('ratings.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        // dd($request);
        $rating = $request['starRating'];
        
        // If the user has already rated the other party on this transaction, bounce them back
        if(auth()->user()->user_type == 'farmer' && $transaction->buyer_is_rated == true)
        {
            request()->session()->flash('warning', 'Sorry, we already have your rating on this transaction.');
            return back();
        }

        if(auth()->user()->user_type == 'buyer' && $transaction->farmer_is_rated == true)
        {
            request()->session()->flash('warning', 'Sorry, we already have your rating on this transaction.');
            return back();
        }
        
        // Fetch the user to rate
        if($transaction->user == auth()->user())
        {
            $user = $transaction->listing->user;
        } else 
        {
            $user = $transaction->user;
        }

        $user->rate($rating);

        // Update the transaction to show who has been rated
        if(auth()->user()->user_type == 'farmer')
        {
            $transaction->update(['buyer_is_rated' => true]);
        } else 
        {
            $transaction->update(['farmer_is_rated' => true]);
        }
        // dd($user->averageRating());
        request()->session()->flash('success', 'Thanks, your rating has been saved.');
        return redirect(route('transaction.index', auth()->id()));
    }
}
