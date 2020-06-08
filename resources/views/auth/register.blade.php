@extends('layouts.app')

@section('content')
<div class="card bg-dark text-white" style="border: none;">
    <img src="{{ asset('images/background.jpg') }}" class="card-img" style="height: 100vh;" alt="background-image">
    <div class="card-img-overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-dark text-center">Register</h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group row">

                                    <div class="col w-100">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col w-100">
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Username">

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col w-100">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col d-flex justify-content-between w-100">
                                        <div class="container">
                                            <label for="buyer-type" class="text-dark">Type of User:</label>
                                        </div>
                                        <div class="container">
                                            <label for="buyer" class="text-dark pr-3">Buyer</label>
                                            <input type="radio" name="user-type" id="buyer-type" value="buyer">
                                        </div>

                                        <div class="container">
                                            <label for="farmer" class="text-dark pr-3">Farmer</label>
                                            <input type="radio" name="user-type" id="farmer-type" value="farmer">
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col w-100">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col w-100">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                                    </div>
                                </div>

                                <div class="form-group row mb-0 py-3">
                                    <div class="col w-100">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
