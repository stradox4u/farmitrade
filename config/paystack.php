<?php

return [

    /*
    Paystack Access Keys and Configurations
    */

    'public_key' => env('PAYSTACK_PUBLIC_KEY'),
    'secret_key' => env('PAYSTACK_SECRET_KEY'),
    'url' => env('PAYSTACK_PAYMENT_URL'),
    'merchant_email' => env('MERCHANT_EMAIL'),

];
