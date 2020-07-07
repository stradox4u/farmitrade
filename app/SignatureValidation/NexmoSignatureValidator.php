<?php

namespace App\SignatureValidation;

use Nexmo\Client\Signature;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;


class NexmoSignatureValidator implements \Spatie\WebhookClient\SignatureValidator\SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $status = $request['status'];
        if($status == 'delivered')
        {
            return true;
        } else
        {
            return false;
        }
    }
}