<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GoodsInTransitClosedNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;
    public $farmer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction, $farmer)
    {
        $this->transaction = $transaction;
        $this->farmer = $farmer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->transaction->transaction_id_for_paystack . ' G.I.T Closed.')
                    ->from('insurancecontact@farmitrade.com.ng')
                    ->markdown('emails.git-closed');
    }
}
