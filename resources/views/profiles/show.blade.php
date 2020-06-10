@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container row bg-secondary">
        <div class="col-md-3">
            <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="user profile image" style="height: 160px" class="img-fluid">
        </div>
        <div class="col-md-9 bg-secondary">
            <div class="pt-3">
                <h1>{{ $profile->user->name }}</h1>
                <h4>{{ ucfirst($profile->user->user_type) }}</h4>
                <h4>{{ $profile->user->email }}</h4>
            </div>
        </div>
    </div>
    <div class="container row d-flex flex-row justify-content-between mt-3">
        <div class="col-md-6 pt-3 bg-success">
            <h3>Shipping Information</h3>
            <p>{{ $profile->phone_number }}</p>
            <p>{{ $profile->shipping_address }}</p>
        </div>

        <div class="col-md-6 bg-light pt-3">
            <h3>Billing Information</h3>
            <p>{{ $profile->phone_number }}</p>
            <p>{{ $profile->billing_address }}</p>
        </div>
    </div>

    <div class="container row pt-3 d-flex justify-content-between">
        <div class="container col">
            <a href="{{ route('profile.edit', $profile->id) }}" class="btn btn-lg btn-block btn-success shadow-sm">Edit Profile</a>
        </div>
        <div class="container col">
            <a href="{{ route('home') }}" class="btn btn-lg btn-block btn-success shadow-sm">Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection
