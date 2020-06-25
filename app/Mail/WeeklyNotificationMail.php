<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WeeklyNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $relevantListings;
    public $myOpenListings;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $relevantListings, $myOpenListings)
    {
        $this->user = $user;
        $this->relevantListings = $relevantListings;
        $this->myOpenListings = $myOpenListings;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $now = Carbon::now();
        $date = $now->toFormattedDateString(); 
        return $this->subject('Weekly Communications: ' . $date)
                    ->from('admin@farmitrade.com.ng')
                    ->markdown('emails.weekly-mail');
    }
}
