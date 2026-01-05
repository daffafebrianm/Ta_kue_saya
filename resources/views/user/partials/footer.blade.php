<footer id="footer" class="footer-area py-5" style="background-color:#d4b78e;">
    <div class="container">
        <div class="row">
            {{-- Brand & About --}}
            <div class="col-lg-3 col-sm-6 pb-4">
                <div class="footer-brand">
                    <img src="{{ asset('user/assets/images/icon-kue.png') }}" alt="logo" class="mb-3" style="max-height:150px">
                    <div class="social-links">
                        <ul class="d-flex list-unstyled gap-3 mb-0">
                            <li><a href="#"><i class="fab fa-facebook-f" style="color:white;"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram" style="color:white;"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter" style="color:white;"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in" style="color:white;"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube" style="color:white;"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-3 col-sm-6 pb-4">
                <div class="footer-links">
                    <h5 class="widget-title text-uppercase mb-3" style="color:white;">Information</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}#billboard" style="color:white;">Home</a></li>
                        <li><a href="{{ url('/about_us') }}" style="color:white;">About</a></li>
                        <li><a href="{{ route('products.index') }}" style="color:white;">Shop</a></li>
                        <li><a href="{{ url('/location') }}" style="color:white;">Location</a></li>
                    </ul>
                </div>
            </div>

            {{-- Location --}}
            <div class="col-lg-3 col-sm-6 pb-4">
                <div class="footer-links">
                    <h5 class="widget-title text-uppercase mb-3" style="color:white;">Location</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/location') }}" style="color:white;">Store Locations</a></li>
                        <li><a href="{{ url('/location') }}" style="color:white;">Find Us on the Map</a></li>
                        <li style="color:white;">Jl. H. Al Sudin Pal 2, Bangko Lamo, Pasir Putih</li>
                        <li style="color:white;">Muara Bungo, Indonesia</li>
                    </ul>
                </div>
            </div>
        </div>

        <hr>

        <div class="row text-center">
            <div class="col-12">
                <p class="mb-0" style="color: white;">
                    © 2025 Waroeng Koe Ree Cake & Cookies | Crafted with love, baked with passion.
                </p>
            </div>
        </div>
    </div>
</footer>
