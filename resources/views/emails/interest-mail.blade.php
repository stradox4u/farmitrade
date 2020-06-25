@component('mail::message')
<p>Hello {{ $relevantListing->user->name }},</p>
<br>
<p>With respect to your listing on &nbsp;<a href="https://farmitrade.com.ng">Farmitrade</a>, of {{ $relevantListing->quantity }}&nbsp;{{ $relevantListing->unit }}&nbsp;of&nbsp;{{ $relevantListing->produce }}, we are glad to inform you that a user has indicated interest in doing business with you.</p>
<br>
<p>The user's name is {{ $user->name }}</p>
<br>
<p>You will shortly be placed in touch with {{ $user->name }}, to arrange for logistics and delivery.</p>
<br>
<p>Best regards,</p>
<p>The Farmitrade&reg; Team.</p>
@endcomponent