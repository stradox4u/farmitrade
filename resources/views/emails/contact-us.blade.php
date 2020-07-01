@component('mail::message')
<p>Hello Team,</p>
<br>
<p>{{ $data['name'] }} has just submitted a "Contact Us" form.</p>
<br>
@component('mail::panel')
<h2>Subject:</h2>
{{ $data['subject'] }}
@endcomponent
@component('mail::panel')
<h2>Message:</h2>
{{ $data['message'] }}
@endcomponent
<p>Please ensure this message is given the requisite due diligence.</p>
<br>
<p>Best regards,</p>
<p>Your Farmitrade&reg; Partners.</p>
@endcomponent