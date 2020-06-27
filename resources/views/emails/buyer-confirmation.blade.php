@component('mail::message')
<p>Hello {{ $payment->transaction->user->user_type == 'buyer' ? $payment->transaction->user->name : $payment->transaction->listing->user->name }},</p>
<br>
<p>We have recieved your payment of &#8358;&nbsp;{{ $payment->total_amount }} for your transaction with id:&nbsp;{{ $payment->transaction->transaction_id_for_paystack }}, to purchase {{ $payment->transaction->quantity }}&nbsp;{{ $payment->transaction->unit }} of {{ $payment->transaction->produce }}.</p>
<br>
<p>You will be notified once the farmer ships it.</p>
@component('mail::panel')
<p>Please remember that we offer our buyers escrow protection. This means that the farmer is only paid once you confirm receipt of the produce. It is thus very important, that you remember to update the status of this transaction to delivered, immediately you receive it.</p>
@endcomponent
<p>Do have yourself a beautiful day.</p>
<br>
<p>Best regards,</p>
<p>The Farmitrade&reg; Team.</p>
@endcomponent