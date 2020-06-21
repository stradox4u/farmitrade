<?php

namespace App\Listeners;

use App\Listing;
use App\Events\ListingCreated;
use Illuminate\Support\Facades\Mail;
use App\Mail\PossibleTransactionsMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPossibleTransactions
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
     * @param  ListingCreated  $event
     * @return void
     */
    public function handle(ListingCreated $event)
    {
        // Take in the listing and user from the event
        $listing = $event->listing;
        $user = $event->user;

        // Get relevant listings from database
        $relevantListings = Listing::where([
            ['produce', $listing->produce],
            ['buy_sell', 'sell'],
            ['filled', false],
        ])->take(7)->get();

        if($relevantListings !== null)
        {
            // Send email to listing poster showing listings that could fill his listing
            Mail::to($user->email)->send(new PossibleTransactionsMail($listing, $user, $relevantListings));
        }


    }
}
