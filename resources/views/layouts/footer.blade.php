<footer class="container mt-3 mx-auto">
    <div class="container pt-2 bg-light mx-auto rounded">
        <div class="container d-flex justify-content-between mt-4">
            <p class="pl-3 font-weight-bold h3">Find Us On: </p>
            <a href="#">
                <i class="fab fa-instagram-square text-secondary fa-3x"></i>
            </a>
            <a href="#">
                <i class="fab fa-facebook-square text-secondary fa-3x"></i>
            </a>
            <a href="#">
                <i class="fab fa-youtube-square fa-3x text-secondary"></i>
            </a>
            <a href="#">
                <i class="fab fa-twitter-square fa-3x text-secondary"></i>
            </a>
        </div>
    
        <div class="container d-flex justify-content-around pt-3">
            <div class="col-md-9 w-100">
                <p>&copy; 2020 Farmitrade &reg;</p>
            </div>
    
            <div class="col-md-3 flex-shrink-1">
                <a href="{{ route('contact.create') }}" class="text-decoration-none text-dark">Contact Us</a>
            </div>
        </div>
    </div>
</footer>
@yield('footer')