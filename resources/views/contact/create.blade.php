@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-dark text-center">Contact Us</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="@auth {{ auth()->user()->name }} @endauth {{ old('name') }}" required autocomplete="name" autofocus placeholder="Name" @auth readonly @endauth>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="@auth {{ auth()->user()->email }} @endauth {{ old('email') }}" required autocomplete="email" placeholder="Email" @auth readonly @endauth>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            
                            <div class="col w-100">
                                <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" required autocomplete="subject" placeholder="Subject">
                                
                                @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col w-100">
                                <label for="message">Message:</label>
                                <textarea id="message" rows="5" class="form-control @error('message') is-invalid @enderror" name="message" required autocomplete="message" placeholder="Message">{{ old('message') }}</textarea>

                                @error('message')
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
