{{-- resources/views/user/partials/footer.blade.php --}}
<footer id="footer" class="overflow-hidden bg-light mt-5">
    <div class="container">
        <div class="row py-5">
            {{-- Brand + about --}}
            <div class="col-lg-3 col-sm-6 pb-4">
                <div class="footer-menu">
                    <img src="{{ asset('user/assets/images/main-logo.png') }}" alt="logo" class="mb-3"
                        style="max-height:42px">
                    <p class="mb-3">Nisi, purus vitae, ultrices nunc. Sit ac sit suscipit hendrerit. Gravida massa
                        volutpat
                        aenean odio erat nullam fringilla.</p>
                    <div class="social-links">
                        <ul class="d-flex list-unstyled gap-3">
                            <li><a href="#"><svg width="20" height="20">
                                        <use xlink:href="#facebook" />
                                    </svg></a></li>
                            <li><a href="#"><svg width="20" height="20">
                                        <use xlink:href="#instagram" />
                                    </svg></a></li>
                            <li><a href="#"><svg width="20" height="20">
                                        <use xlink:href="#twitter" />
                                    </svg></a></li>
                            <li><a href="#"><svg width="20" height="20">
                                        <use xlink:href="#linkedin" />
                                    </svg></a></li>
                            <li><a href="#"><svg width="20" height="20">
                                        <use xlink:href="#youtube" />
                                    </svg></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Quick links --}}
            <div class="col-lg-2 col-sm-6 pb-4">
                <div class="footer-menu text-uppercase">
                    <h5 class="widget-title pb-2">Quick Links</h5>
                    <ul class="menu-list list-unstyled">
                        <li class="pb-2"><a href="{{ url('/') }}#billboard">Home</a></li>
                        <li class="pb-2"><a href="{{ url('/about_us') }}">About</a></li>
                        <li class="pb-2"><a href="{{ route('produk.index') }}">Shop</a></li>
                        <li class="pb-2"><a href="#">Blogs</a></li>
                        <li class="pb-2"><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div>

            {{-- Help & info --}}
            <div class="col-lg-3 col-sm-6 pb-4">
                <div class="footer-menu text-uppercase">
                    <h5 class="widget-title pb-2">Help & Info</h5>
                    <ul class="menu-list list-unstyled">
                        <li class="pb-2"><a href="#">Track Your Order</a></li>
                        <li class="pb-2"><a href="#">Returns Policies</a></li>
                        <li class="pb-2"><a href="#">Shipping + Delivery</a></li>
                        <li class="pb-2"><a href="{{ url('/contact') }}">Contact Us</a></li>
                        <li class="pb-2"><a href="#">FAQs</a></li>
                    </ul>
                </div>
            </div>

            {{-- Contact --}}
            <div class="col-lg-4 col-sm-6 pb-4">
                <div class="footer-menu contact-item">
                    <h5 class="widget-title text-uppercase pb-2">Contact Us</h5>
                    <p class="mb-1">Any queries or suggestions? <a
                            href="mailto:yourinfo@gmail.com">yourinfo@gmail.com</a></p>
                    <p class="mb-3">Need support? Call us: <a href="tel:+5511122233344">+55 111 222 333 44</a></p>

                    <div class="d-flex align-items-center gap-3">
                        <span>We ship with:</span>
                        <div class="card-wrap">
                            <img src="{{ asset('user/assets/images/dhl.png') }}" alt="dhl" style="height:20px">
                            <img src="{{ asset('user/assets/images/shippingcard.png') }}" alt="ship"
                                style="height:20px">
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 mt-2">
                        <span>Payment options:</span>
                        <div class="card-wrap">
                            <img src="{{ asset('user/assets/images/visa.jpg') }}" alt="visa" style="height:20px">
                            <img src="{{ asset('user/assets/images/mastercard.jpg') }}" alt="mastercard"
                                style="height:20px">
                            <img src="{{ asset('user/assets/images/paypal.jpg') }}" alt="paypal" style="height:20px">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row py-3">
            <div class="col text-center">
                <p class="mb-0">© {{ date('Y') }} Waroeng koe. Design by
                    <a href="https://templatesjungle.com/" target="_blank" rel="noopener">TemplatesJungle</a>.
                    Distribution by <a href="https://themewagon.com" target="_blank" rel="noopener">ThemeWagon</a>.
                </p>
            </div>
        </div>
    </div>
</footer>
