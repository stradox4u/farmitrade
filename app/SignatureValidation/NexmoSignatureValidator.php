<?php

namespace App\SignatureValidation;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;


class NexmoSignatureValidator implements \Spatie\WebhookClient\SignatureValidator\SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        logger($request);
        return($_SERVER['HTTP_SIG'] == hash_hmac('sha256', file_get_contents('php://input'), config('nexmo.signature_secret')));
    }
}