@component('mail::message')
<p>Hello {{ $farmer->name }},</p>
<br>
<p>Your transaction with id:&nbsp;{{ $transaction->transaction_id_for_paystack }}, to supply {{ $transaction->quantity }}&nbsp;{{ $transaction->unit }} of {{ $transaction->produce }} has been received by the buyer.</p>
<br>
<p>Your funds for the cost of the produce, have thus been released from escrow, and been transferred to your bank account.</p>
<p>It has been our pleasure doing business with you.</p>
<p>Do have yourself a beautiful day.</p>
<br>
<p>Best regards,</p>
<p>The Farmitrade&reg; Team.</p>
@endcomponent