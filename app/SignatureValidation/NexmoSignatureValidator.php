<?php

namespace App\SignatureValidation;

use Nexmo\Client\Signature;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;


class NexmoSignatureValidator implements \Spatie\WebhookClient\SignatureValidator\SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        logger($this->webhookCall);
        $inbound = \Nexmo\Message\InboundMessage::createFromGlobals();
        if($inbound->isValid())
        {
            $params = $inbound->getRequestData();
            logger($params);
            $signature = new Signature(
                $params,
                config('nexmo.signature_secret'),
                'md5hash'
            );
            $validSig = $signature->check($params['sig']);
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
}