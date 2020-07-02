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
                <td>{{ $transaction->produce }}</td>
                <td>{{ $transaction->quantity }}</td>
                <td>{{ $transaction->unit }}</td>
                <td>{{ $transaction->transaction_id_for_paystack }}</td>
                <td>{{ $transaction->transaction_status }}</td>
                <td class="d-flex justify-content-between">

                    {{-- Buttons Unique to the farmer --}}
                    @if(auth()->user()->user_type == 'farmer')
                    <div class="pr-3">
                        <form action="{{ route('transaction.shipped', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="col btn btn-block btn-lg btn-success shadow-sm" @if($transaction->payment == null || $transaction->transaction_status == 'shipped' || $transaction->transaction_status == 'delivered' || $transaction->transaction_status == 'in contest') disabled @endif>Shipped</button>
                        </form>
                    </div>

                    <div class="pr-3">
                        <a href="{{ route('transaction.edit', $transaction->id) }}" class="col btn btn-block btn-lg btn-success shadow-sm @if($transaction->payment !== null) disabled @endif">Update</a>
                    </div>

                    @elseif(auth()->user()->user_type == 'buyer')

                    {{-- Buttons Unique to the buyer --}}
                    <div class="pr-3">
                        <a href="{{ route('transaction.show', $transaction->id) }}" class="col btn btn-block btn-lg btn-success shadow-sm @if($transaction->payment !== null) disabled @endif">Make Payment</a>
                    </div>

                    <div class="pr-3">
                        <form action="{{ route('transaction.received', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="col btn btn-block btn-lg btn-success shadow-sm" @if($transaction->transaction_status == 'delivered') disabled @endif>Received</button>
                        </form>
                    </div>

                    @endif

                    {{-- Make Claim Button --}}
                    <div class="pr-3">
                        <form action="{{ route('transaction.contest', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="col btn btn-block btn-lg btn-danger shadow-sm" @if($transaction->transaction_status == 'in contest' || $transaction->transaction_status == 'delivered') disabled @endif>Make Claim</button>
                        </form>
                    </div>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transactions->links() }}
</div>
@endsection
