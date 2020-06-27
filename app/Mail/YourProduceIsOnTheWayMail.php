<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class YourProduceIsOnTheWayMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;
    public $buyer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction, $buyer)
    {
        $this->transaction = $transaction;
        $this->buyer = $buyer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Produce Is On The Way')
                    ->from('admin@farmitrade.com.ng')
                    ->markdown('emails.shipped');
    }
}
