<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/x-icon">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <!-- Bootstrap JS, Popper.js, and jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    
        <!-- Fontawesome -->
        <script src="https://kit.fontawesome.com/00dea3cce7.js" crossorigin="anonymous"></script>

    </head>
    <body>
        <div class="container mt-3">
            {{-- Jumbotron --}}
            <div class="jumbotron jumbotron-fluid">
                <div class="container w-100">
                    <h3 class="text-center display-4 bg-success p-3">Farmitrade &#174;</h3>
                </div>
                <div class="container-fluid d-flex row mx-auto">
                    {{-- Side Panel with buttons and text --}}
                    <div class="col-md-4 bg-success py-3">
                        @if (Route::has('login'))
                        <div class="links">
                            @auth
                                <a href="{{ url('/home') }}" class="btn btn-light btn-lg btn-block shadow-sm mb-3">Home</a>
                                <a class="btn btn-light btn-lg btn-block shadow-sm mb-3" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-light btn-lg btn-block shadow-sm mb-3">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-light btn-lg btn-block shadow-sm mb-3">Register</a>
                                @endif
                            @endauth
                        </div>
                        @endif

                        <div class="container">
                            <h4>Farmitrade&nbsp;&#174;</h4><p>is an app that connects the supply of farm produce with the demand.</p>
                            <p>We are a platform that smooths out the experience of buying and selling farm produce.</p>
                            <div class="bg-light py-3 pl-3 ml-0 rounded">
                                <h4>Are you a farmer?</h4>
                                <p>- We can make you more money</p>
                            </div>
                            <h4>Are you a buyer?</h4>
                            <p>- We can save you the trips to the hinterlands and get you a better price.</p>
                        </div>
                    </div>
                    {{-- End of Side Panel --}}
                    <div class="col-md-8 bg-secondary py-3">
                        {{-- Carousel --}}
                        <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselIndicators" data-slide-to="2"></li>
                                <li data-target="#carouselIndicators" data-slide-to="3"></li>
                                <li data-target="#carouselIndicators" data-slide-to="4"></li>
                                <li data-target="#carouselIndicators" data-slide-to="5"></li>
                                <li data-target="#carouselIndicators" data-slide-to="6"></li>
                                <li data-target="#carouselIndicators" data-slide-to="7"></li>
                                <li data-target="#carouselIndicators" data-slide-to="8"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('images/trader.jpg') }}" class="d-block w-100" alt="abundance">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/carrots.jpg') }}" class="d-block w-100" alt="carrots">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/garlic.jpg') }}" class="d-block w-100" alt="garlic">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/green-apple.jpg') }}" class="d-block w-100" alt="green-apple">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/honeycomb.jpg') }}" class="d-block w-100" alt="honeycomb">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/potatoes.jpg') }}" class="d-block w-100" alt="potatoes">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/tomatoes.jpg') }}" class="d-block w-100" alt="tomatoes">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/variety.jpg') }}" class="d-block w-100" alt="variety">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/abundance.jpg') }}" class="d-block w-100" alt="trader">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    {{-- End of Carousel --}}
                </div>
            </div>
            {{-- End of Jumbotron --}}
        </div>

        {{-- Cards --}}
        <div class="container">
            <div class="container row">
                <div class="col-md-3">
                    <div class="w-100"></div>
                </div>
                <div class="col-md-6">
                    <h2 class="text-center display-4">How It Works!</h2>
                </div>
                <div class="col-md-3">
                    <div class="w-100"></div>
                </div>
            </div>
            <div class="container d-flex flex-row justify-content-between">
                <div class="card col-lg-3 mt-3 p-0">
                    <img class="card-img-top img-fluid " style="width: 400px;" src="{{ asset('images/card-1.jpg') }}" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Register</h4>
                        <p class="card-text">Register as a buyer or farmer</p>
                    </div>
                    <div class="card-body">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg btn-block shadow-sm mb-3">Register</a>
                        @endif
                    </div>
                </div>
                <div class="card col-lg-3 mt-3 p-0">
                    <img class="card-img-top img-fluid " style="width: 300px;" src="{{ asset('images/card-2.jpg') }}" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Place Listing</h4>
                        <p class="card-text">Place a listing or a request, and get connected to a matching farmer/buyer</p>
                    </div>
                </div>
                <div class="card col-lg-3 mt-3 p-0">
                    <img class="card-img-top img-fluid " style="width: 400px;" src="{{ asset('images/card-3.jpg') }}" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Get Paid / Get Produce</h4>
                        <p class="card-text">Get paid for your produce / Receive the produce you require.</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- End of cards --}}

        {{-- Footer --}}
        <div class="container d-flex flex-row justify-content-between pt-3">
            <div class="container col">
                <p>&copy;&nbsp;Copyright Farmitrade Nigeria. 2020.</p>
            </div>
            <div class="container col d-flex flex-row justify-content-between">
                <h5>Find us on social media:&nbsp;</h5>
                <a href="#" class="text-dark"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="#" class="text-dark"><i class="fab fa-instagram fa-2x"></i></a>
                <a href="#" class="text-dark"><i class="fab fa-twitter fa-2x"></i></a>
            </div>
        </div>

        <div class="container d-flex flex-row justify-content-between pt-3">
            <a href="{{ route('contact.create') }}" class="text-dark">Contact Us</a>
            <a href="#" class="text-dark">About Us</a>
        </div>
        
    </body>
</html>
