@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card col">
        <div class="card-header">
            <h2>{{ $transaction->quantity }}&nbsp;{{ $transaction->unit }} of {{ $transaction->produce }}, from {{ $transaction->listing->location }}</h2>
        </div>
        <div class="card-body">
            <h4 class="card-title">Price of Goods:</h4>
            <p class="card-text">&#8358;&nbsp;{{ number_format($transaction->price_of_goods / 100, 2) }}</p>
            <hr>
            <br>

            <h4 class="card-title">Price of Logistics:</h4>
            <p class="card-text">&#8358;&nbsp;{{ number_format($transaction->price_of_logistics / 100, 2) }}</p>
            <hr>
            <br>

            <h4 class="card-title">Platform Fee (5%):</h4>
            <p class="card-text">&#8358;&nbsp;{{ number_format($transaction->platform_fee / 100, 2) }}</p>
            <hr>
            <br>
            
            <h4 class="card-title">Total:</h4>
            <p class="card-text">&#8358;&nbsp;{{ number_format(($transaction->price_of_goods + $transaction->price_of_logistics + $transaction->platform_fee) / 100, 2) }}</p>
            <hr>
            <br>

            <h4 class="card-title">Insurance Premium:</h4>
            <p class="card-text">&#8358;&nbsp;{{ number_format($transaction->insurance_premium / 100, 2) }}</p>
            <div class="form-check row mb-3">
                <div class="col d-flex flex-row">
                    <input id="pay_insurance_premium" type="checkbox" class="form-check-input" name="pay_insurance_premium" value="1">
                    <label for="pay_insurance_premium" class="form-check-label">
                        <a href="#"><p class="text-dark text-decoration-none" data-toggle="modal" data-target="#insurancePremiumModal">Pay with insurance</p></a>
                    </label>
                </div>
            </div>
            
        </div>
        <div class="card-footer">
            <div class="container d-flex justify-content-between">
                <form id="no_insurance" action="{{ route('pay') }}" method="POST" accept-charset="UTF-8" class="form-horizontal" role="form">
                    @csrf
            
                    <input type="hidden" id="no_insurance_email" name="email" value="{{ auth()->user()->email }}">
                    <input type="hidden" id="no_insurance_order_id" name="orderId" value="{{ $transaction->transaction_id_for_paystack }}">
                    <input type="hidden" id="no_insurance_amount" name="amount" value="{{ $transaction->price_of_goods + $transaction->price_of_logistics + $transaction->platform_fee }}">
                    <input type="hidden" id="no_insurance_metadata" name="metadata" value="{{ json_encode($array = ['client_id' => $transaction->transaction_id_for_paystack]) }}">
                    <input type="hidden" id="insurance_paid" name="insurance_paid" value="false">
                    <button type="submit" name="no_insurance" id="no_insurance_submit" class="btn btn-success shadow-sm btn-lg btn-block col">Pay Without Insurance</button>
                </form>
            
                <form id="with_insurance" action="{{ route('pay') }}" method="POST" accept-charset="UTF-8" class="form-horizontal" role="form">
                    @csrf
            
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    <input type="hidden" name="orderId" value="{{ $transaction->transaction_id_for_paystack }}">
                    <input type="hidden" name="amount" value="{{ $transaction->price_of_goods + $transaction->price_of_logistics + $transaction->insurance_premium + $transaction->platform_fee }}">
                    <input type="hidden" name="metadata" value="{{ json_encode($array = ['client_id' => $transaction->transaction_id_for_paystack]) }}">
                    <input type="hidden" name="insurance_paid" value="true">
                    <button type="submit" name="with_insurance" id="with_insurance_submit" class="btn btn-success shadow-sm btn-lg btn-block col pl-3" disabled>Pay With Insurance</button>
                </form>
            </div>
        </div>
    </div>
    
    

    {{-- Insurance Premium Explanation Modal --}}
    <div class="modal fade" id="insurancePremiumModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Insurance Premium</h3>
                </div>

                <div class="modal-body">
                    <p>We have partnered with <strong>Leadway Assurance Plc</strong> to provide you with insurance cover for your produce, while in transit. If you choose to pay the insurance premium, you will be covered for any loss suffered in the course of transit and during the period of transit, up to the full value of the goods insured.</p>
                    <p>This service leverages their Goods in Transit Insurance Policy.</p>
                </div>

                <div class="modal-footer d-flex flex-row justify-content-between">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                    <button id="close_accept" type="button" class="btn btn-success" data-dismiss="modal">Close and Accept</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Insurance Premium Explanation Modal --}}
</div>
@endsection

@section('extra-js')
<script src="{{ asset('js/app.js') }}"></script>
<script>
    window.onload = function()
    {
        // Some Javascript to enable the close and accept button 
        var el = document.getElementById('close_accept');
            el.addEventListener('click', function(el) 
            {
                document.getElementById("pay_insurance_premium").checked = true;
                document.getElementById("with_insurance_submit").disabled = false;
            });

            // Javascript to enable and disable the pay with insurance button
            var element = document.getElementById('pay_insurance_premium');
            element.addEventListener('change', function(element)
            {
                var button = document.getElementById("with_insurance_submit");
                if(button.disabled)
                {
                    button.disabled = false;
                } else 
                {
                    button.disabled = true;
                }
            });
           
        }
</script>
@endsection
