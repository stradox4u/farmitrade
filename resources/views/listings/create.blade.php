@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-dark text-center">Create a Listing</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('listing.store', auth()->user()) }}" enctype="multipart/form-data" >
                        @csrf

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="produce" type="text" class="form-control @error('produce') is-invalid @enderror" name="produce" value="{{ old('produce') }}" required autocomplete="produce" autofocus placeholder="Produce">

                                @error('produce')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="produce_quality" type="text" class="form-control @error('produce_quality') is-invalid @enderror" name="produce_quality" value="{{ old('produce_quality') }}" required autocomplete="produce_quality" autofocus placeholder="Produce Quality (Average Description)">

                                @error('produce_quality')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required autocomplete="location" autofocus placeholder="Location">

                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col d-flex justify-content-between w-100">
                                <div class="container">
                                    <label for="buy_sell" class="text-dark">To Buy or Sell?:</label>
                                </div>
                                <div class="container form-check form-check-inline">
                                    <label for="buy" class="form-check-label text-dark pr-3">Buy</label>
                                    <input class="form-check-input" type="radio" name="buy_sell" id="buy" value="buy">
                                </div>

                                <div class="container form-check form-check-inline">
                                    <label for="sell" class="form-check-label text-dark pr-3">Sell</label>
                                    <input class="form-check-input" type="radio" name="buy_sell" id="sell" value="sell">
                                </div>

                            </div>
                        </div>
                        
                        <div class="form-group row">
                            
                            <div class="col w-100">
                                <input id="quantity" type="number" min="0" step="1" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" required autocomplete="quantity" autofocus placeholder="Quantity">
                                
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{ old('unit') }}" required autocomplete="unit" autofocus placeholder="Unit">

                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="unit_price" type="number" min="0" step="0.01" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" value="{{ old('unit_price') }}" required autocomplete="unit_price" autofocus placeholder="Unit Price (&#8358;)">

                                @error('unit_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 py-3">
                            <div class="col w-100">
                                <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm">
                                    Submit Listing
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
