<?php

namespace App\SignatureValidation;

use Nexmo\Client\Signature;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;


class NexmoSignatureValidator implements \Spatie\WebhookClient\SignatureValidator\SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
            $signature = new Signature(
                $request,
                config('nexmo.signature_secret'),
                'md5hash'
            );
            $validSig = $signature->check($request['sig']);
            if($validSig)
            {
                logger('Webhook Processed Successfully');
                return true;
            } else 
            {
                return false;
            }
    }
}