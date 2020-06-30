@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{ auth()->user()->user_type == 'buyer' ? 'Here are Items Available for Sale' : 'Here are Open Orders You Could Fill' }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Produce</th>
                        <th scope="col">Location</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Unit Price (&#8358;)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listings as $listing)
                    <tr>
                        <td scope="row">{{ $loop->iteration }}</td>
                        <td><a href="{{ route('listing.show', $listing->id) }}" class="text-dark text-decoration-none">{{ $listing->produce }}</a></td>
                        <td>{{ $listing->location }}</td>
                        <td>{{ $listing->quantity }}</td>
                        <td>{{ $listing->unit }}</td>
                        <td>{{ $listing->unit_price }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
