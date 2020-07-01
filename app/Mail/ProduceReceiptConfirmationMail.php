<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProduceReceiptConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $farmer;
    public $transaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($farmer, $transaction)
    {
        $this->farmer = $farmer;
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your goods have been received and payment made')
                    ->from('admin@farmitrade.com.ng')
                    ->markdown('emails.produce-received');
    }
}
