<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MakePaymentNowEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Make Payment Now')
                    ->from('admin@farmitrade.com.ng')
                    ->markdown('emails.make-payment');
    }
}
