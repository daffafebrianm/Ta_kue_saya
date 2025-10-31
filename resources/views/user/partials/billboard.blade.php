<section id="billboard" class="position-relative overflow-hidden bg-light-blue">
    <div class="swiper main-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6">
                            <div class="banner-content">
                                <h1 class="display-2 text-uppercase text-dark pb-5">Your Products Are Great.</h1>
                                <!-- Tombol menuju produk -->
                                <a href="{{ route('products.index') }}"
                                   class="btn btn-medium btn-dark text-uppercase btn-rounded-none">
                                    Shop Product
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="image-holder">
                                <img src="{{ asset('user/assets/images/banner-image.png') }}" alt="banner">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 2 --}}
            <div class="swiper-slide">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6">
                            <div class="banner-content">
                                <h1 class="display-2 text-uppercase text-dark pb-5">Your Products Are Great.</h1>
                                <!-- Tombol menuju produk -->
                                <a href="{{ route('products.index') }}"
                                   class="btn btn-medium btn-dark text-uppercase btn-rounded-none">
                                    Shop Product
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="image-holder">
                                <img src="{{ asset('user/assets/images/banner-image.png') }}" alt="banner">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="swiper-icon swiper-arrow swiper-arrow-prev">
        <svg class="chevron-left">
            <use xlink:href="#chevron-left" />
        </svg>
    </div>
    <div class="swiper-icon swiper-arrow swiper-arrow-next">
        <svg class="chevron-right">
            <use xlink:href="#chevron-right" />
        </svg>
    </div>
</section>

@push('scripts')
    <script>
        // init hero slider jika ada di halaman
        document.addEventListener('DOMContentLoaded', function() {
            if (document.querySelector('#billboard .main-swiper')) {
                new Swiper('#billboard .main-swiper', {
                    slidesPerView: 1,
                    loop: true,
                    autoplay: {
                        delay: 5000
                    },
                    navigation: {
                        nextEl: '.swiper-arrow-next',
                        prevEl: '.swiper-arrow-prev',
                    },
                });
            }
        });
    </script>
@endpush
