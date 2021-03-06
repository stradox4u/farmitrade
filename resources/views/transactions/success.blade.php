@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Your Payment Was Successful!</h2>
        </div>
        <div class="card-body">
            <p class="h3 text-center">You should receive an email shortly, confirming your payment.</p>
            <p class="text-center">Thanks for your patronage.</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('home') }}" class="btn btn-success btn-block btn-lg my-3">Return to Dashboard</a>
        </div>
    </div>
</div>
@endsection
