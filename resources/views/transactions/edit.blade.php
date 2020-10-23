@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-dark text-center">Update The Transaction Details</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('transaction.update', $transaction->id) }}">
                        @csrf

                        @method('PATCH')

                        <div class="form-group row">

                            <div class="col w-100">
                                    <input id="produce" type="text" class="form-control @error('produce') is-invalid @enderror" name="produce" autocomplete="produce" autofocus value="{{ ucwords($transaction->produce) }}" readonly>

                                @error('produce')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                    <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" autocomplete="unit" autofocus value="{{ $transaction->unit }}" readonly>

                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                    <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" autocomplete="quantity" autofocus placeholder="Quantity">

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="price_of_goods" type="number" step="0.01" class="form-control @error('price_of_goods') is-invalid @enderror" name="price_of_goods" autocomplete="price_of_goods" autofocus placeholder="Total Price of Goods (NGN)">

                                @error('price_of_goods')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="price_of_logistics" type="number" step="0.01" class="form-control @error('price_of_logistics') is-invalid @enderror" name="price_of_logistics" value="" autocomplete="price_of_logistics" autofocus placeholder="Price of Logistics (NGN)">

                                @error('price_of_logistics')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="delivery_timeframe" type="number" class="form-control @error('delivery_timeframe') is-invalid @enderror" name="delivery_timeframe" value="" autocomplete="delivery_timeframe" autofocus placeholder="How Long To Deliver? (Days)">

                                @error('delivery_timeframe')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        

                        <div class="form-group row mb-0 py-3">
                            <div class="col w-100">
                                <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm">
                                    Update
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
