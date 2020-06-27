@component('mail::message')
<p>Hello Team,</p>
<br>
<p>A user has just marked a transaction as <strong>'In Contest'</strong>.</p>
<br>
@component('mail::panel')
<h2>Details:</h2>
<span><h3>Relevant Transaction:&nbsp;</h3><p>{{ $transaction->transaction_id_for_paystack }}</p></span>
<span><h3>Transaction Initiated By:&nbsp;</h3><p>{{ $transaction->user->name }}; {{ $transaction->user->profile->phone_number }}; a {{ $transaction->user->user_type }}</p></span>
<span><h3>Second Party:&nbsp;</h3><p>{{ $transaction->listing->user->name }}; {{ $transaction->listing->user->profile->phone_number }}; a {{ $transaction->listing->user->user_type }}</p></span>
@endcomponent
<p>Please contact both parties to establish the facts of the case and determine whether the buyer is to be refunded, or if an insurance claim is to be made.</p>
<br>
<p>Best regards,</p>
<p>Your Farmitrade&reg; Partners.</p>
@endcomponent