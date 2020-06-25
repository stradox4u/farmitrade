<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterestInYourListingMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $relevantListing;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($relevantListing, $user)
    {
        $this->relevantListing = $relevantListing;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Someone is Interested in Your Listing')
                    ->from('admin@farmitrade.com.ng')
                    ->markdown('emails.interest-mail');
    }
}
