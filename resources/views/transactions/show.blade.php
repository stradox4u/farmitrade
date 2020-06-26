@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card col">
        <div class="card-header">
            <h2>{{ $transaction->quantity }}&nbsp;{{ $transaction->unit }} of {{ $transaction->produce }}, from {{ $transaction->listing->location }}</h2>
        </div>
        <div class="card-body">
            <h4 class="card-title">Price of Goods:</h4>
            <p class="card-text">&#8358;&nbsp;{{ number_format($transaction->price_of_goods, 2) }}</p>
            <hr>
            <br>

            <h4 class="card-title">Price of Logistics:</h4>
            <p class="card-text">&#8358;&nbsp;{{ number_format($transaction->price_of_logistics, 2) }}</p>
            <hr>
            <br>

            <h4 class="card-title">Insurance Premium:</h4>
            <p class="card-text">&#8358;&nbsp;{{ number_format($transaction->insurance_premium, 2) }}</p>
            <div class="form-check row mb-3">
                <div class="col d-flex flex-row">
                    <input id="pay_insurance_premium" type="checkbox" class="form-check-input" name="pay_insurance_premium" value="1">
                    <label for="pay_insurance_premium" class="form-check-label">
                        <a href="#"><p class="text-dark text-decoration-none" data-toggle="modal" data-target="#insurancePremiumModal">Pay Insurance Premium</p></a>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="#" class="btn btn-block btn-lg btn-success shadow-sm">Pay With Paystack</a>
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

{{-- Some Javascript to enable the close and accept button --}}
@section('extra-js')
<script src="{{ asset('js/app.js') }}"></script>
<script>
        window.onload = function()
        {
            var el = document.getElementById('close_accept');
            el.addEventListener('click', function(el) 
            {
                document.getElementById("pay_insurance_premium").checked = true;
            });
        }
</script>
@endsection
