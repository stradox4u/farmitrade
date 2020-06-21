<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PossibleTransactionsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $listing;
    public $user;
    public $relevantListings;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($listing, $user, $relevantListings)
    {
        $this->listing = $listing;
        $this->user = $user;
        $this->relevantListings = $relevantListings;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Possible Transactions on Your Last Listing')
                    ->from('admin@farmitrade.com.ng')
                    ->markdown('emails.possible-transactions');
    }
}
