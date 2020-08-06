@component('mail::message')
<p>Hello {{ $user->name }},</p>
<br>
<p>Here's hoping you've had an excellent and productive week thus far. We as always, are striving everyday to make your &nbsp;<a href="https://farmitrade.com.ng">Farmitrade</a> experience as pleasant and stress-free as possible.</p>
<br>
@if($myOpenListings->isNotEmpty())
<p>In respect of your outstanding unfilled listings, here are a few suggestions that might fill your requirements:</p>
<br>
@forelse($relevantListings as $relevantListing)
@component('mail::panel')
    
    <h2>{{ $relevantListing->quantity }}&nbsp;{{ $relevantListing->unit }}&nbsp; of&nbsp;<a href="{{ route('listing.show', $relevantListing->id) }}">{{ $relevantListing->produce }}.</a></h2>
    <span><h3>Location:&nbsp;</h3><p>{{ $relevantListing->location }}</p></span>
    <br>
    <span><h3>Unit Price:&nbsp;</h3><p>{{ $relevantListing->unit_price }}</p></span>

@endcomponent
@empty
<p>There are no current listings that meet your open listings, but not to worry. We have users making listings all the time, so something should come up soon.</p>
@endforelse
@else
<p>We noticed that you have no outstanding unfilled listings. We are sure that we can meet your needs for produce, whatever they may be.</p>
@endif
@if($relevantListings->isNotEmpty())
<p>Please feel free to visit the site and @if($myOpenListings->isNotEmpty())make an offer on any of the above listings @else make a listing outlining your requirements @endif at your earliest convenience.</p>
<br>
@endif
<p>Have a beautiful day,</p>
<p>The Farmitrade&reg; Team.</p>
@endcomponent