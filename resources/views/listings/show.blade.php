@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{ $listing->produce }}</h3>
        </div>
        <div class="card-body">
            <h4 class="card-title">{{ $listing->location }}</h4>
            <h4 class="card-text">{{ $listing->quantity }}&nbsp;{{ $listing->unit }}</h4>
            <p class="card-text">Unit Price: &nbsp;&#8358;&nbsp;{{ $listing->unit_price }}</p>
        </div>
        <div class="row card-footer">
            <div class="col-md-9">
                <h3>Listing Posted By:</h3>
                <p>{{ $listing->user->name }}</p>
            </div>
            <div class="col-md-3">
                @if($listing->user->profile->profile_image !== null)
                <img src="{{ asset('storage/' . $listing->user->profile->profile_image) }}" alt="listing poster's profile image" style="height: 160px;" class="img-fluid">
                @else
                <i class="far fa-user fa-5x text-white pt-3"></i>
                @endif
            </div>
        </div>
    </div>
    <div class="container row pt-3">
        <div class="col">
            <a href="{{ route('home') }}" class="btn btn-lg btn-block btn-success shadow-sm">Back to Dashboard</a>
        </div>

        @if(auth()->id() == $listing->user->id)
        <div class="col">
            <form action="{{ route('listing.destroy', $listing->id) }}" method="POST">
                @csrf
                @method('DELETE')
                
                <button type="submit" class="btn btn-lg btn-block btn-success shadow-sm">Delete Listing</button>
            </form>
        </div>
        @endif

        @if(auth()->id() !== $listing->user->id)
            <div class="col">
                <form action="{{ route('transaction.store', $listing->id) }}" method="POST">
                    @csrf

                    <input type="hidden" name="relevant_listing" value="{{ $listing->id }}">
                    
                    <button type="submit" class="btn btn-lg btn-block btn-success shadow-sm">Make Offer</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
