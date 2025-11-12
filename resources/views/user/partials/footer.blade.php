<footer id="footer" class="footer-area py-5" style="background-color:#d4b78e;">
    <div class="container">
        <div class="row">
            {{-- Brand & About --}}
            <div class="col-lg-3 col-sm-6 pb-4">
                <div class="footer-brand">
                    <img src="{{ asset('images/bg-login1.jpg') }}" alt="logo" class="mb-3" style="max-height:42px">
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
                    <h5 class="widget-title text-uppercase mb-3" style="color:white;">CATEGORIES</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}#billboard" style="color:white;">Home</a></li>
                        <li><a href="{{ url('/about_us') }}" style="color:white;">About</a></li>
                        <li><a href="{{ route('products.index') }}" style="color:white;">Shop</a></li>
                        <li><a href="#" style="color:white;">Blogs</a></li>
                        <li><a href="{{ url('/contact') }}" style="color:white;">Contact</a></li>
                    </ul>
                </div>
            </div>

            {{-- Contact & Information --}}
            <div class="col-lg-3 col-sm-6 pb-4">
                <div class="footer-contact">
                    <h5 class="widget-title text-uppercase mb-3" style="color:white;">INFORMATION</h5>
                    <p class="mb-1" style="color:white;">Any queries or suggestions? <a href="mailto:yourinfo@gmail.com" style="color:white;">yourinfo@gmail.com</a></p>
                    <p class="mb-3" style="color:white;">Need support? Call us: <a href="tel:+5511122233344" style="color:white;">+55 111 222 333 44</a></p>

                    <div class="d-flex align-items-center gap-3">
                        <span style="color:white;">We ship with:</span>
                        <img src="{{ asset('user/assets/images/dhl.png') }}" alt="dhl" style="height:20px">
                        <img src="{{ asset('user/assets/images/shippingcard.png') }}" alt="ship" style="height:20px">
                    </div>

                    <div class="d-flex align-items-center gap-3 mt-2">
                        <span style="color:white;">Payment options:</span>
                        <img src="{{ asset('user/assets/images/visa.jpg') }}" alt="visa" style="height:20px">
                        <img src="{{ asset('user/assets/images/mastercard.jpg') }}" alt="mastercard" style="height:20px">
                        <img src="{{ asset('user/assets/images/paypal.jpg') }}" alt="paypal" style="height:20px">
                    </div>
                </div>
            </div>

            {{-- Newsletter --}}
            <div class="col-lg-3 col-sm-6 pb-4">
                <div class="footer-newsletter">
                    <h5 class="widget-title text-uppercase mb-3" style="color:white;">SUBSCRIBE</h5>
                    <p style="color:white;">Stay updated with our latest offers and news.</p>
                    <form action="#" method="post">
                        <input type="email" placeholder="Your email address" class="form-control mb-2" required>
                        <button type="submit" class="btn btn-primary w-100" style="background-color:white;">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>

        <hr>

        <div class="row text-center">
            <div class="col-12">
                <p class="mb-0" style="color:white;">© 2025 Clairmont. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

