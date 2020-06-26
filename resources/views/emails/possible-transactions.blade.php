@component('mail::message')
<p>Hello {{ $user->name }},</p>
<br>
<p>With respect to the last listing you posted on&nbsp;<a href="https://farmitrade.com.ng">Farmitrade</a>, regarding {{ $listing->quantity }}&nbsp;{{ $listing->unit }}&nbsp;of&nbsp;{{ $listing->produce }}, we are glad to inform you that we have open listings that can match your listing.</p>
<br>
<p>Please find some of these listings below.</p>
<br>

@foreach($relevantListings as $relevantListing)
@component('mail::panel')
    
    <h2>{{ $relevantListing->quantity }}&nbsp;{{ $relevantListing->unit }}&nbsp; of&nbsp;<a href="https://farmitrade.com.ng/listing/{{ $relevantListing->id) }}">{{ $relevantListing->produce }}.</a></h2>
    <span><h3>Location:&nbsp;</h3><p>{{ $relevantListing->location }}</p></span>
    <br>
    <span><h3>Unit Price:&nbsp;</h3><p>{{ $relevantListing->unit_price }}</p></span>

@endcomponent
@endforeach

<p>Best regards,</p>
<p>The Farmitrade&reg; Team.</p>
@endcomponent