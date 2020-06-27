@extends('layouts.app')

@section('content')
<div class="container">
    {{-- User Profile Info --}}
    <div class="container row my-3 mx-auto">
        <div class="col-4 bg-info">
            @if(auth()->user()->profile == [] || auth()->user()->profile->profile_image == null)
                <i class="far fa-user fa-5x text-white pt-3"></i>
            @else
                <img src="{{ 'storage/' . auth()->user()->profile->profile_image }}" alt="user profile image" style="height: 160px" class="img-fluid p-3">
            @endif
        </div>
        <div class="col-8 col bg-secondary pt-2 rounded">
            <div class="row px-3 text-light">
                <h5 class="h5">Name:&nbsp;</h5>
                <p>{{ auth()->user()->name }}</p>
            </div>

            <div class="row px-3 text-light">
                <h5 class="h5">Shipping Address:&nbsp;</h5>
                <p>{{ auth()->user()->profile->shipping_address ?? 'Not yet set.' }}</p>
            </div>

            <div class="row px-3 text-light">
                <h5 class="h5">Billing Address:&nbsp;</h5>
                <p>{{ auth()->user()->profile->billing_address ?? 'Not yet set' }}</p>
            </div>

            <div class="row px-3 text-light">
                <h5 class="h5">Phone Number:&nbsp;</h5>
                <p>{{ auth()->user()->profile->phone_number ?? 'Not yet set' }}</p>
            </div>
        </div>
    </div>
    {{-- End of User Profile Info --}}

    {{-- Row of Buttons --}}
    <div class="container row d-flex justify-content-between mb-3 mx-auto">
        @if(auth()->user()->profile == [])
        <a href="{{ route('profile.create', auth()->id()) }}" class="btn btn-success btn-lg mx-3 shadow-sm col">Create Profile</a>
        @else
        <a href="{{ route('profile.edit', auth()->user()->profile->id) }}" class="btn btn-success btn-lg mx-3 shadow-sm col">Edit Profile</a>
        @endif
        <a href="{{ route('listing.index', auth()->id()) }}" class="btn btn-success btn-lg mx-3 shadow-sm col">View {{ auth()->user()->user_type == 'buyer' ? 'Farmer' : 'Buyer' }} Listings</a>
        <a href="{{ route('listing.create', auth()->id()) }}" class="btn btn-success btn-lg mx-3 shadow-sm col">Make Listing</a>
        <a href="{{ route('transaction.index', auth()->id()) }}" class="btn btn-success btn-lg mx-3 shadow-sm col">View Transactions</a>
    </div>
    {{-- End of Row of Buttons --}}

    {{-- Table of My Listings --}}
    <div class="container">
        <h3 class="p-3 bg-light">My Listings</h3>
        <table class="table table-striped table-hover table-light">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Produce</th>
                    <th scope="col">To Buy/Sell</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Unit Price (&#8358;)</th>
                    <th scope="col">Filled</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listings as $listing)
                <tr>
                    <td><a href="{{ route('listing.show', $listing->id) }}" class="text-dark text-decoration-none">{{ $listing->produce }}</td></a>
                    <td>{{ $listing->buy_sell }}</td>
                    <td>{{ $listing->quantity }}</td>
                    <td>{{ $listing->unit }}</td>
                    <td>{{ $listing->unit_price }}</td>
                    <td>{{ $listing->filled == false ? 'No' : 'Yes' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $listings->links() }}
    </div>
    {{-- End of My Listings Table --}}
</div>
@endsection
