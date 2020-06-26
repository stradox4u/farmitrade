@component('mail::message')
@if($transaction->user->user_type == 'buyer')
<p>Hello {{ $transaction->user->name }},</p>
@else
<p>Hello {{ $transaction->listing->user->name }},</p>
@endif
<br>
<p>Your transaction to purchase {{ $transaction->quantity }}&nbsp;{{ $transaction->unit }}&nbsp;of {{ $transaction->produce }}&nbsp; from {{ $transaction->user->user_type == 'buyer' ? $transaction->listing->user->name : $transaction->user->name }} in {{ $transaction->listing->location }}&nbsp;has just been updated.</p>
<br>
<p>You are hereby required to proceed to the link below to make payment, at your earliest convenience.</p>
<br>
@component('mail::panel')
<a href="https://farmitrade.com.ng/transaction/{{ $transaction->id }}">Review and make payment.</a>
@endcomponent
<p>Best regards,</p>
<p>The Farmitrade&reg; Team.</p>
@endcomponent