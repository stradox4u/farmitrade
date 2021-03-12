@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-dark text-center">Rate Your Experience</h4>
                </div>

                <div class="card-body">
                    <div class="card-text pb-3">
                        <ul class="list-group">
                            <li class="list-group-item" style="border: none;"><p>Was your transaction with the other party smooth?</p></li>
                            <li class="list-group-item" style="border: none;"><p>Were the goods delivered on time?</p></li>
                            <li class="list-group-item" style="border: none;"><p>Were the goods as described?</p></li>
                            <li class="list-group-item" style="border: none;"><p>Please rate your experience with the other party below.</p></li>
                        </ul>
                    </div>
                    <form method="POST" action="{{ route('rating.update', $transaction) }}" enctype="multipart/form-data" >
                        @csrf

                        <div class="form-group row">

                            <div class="col w-100 d-flex justify-content-between">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="starRating" id="1star" value="1">
                                    <label class="form-check-label" for="1star">1<i class="pl-2 text-danger fas fa-star"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="starRating" id="2star" value="2">
                                    <label class="form-check-label" for="2star">2<i class="pl-2 text-warning fas fa-star"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="starRating" id="3star" value="3">
                                    <label class="form-check-label" for="3star">3<i class="pl-2 text-secondary fas fa-star"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="starRating" id="4star" value="4">
                                    <label class="form-check-label" for="4star">4<i class="pl-2 text-info fas fa-star"></i></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="starRating" id="5star" value="5">
                                    <label class="form-check-label" for="5star">5<i class="pl-2 text-success fas fa-star"></i></label>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group row mb-0 py-3">
                            <div class="col w-100">
                                <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm">
                                    Submit Rating
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
