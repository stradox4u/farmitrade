<?php

namespace App\Providers;

use App\Events\ListingCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendPossibleTransactions;
use App\Events\WebhookReceivedFromPaystackEvent;
use App\Listeners\VerifyPaystackPaymentListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
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
        WebhookReceivedFromPaystackEvent::class => [
            VerifyPaystackPaymentListener::class,
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
