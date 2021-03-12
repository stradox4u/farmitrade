@extends('layouts.app')

@section('content')
<div class="container row mx-auto">
    {{-- Left side panel --}}
    {{-- User Profile Info --}}
    <div class="container my-3 col-sm-12 col-md-12 col-lg-3">
        <div class="text-center py-3">
            @if(auth()->user()->profile == [] || auth()->user()->profile->profile_image == null)
                <i class="far fa-user fa-5x text-white pt-3"></i>
            @else
                <img src="{{ 'storage/' . auth()->user()->profile->profile_image }}" alt="user profile image" style="height: 160px" class="img-fluid rounded-circle">
            @endif
        </div>
        <div class="bg-secondary rounded p-3 col">
            <div class="row px-3 text-light">
                <h5 class="h5 bg-light p-1 rounded text-dark mr-3">Name:&nbsp;</h5>
                <p class="my-0">{{ auth()->user()->name }}</p>
            </div>

            <div class="row px-3 text-light">
                <h5 class="h5 bg-light p-1 rounded text-dark">Shipping Address:&nbsp;</h5>
                <p>{{ auth()->user()->profile->shipping_address ?? 'Not yet set.' }}</p>
            </div>

            <div class="row px-3 text-light">
                <h5 class="h5 bg-light p-1 rounded text-dark">Billing Address:&nbsp;</h5>
                <p>{{ auth()->user()->profile->billing_address ?? 'Not yet set' }}</p>
            </div>

            <div class="row px-3 text-light">
                <h5 class="h5 bg-light p-1 rounded text-dark mr-3">Phone Number:&nbsp;</h5>
                <p>{{ auth()->user()->profile == null ? 'Not yet set' : Str::replaceFirst('234', '0', auth()->user()->profile->phone_number) }}</p>
            </div>

            <div class="row px-3 text-light">
                <h5 class="h5 bg-light p-1 rounded text-dark mr-3">Successful Transactions:&nbsp;</h5>
                <p>{{ auth()->user()->successful_transactions }}</p>
            </div>

            <div class="row px-3 text-light">
                <h5 class="h5 bg-light p-1 rounded text-dark mr-3">Average Rating:&nbsp;</h5>
                <p>{{ number_format(auth()->user()->averageRating(), 2) }} Stars</p>
            </div>
        </div>
    </div>
    {{-- End of User Profile Info --}}
    {{-- End of left side panel --}}

    {{-- Right side panel --}}
    <div class="container col my-3 col-sm-12 col-md-12 col-lg-9">
        {{-- Row of Buttons --}}
        <div class="container row d-flex justify-content-between mb-3 mx-auto">
            @if(auth()->user()->profile == [])
            <div class="py-3 pr-3 shadow-sm col-sm-6 col-lg-3">
                <a href="{{ route('profile.create', auth()->user()) }}" class="btn btn-block btn-success">Create Profile</a>
            </div>
            @else
            <div class="py-3 pr-3 shadow-sm col-sm-6 col-lg-3"> 
                <a href="{{ route('profile.edit', auth()->user()->profile) }}" class="btn btn-block btn-success">Edit Profile</a>
            </div>
            @endif
            <div class="py-3 pr-3 shadow-sm col-sm-6 col-lg-3">
                <a href="{{ route('listing.index', auth()->user()) }}" class="btn btn-block btn-success shadow-sm">{{ auth()->user()->user_type == 'buyer' ? 'Farmer' : 'Buyer' }} Listings</a>
            </div>
            <div class="py-3 pr-3 shadow-sm col-sm-6 col-lg-3">
                <a href="{{ route('listing.create', auth()->user()) }}" class="btn btn-block btn-success shadow-sm">Make Listing</a>
            </div>
            <div class="py-3 shadow-sm col-sm-6 col-lg-3">
                <a href="{{ route('transaction.index', auth()->user()) }}" class="btn btn-block btn-success shadow-sm">My Transactions</a>
            </div>
        </div>
        {{-- End of Row of Buttons --}}

        {{-- Table of My Listings --}}
        <div class="container col">
            <div class="d-flex justify-content-between p-3 bg-light">
                <h3>My Open Listings</h3>
                @if(request()->list != 'all')
                <a href="{{ route('home', ['list' => 'all']) }}" class="btn btn-light shadow-sm">All My Listings</a>
                @endif
                @if(request()->list == 'all')
                    <a href="{{ route('home') }}" class="btn btn-light shadow-sm">Go Back</a>
                @endif
            </div>
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
                    <tr @if($listing->filled) class="bg-success" @endif>
                        <td><a href="{{ route('listing.show', $listing) }}" class="text-dark text-decoration-none">{{ ucwords($listing->produce) }}</td></a>
                        <td>{{ $listing->buy_sell }}</td>
                        <td>{{ $listing->quantity }}</td>
                        <td>{{ $listing->unit }}</td>
                        <td>{{ number_format($listing->unit_price /100, 2) }}</td>
                        <td>{{ $listing->filled == false ? 'No' : 'Yes' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $listings->links() }}
        </div>
        {{-- End of My Listings Table --}}
    </div>
    {{-- End of right side panel --}}
</div>
@endsection
