<?php

namespace App\Listeners;

use App\Events\ProduceReceivedEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\ProduceReceiptConfirmationMail;

class SendFarmerProduceReceiptConfirmationMailListener implements ShouldQueue
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
     * @param  object ProduceReceivedEvent $event
     * @return void
     */
    public function handle(ProduceReceivedEvent $event)
    {
        // Get the farmer in the transaction
        $transaction = $event->transaction;
        if($transaction->user->user_type == 'farmer')
        {
            $farmer = $transaction->user;
        } else 
        {
            $farmer = $transaction->listing->user;
        }

        // Send Email
        Mail::to($farmer->email)->send(new ProduceReceiptConfirmationMail($farmer, $transaction));
    }
}
