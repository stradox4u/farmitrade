@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="p-3 bg-light">My Open Transactions</h3>
    <table class="table table-striped table-hover table-light">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Produce</th>
                <th scope="col">Quantity</th>
                <th scope="col">Unit</th>
                <th scope="col">Transaction Id</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ ucwords($transaction->produce) }}</td>
                <td>{{ $transaction->quantity }}</td>
                <td>{{ $transaction->unit }}</td>
                <td>{{ $transaction->transaction_id_for_paystack }}</td>
                <td>{{ $transaction->transaction_status }}</td>
                <td class="d-flex justify-content-between">

                    {{-- Buttons Unique to the farmer --}}
                    @if(auth()->user()->user_type == 'farmer')
                    <div class="pr-3">
                        <button type="submit" data-toggle="modal" data-target="#courierDetailsModal" class="col btn btn-block btn-lg btn-success shadow-sm" @if($transaction->payment == null || $transaction->transaction_status == 'shipped' || $transaction->transaction_status == 'delivered' || $transaction->transaction_status == 'in contest') disabled @endif>Shipped</button>

                        {{-- Modal to enter courier details --}}
                        <div class="modal fade" id="courierDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Enter The Courier's Details Here</h5>
                                    </div>
                                    <form action="{{ route('transaction.shipped', $transaction) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body px-3">
                                            <div class="form-group row">
                                                <div class="col w-100">
                                                    <label for="sent_via" class="col-form-label">Sent Via:</label>
                                                    <input type="text" class="form-control" id="sent_via" name="sent_via">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col w-100">
                                                    <label for="vehicle_description" class="col-form-label">Vehicle Description:</label>
                                                    <input type="text" class="form-control" id="vehicle_description" name="vehicle_description">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col w-100">
                                                    <label for="bearer_name" class="col-form-label">Bearer Name:</label>
                                                    <input type="text" class="form-control" id="bearer_name" name="bearer_name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col w-100">
                                                    <label for="bearer_phone_number" class="col-form-label">Bearer Phone Number:</label>
                                                    <input type="text" class="form-control" id="bearer_phone_number" name="bearer_phone_number">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success btn-lg btn-block shadow-sm" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm">Confirm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pr-3">
                        <a href="{{ route('transaction.edit', $transaction) }}" class="col btn btn-block btn-lg btn-success shadow-sm @if($transaction->payment !== null) disabled @endif">Update</a>
                    </div>

                    @elseif(auth()->user()->user_type == 'buyer')

                    {{-- Buttons Unique to the buyer --}}
                    <div class="pr-3">
                        <a href="{{ route('transaction.show', $transaction) }}" class="col btn btn-block btn-lg btn-success shadow-sm @if($transaction->payment !== null) disabled @endif">Make Payment</a>
                    </div>

                    <div class="pr-3">
                        <form action="{{ route('transaction.received', $transaction) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="col btn btn-block btn-lg btn-success shadow-sm" @if($transaction->transaction_status == 'delivered') disabled @endif>Received</button>
                        </form>
                    </div>

                    @endif

                    {{-- Make Claim Button --}}
                    <div class="pr-3">
                        <form action="{{ route('transaction.contest', $transaction) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="col btn btn-block btn-lg btn-danger shadow-sm" @if($transaction->transaction_status == 'in contest' || $transaction->transaction_status == 'delivered') disabled @endif>Make Claim</button>
                        </form>
                    </div>

                    {{-- Rating Button --}}
                    @if(auth()->user()->user_type == 'farmer')
                    <div class="pr-3">
                        <a href="{{ route('rating.edit', $transaction) }}" class="col btn btn-block btn-lg btn-success shadow-sm @if($transaction->buyer_is_rated == true) disabled @endif">Rate</a>
                    </div>
                    @elseif(auth()->user()->user_type == 'buyer')
                    <div class="pr-3">
                        <a href="{{ route('rating.edit', $transaction) }}" class="col btn btn-block btn-lg btn-success shadow-sm @if($transaction->farmer_is_rated == true) disabled @endif">Rate</a>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transactions->links() }}
</div>
@endsection
