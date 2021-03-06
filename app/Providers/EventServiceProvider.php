<?php

namespace App\Providers;

use App\Events\ListingCreated;
use App\Events\RetryTransferEvent;
use App\Listeners\SendSmsListener;
use App\Events\ProfileCreatedEvent;
use App\Events\ProfileUpdatedEvent;
use App\Events\ProduceReceivedEvent;
use Illuminate\Support\Facades\Event;
use App\Events\PaymentSuccessfulEvent;
use Illuminate\Auth\Events\Registered;
use App\Events\SendNotificationSmsEvent;
use App\Listeners\RetryTransferListener;
use App\Listeners\SendPossibleTransactions;
use App\Listeners\VerifyBankAccountListener;
use App\Listeners\UpdateListingStatusListener;
use App\Events\WebhookReceivedFromPaystackEvent;
use App\Listeners\VerifyPaystackPaymentListener;
use App\Listeners\CreatePaystackRecipientListener;
use App\Listeners\TransferLogisticsPaymentToFarmer;
use App\Listeners\SendBuyerPaymentConfirmationEmail;
use App\Listeners\SendFarmerPaymentConfirmationEmail;
use App\Listeners\TransferProducePaymentToFarmerListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\SendFarmerProduceReceiptConfirmationMailListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ListingCreated::class => [
            SendPossibleTransactions::class,
        ],
        ProfileCreatedEvent::class => [
            VerifyBankAccountListener::class,
        ],
        ProfileUpdatedEvent::class => [
            CreatePaystackRecipientListener::class,
        ],
        PaymentSuccessfulEvent::class => [
            SendBuyerPaymentConfirmationEmail::class,
            SendFarmerPaymentConfirmationEmail::class,
            TransferLogisticsPaymentToFarmer::class,
            UpdateListingStatusListener::class,
        ],
        ProduceReceivedEvent::class => [
            TransferProducePaymentToFarmerListener::class,
            SendFarmerProduceReceiptConfirmationMailListener::class,
        ],
        RetryTransferEvent::class => [
            RetryTransferListener::class,
        ],
        SendNotificationSmsEvent::class => [
            SendSmsListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
