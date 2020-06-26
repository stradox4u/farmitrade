@component('mail::message')
<p>Hello {{ $relevantListing->user->name }},</p>
<br>
<p>With respect to your listing on &nbsp;<a href="https://farmitrade.com.ng">Farmitrade</a>, of {{ $relevantListing->quantity }}&nbsp;{{ $relevantListing->unit }}&nbsp;of&nbsp;{{ $relevantListing->produce }}, we are glad to inform you that a user has indicated interest in doing business with you.</p>
<br>
<p>The user's name is {{ $user->name }}</p>
<br>
<p>Please get in touch with {{ $user->name }} on {{ $user->profile->phone_number }}, to arrange for logistics and delivery.</p>
<br>
@if($relevantListing->user->user_type == 'farmer')
<p>Immediately an agreement is made regarding logistics, please follow the link below, to inform us of how much is due for this transaction, to enable us receive payment from the buyer, on your behalf.</p>
<br>
@component('mail::panel')
<a href="https://farmitrade.com.ng/transaction/{{ $relevantListing->transaction->id }}/edit">Let Us Know How Much is to be Paid</a>
@endcomponent
@endif
<p>Best regards,</p>
<p>The Farmitrade&reg; Team.</p>
@endcomponent