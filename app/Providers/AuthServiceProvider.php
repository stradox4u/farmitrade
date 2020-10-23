<?php

namespace App\Providers;


use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Listing::class => ListingPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Payment::class => PaymentPolicy::class,
        Transfer::class => TransferPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('edit-profile', function($user)
        {
            return $user->canEdit($user->profile);
        });

        Gate::define('create-subaccount', function($user)
        {
            return $user->hasRole('admin');
        });
    }
}
