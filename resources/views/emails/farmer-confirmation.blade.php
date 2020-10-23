@component('mail::message')
<p>Hello {{ $payment->transaction->user->user_type == 'farmer' ? $payment->transaction->user->name : $payment->transaction->listing->user->name }},</p>
<br>
<p>Your transaction with id:&nbsp;{{ $payment->transaction->transaction_id_for_paystack }}, to supply {{ $payment->transaction->quantity }}&nbsp;{{ $payment->transaction->unit }} of {{ ucwords($payment->transaction->produce) }} has been paid for by the buyer.</p>
<br>
<p>Please proceed to ship it as soon as possible. You shall be receiving a transfer to your bank account shortly, for the sum to cover the logistics.</p>
@component('mail::panel')
<p>Please remember that we offer our buyers escrow protection. This means that the price of the goods would be released to you immediately the buyer confirms they have been received.</p>
@endcomponent
<p>Do have yourself a beautiful day.</p>
<br>
<p>Best regards,</p>
<p>The Farmitrade&reg; Team.</p>
@endcomponent