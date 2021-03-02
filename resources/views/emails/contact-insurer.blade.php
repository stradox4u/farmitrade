@component('mail::message')
<p>Hello Insurer Contact,</p>
<br>
<p>With respect to our Goods in Transit insurance policy {{ setting('site.insurance_policy') }} with your organization, a transaction was just made, with the details below.</p>
<br>
@component('mail::panel')
<h2>Produce:</h2>
<p>{{ ucwords($transaction->produce) }}</p>
<h2>Quantity:</h2>
<p>{{ $transaction->quantity }}&nbsp;{{ $transaction->unit }}</p>
<h2>Value:</h2>
<p>&#8358;&nbsp;{{ number_format($transaction->price_of_goods / 100, 2) }}</p>
<h2>Origin:</h2>
<p>{{ $farmer->profile->shipping_address }}</p>
<h2>Destination:</h2>
<p>{{ $transaction->user->user_type == 'buyer' ? $transaction->user->profile->shipping_address : $transaction->listing->user->profile->shipping_address }}</p>
<h2>Sent Via:</h2>
<p>{{ $transaction->sent_via }}</p>
<h2>Vehicle Description:</h2>
<p>{{ $transaction->vehicle_description }}</p>
<h2>Bearer's Name:</h2>
<p>{{ $transaction->bearer_name }}</p>
<h2>Bearer's Phone Number:</h2>
<p>{{ $transaction->bearer_phone_number }}</p>
<h2>Farmer:</h2>
<p>{{ $farmer->name }}</p>
<h2>Buyer:</h2>
<p>{{ $transaction->user->user_type == 'buyer' ? $transaction->user->name : $transaction->listing->user->name }}</p>
@endcomponent

<p>Thank you, and do have a wonderful day.</p>
<br>
<p>Yours sincerely,</p>
<p>The Farmitrade&reg; Team.</p>
@endcomponent