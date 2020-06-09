@extends('layouts.app')

@section('content')
<div class="container">
    {{-- User Profile Info --}}
    <div class="container row my-3 mx-auto">
        <div class="col-4 bg-info">
            @if(auth()->user()->profile == [] || auth()->user()->profile->profile_image == null)
                <i class="far fa-user fa-5x text-white pt-3"></i>
            @else
                <img src="{{ 'storage' . auth()->user()->profile->profile_image }}" alt="user profile image">
            @endif
        </div>
        <div class="col-8 col bg-secondary pt-2 rounded">
            <div class="row px-3 text-light">
                <h5 class="h5">Name:&nbsp;</h5>
                <p>{{ auth()->user()->name }}</p>
            </div>

            <div class="row px-3 text-light">
                <h5 class="h5">Shipping Address:&nbsp;</h5>
                <p>Authenticated user's shipping address</p>
            </div>

            <div class="row px-3 text-light">
                <h5 class="h5">Billing Address:&nbsp;</h5>
                <p>Authenticated user's billing address</p>
            </div>

            <div class="row px-3 text-light">
                <h5 class="h5">Phone Number:&nbsp;</h5>
                <p>Authenticated user's phone number</p>
            </div>
        </div>
    </div>
    {{-- End of User Profile Info --}}

    {{-- Row of Buttons --}}
    <div class="container row d-flex justify-content-between mb-3 mx-auto">
        @if(auth()->user()->profile == [])
        <a href="{{ route('profile.create', auth()->id()) }}" class="btn btn-success btn-lg mx-3 shadow-sm col">Create Your Profile</a>
        @else
        <a href="#" class="btn btn-success btn-lg mx-3 shadow-sm col">Edit Your Profile</a>
        @endif
        <a href="#" class="btn btn-success btn-lg mx-3 shadow-sm col">View Listings From {{ auth()->user()->user_type == 'buyer' ? 'Farmers' : 'Buyers' }}</a>
        <a href="#" class="btn btn-success btn-lg mx-3 shadow-sm col">Place a New Listing</a>
    </div>
    {{-- End of Row of Buttons --}}

    {{-- Table of My Listings --}}
    <div class="container">
        <h3 class="p-3 bg-light">My Listings</h3>
        <table class="table table-striped table-hover table-light">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Produce</th>
                    <th scope="col">To Buy/Sell</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Unit Price (&#8358;)</th>
                    <th scope="col">Filled/Open</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 0 ; $i < 8 ; $i++)
                <tr>
                    <td scope="row">{{ $i + 1 }}</td>
                    <td>Eggs</td>
                    <td>Buy</td>
                    <td>15</td>
                    <td>Crates</td>
                    <td>850</td>
                    <td>Open</td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
    {{-- End of My Listings Table --}}
</div>
@endsection
