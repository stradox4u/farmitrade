@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-dark text-center">Create Your Profile</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.store', auth()->id()) }}" enctype="multipart/form-data" >
                        @csrf

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="shipping_address1" type="text" class="form-control @error('shipping_address1') is-invalid @enderror" name="shipping_address1" value="{{ old('shipping_address1') }}" required autocomplete="shipping_address1" autofocus placeholder="Shipping Address Line 1">

                                @error('shipping_address1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="shipping_address2" type="text" class="form-control @error('shipping_address2') is-invalid @enderror" name="shipping_address2" value="{{ old('shipping_address2') }}" required autocomplete="shipping_address2" autofocus placeholder="Shipping Address Line 2">

                                @error('shipping_address2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            
                            <div class="col w-100">
                                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number" autofocus placeholder="Phone Number">
                                
                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @if(auth()->user()->user_type == 'farmer')
                            <div class="form-group row">
                                
                                <div class="col w-100">
                                    <input id="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ old('bank_name') }}" autocomplete="bank_name" autofocus placeholder="Bank Name">
                                    
                                    @error('bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                
                                <div class="col w-100">
                                    <input id="account_number" type="text" class="form-control @error('account_number') is-invalid @enderror" name="account_number" value="{{ old('account_number') }}" autocomplete="account_number" autofocus placeholder="Account Number">
                                    
                                    @error('account_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="billing_address1" type="text" class="form-control @error('billing_address1') is-invalid @enderror" name="billing_address1" value="{{ old('billing_address1') }}" required autocomplete="billing_address1" autofocus placeholder="Billing Address Line 1">

                                @error('billing_address1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="billing_address2" type="text" class="form-control @error('billing_address2') is-invalid @enderror" name="billing_address2" value="{{ old('billing_address2') }}" required autocomplete="billing_address2" autofocus placeholder="Billing Address Line 2">

                                @error('billing_address2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="profile_image" type="file" class="form-control @error('profile_image') is-invalid @enderror" name="profile_image" value="{{ old('profile_image') }}" required autocomplete="profile_image" placeholder="profile_image">

                                @error('profile_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 py-3">
                            <div class="col w-100">
                                <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm">
                                    Submit
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
