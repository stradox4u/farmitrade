<?php

namespace App\SignatureValidation;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;

interface SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool;

}

class PaystackSignatureValidator implements \Spatie\WebhookClient\SignatureValidator\SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        return($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] == hash_hmac('sha512', file_get_contents('php://input'), env('PAYSTACK_SECRET_KEY')));
    }
}