@component('mail::message')
<p>Hello {{ $buyer->name }},</p>
<br>
<p>Your transaction to purchase {{ $transaction->quantity }}&nbsp;{{ $transaction->unit }} of {{ ucwords($transaction->produce) }} with id:{{ $transaction->transaction_id_for_paystack }} has just been shipped.</p>
<p>It was shipped using {{ $transaction->sent_via }}, on a {{ $transaction->vehicle_description }}. The bearer is {{ $transaction->bearer_name }}, and is reachable on {{ $transaction->bearer_phone_number }}.</p>
<br>
<p>Please remember to mark the transaction as received once you do receive and verify the produce. This is to allow us to release the farmer's funds from escrow.</p>
<br>
<p>Best regards,</p>
<p>The Farmitrade&reg; Team.</p>
@endcomponent