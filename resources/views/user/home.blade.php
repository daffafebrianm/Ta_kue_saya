@extends('user.layouts.main')

@section('title', 'Home')


@section('products')


    <!-- Floating WhatsApp Button -->
    <a href="https://api.whatsapp.com/message/LSTUC4YSGLHVL1?autoload=1&app_absent=0&utm_source=ig" class="whatsapp-float"
        target="_blank" data-aos="fade-up" data-aos-duration="800" data-aos-easing="ease-out-cubic">
        <i class="fab fa-whatsapp"></i>
    </a>


  <!-- Banner Carousel -->
<div id="bannerCarousel" class="carousel slide"
     data-bs-ride="carousel"
     data-bs-interval="4500"
     data-aos="fade-up"
     data-aos-duration="900"
     data-aos-easing="ease-out-cubic">

    <!-- Dot Indicators -->
    <div class="carousel-indicators custom-indicators">
        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active" aria-current="true"
            aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active position-relative">
            <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=1920&auto=format&fit=crop"
                class="d-block w-100 banner-img" alt="Kue Cokelat"
                data-aos="zoom-out"
                data-aos-duration="1000">

            <div class="banner-overlay"
                 data-aos="fade-in"
                 data-aos-duration="900"></div>

            <div class="banner-text position-absolute top-50 start-50 translate-middle text-center text-white"
                 data-aos="fade-up"
                 data-aos-delay="250"
                 data-aos-duration="900"
                 data-aos-easing="ease-out-cubic">
                <h1 class="fw-bold mb-3 display-4 text-uppercase"
                    data-aos="fade-down"
                    data-aos-delay="350"
                    data-aos-duration="800">
                    Waroeng Koe Ree
                </h1>

                <p class="fs-5 fst-italic mb-4"
                   data-aos="fade-up"
                   data-aos-delay="450"
                   data-aos-duration="800">
                    Cake & Cookies yang dibuat dengan cinta dan bahan terbaik
                </p>

                <a href="{{ route('products.index') }}" class="btn-modern"
                   data-aos="zoom-in"
                   data-aos-delay="600"
                   data-aos-duration="700">
                    Lihat Menu
                </a>
            </div>
        </div>

        <!-- Slide 2 : Tentang Kami -->
        <div class="carousel-item position-relative">
            <img src="https://images.unsplash.com/photo-1587293852726-70cdb56c2866?q=80&w=1920&auto=format&fit=crop"
                class="d-block w-100 banner-img" alt="Cupcake Manis Buatan Kami"
                data-aos="zoom-out"
                data-aos-duration="1000">

            <div class="banner-overlay"
                 data-aos="fade-in"
                 data-aos-duration="900"></div>

            <div class="banner-text position-absolute top-50 start-50 translate-middle text-center text-white px-3"
                 data-aos="fade-up"
                 data-aos-delay="250"
                 data-aos-duration="900"
                 data-aos-easing="ease-out-cubic">

                <h1 class="fw-bold mb-3 display-5 text-uppercase"
                    data-aos="fade-down"
                    data-aos-delay="350"
                    data-aos-duration="800">
                    Tentang Kami
                </h1>

                <p class="fs-5 fst-italic mb-4"
                   data-aos="fade-up"
                   data-aos-delay="450"
                   data-aos-duration="800">
                    Dari dapur kecil dengan cinta besar — kami menyajikan rasa,
                    kualitas, dan kehangatan di setiap gigitan.
                </p>

                <a href="{{ route('about.index') }}" class="btn-modern"
                   data-aos="zoom-in"
                   data-aos-delay="600"
                   data-aos-duration="700">
                    Kenali Cerita Kami
                </a>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item position-relative">
            <img src="https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?q=80&w=1920&auto=format&fit=crop"
                class="d-block w-100 banner-img" alt="Cookies Premium"
                data-aos="zoom-out"
                data-aos-duration="1000">

            <div class="banner-overlay"
                 data-aos="fade-in"
                 data-aos-duration="900"></div>

            <div class="banner-text position-absolute top-50 start-50 translate-middle text-center text-white"
                 data-aos="fade-up"
                 data-aos-delay="250"
                 data-aos-duration="900"
                 data-aos-easing="ease-out-cubic">

                <h1 class="fw-bold mb-3 display-5 text-uppercase"
                    data-aos="fade-down"
                    data-aos-delay="350"
                    data-aos-duration="800">
                    Temukan Kue Favorit Kamu
                </h1>

                <p class="fs-5 fst-italic mb-4"
                   data-aos="fade-up"
                   data-aos-delay="450"
                   data-aos-duration="800">
                    Cookies renyah dan cake lembut — teman sempurna untuk hari Anda
                </p>

                <a href="{{ route('products.index') }}" class="btn-modern"
                   data-aos="zoom-in"
                   data-aos-delay="600"
                   data-aos-duration="700">
                    Pesan Sekarang
                </a>
            </div>
        </div>

    </div>
</div>



    <section id="mobile-products" class="product-section">
        <div class="container my-5">

            <!-- Section Title -->
            <div class="section-header text-center mb-5" data-aos="fade-down" data-aos-duration="900"
                data-aos-easing="ease-out-cubic">
                <h2>Kategori Favorit Kami</h2>
                <p>Pilih kategori dan temukan camilan terbaik hari ini</p>
            </div>

            <div class="category-grid">

                <a href="{{ route('products.index') }}?category=Cookies" class="cat-card" data-aos="fade-up"
                    data-aos-delay="0" data-aos-duration="800" data-aos-easing="ease-out-cubic">
                    <div class="cat-img">
                        <img src="{{ asset('user/assets/images/cookies.jpg') }}" alt="Cookies">
                    </div>
                    <div class="cat-title">Cookies</div>
                    <div class="cat-line"></div>
                </a>

                <a href="{{ route('products.index') }}?category=Cakes" class="cat-card" data-aos="fade-up"
                    data-aos-delay="150" data-aos-duration="800" data-aos-easing="ease-out-cubic">
                    <div class="cat-img">
                        <img src="{{ asset('user/assets/images/cakes.jpg') }}" alt="Cakes">
                    </div>
                    <div class="cat-title">Cakes</div>
                    <div class="cat-line"></div>
                </a>

                <a href="{{ route('products.index') }}?category=Dry%20Cake" class="cat-card" data-aos="fade-up"
                    data-aos-delay="300" data-aos-duration="800" data-aos-easing="ease-out-cubic">
                    <div class="cat-img">
                        <img src="{{ asset('user/assets/images/dry-cakes.jpg') }}" alt="Dry Cake">
                    </div>
                    <div class="cat-title">Dry Cake</div>
                    <div class="cat-line"></div>
                </a>

            </div>

        </div>
    </section>



    <section class="home-products">
        <div class="container">

            <!-- SECTION HEADER -->
            <div class="section-header text-center mb-5" data-aos="fade-up" data-aos-duration="700">
                <h1>Produk Unggulan</h1>
                <p>Kualitas terbaik untuk pengalaman terbaik</p>
            </div>

            <!-- PRODUCT GRID -->
            <div class="home-product-grid">
                @foreach ($produks as $index => $produk)
                    <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                        data-aos-duration="700">

                        <a href="{{ route('detail.index', $produk->id) }}" class="product-thumb">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}">
                        </a>

                        <div class="product-name">
                            {{ $produk->nama }}
                        </div>

                        <div class="product-price">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </div>

                        <div class="product-action">
                            @auth
                                <form action="{{ route('keranjang.store') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="btn-cart-oval">
                                        ADD TO CART
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn-cart-oval d-inline-block text-center">
                                    ADD TO CART
                                </a>
                            @endauth
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>



    <section class="features py-5" style="background-color: #fff9f0;">
        <div class="container text-center">

            <!-- SECTION TITLE -->
            <h3 class="fw-bold mb-5" data-aos="fade-up" data-aos-duration="700">
                Kenapa Memilih Kami
            </h3>

            <div class="row g-4 justify-content-center">

                <!-- Feature Card 1 -->
                <div class="col-md-4 col-sm-6" data-aos="zoom-in-up" data-aos-delay="0" data-aos-duration="800"
                    data-aos-easing="ease-out-cubic">
                    <div class="feature-card p-4 h-100 text-center shadow-sm border-0 rounded-4 bg-white hover-effect">
                        <div class="icon-wrapper mb-3">
                            <img src="{{ asset('user/assets/images/logo-1.png') }}" alt="Bahan Fresh" class="img-fluid"
                                style="max-width: 80px;">
                        </div>
                        <h5 class="fw-bold text-dark">Bahan Fresh</h5>
                        <p class="text-muted mb-0">Bahan-bahan segar untuk rasa autentik setiap hari.</p>
                    </div>
                </div>

                <!-- Feature Card 2 -->
                <div class="col-md-4 col-sm-6" data-aos="zoom-in-up" data-aos-delay="150" data-aos-duration="800"
                    data-aos-easing="ease-out-cubic">
                    <div class="feature-card p-4 h-100 text-center shadow-sm border-0 rounded-4 bg-white hover-effect">
                        <div class="icon-wrapper mb-3">
                            <img src="{{ asset('user/assets/images/logo-2.png') }}" alt="Pengalaman" class="img-fluid"
                                style="max-width: 80px;">
                        </div>
                        <h5 class="fw-bold text-dark">Pengalaman</h5>
                        <p class="text-muted mb-0">Outlet menarik dan pelayanan profesional.</p>
                    </div>
                </div>

                <!-- Feature Card 3 -->
                <div class="col-md-4 col-sm-6" data-aos="zoom-in-up" data-aos-delay="300" data-aos-duration="800"
                    data-aos-easing="ease-out-cubic">
                    <div class="feature-card p-4 h-100 text-center shadow-sm border-0 rounded-4 bg-white hover-effect">
                        <div class="icon-wrapper mb-3">
                            <img src="{{ asset('user/assets/images/logo-3.png') }}" alt="Lezat" class="img-fluid"
                                style="max-width: 80px;">
                        </div>
                        <h5 class="fw-bold text-dark">Lezat</h5>
                        <p class="text-muted mb-0">Kelezatan tiada tara, setiap gigitan memikat.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===================== --}}
    {{-- PROMO SHOP --}}
    {{-- ===================== --}}
    <section class="promo-section">
        <div class="container">
            <div class="row align-items-center g-4 my-5">

                <!-- Image -->
                <div class="col-12 col-md-7" data-aos="fade-right" data-aos-duration="900"
                    data-aos-easing="ease-out-cubic">
                    <div class="promo-img-wrap">
                        <img src="{{ asset('user/assets/images/dessertbox.jpg') }}" class="promo-image"
                            alt="Promo Dessert">
                    </div>
                </div>

                <!-- Content -->
                <div class="col-12 col-md-5" data-aos="fade-left" data-aos-duration="900" data-aos-delay="120"
                    data-aos-easing="ease-out-cubic">
                    <div class="promo-content">

                        <h2 data-aos="fade-up" data-aos-delay="220" data-aos-duration="700">
                            Jadi yang Pertama<br>
                            Nikmati Penawaran Spesial
                        </h2>

                        <p data-aos="fade-up" data-aos-delay="320" data-aos-duration="700">
                            Dapatkan produk pilihan dengan harga terbaik.
                            Jangan lewatkan kesempatan ini!
                        </p>

                        <a href="{{ route('products.index') }}" class="promo-link" data-aos="zoom-in"
                            data-aos-delay="420" data-aos-duration="650">
                            Belanja Sekarang
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </section>



    {{--  <section class="cake-section py-5">
        <div class="container">
            <div class="card cake-card border-0 shadow-lg overflow-hidden rounded-4">
                <div class="row g-0 align-items-center">
                    <!-- Gambar (kanan di desktop, atas di mobile) -->
                    <div class="col-lg-6 order-lg-2">
                        <div class="ratio ratio-4x3">
                            <img src="{{ asset('user/assets/img/cake1.png') }}"
                                alt="Kue Spesial Waroeng Koe Ree Cake & Cookies" class="w-100 h-100 object-fit-cover"
                                loading="lazy">
                        </div>
                    </div>

                    <!-- Konten -->
                    <div class="col-lg-6 order-lg-1">
                        <div class="p-4 p-lg-5">
                            <h2 class="display-6 fw-bold mb-3 text-brown">Kue Spesial Kami</h2>
                            <p class="text-muted mb-4 text-justify">
                                Di <strong>Waroeng Koe Ree Cake & Cookies</strong>, setiap kue dibuat dengan penuh cinta dan
                                bahan pilihan terbaik.
                                Kami menghadirkan berbagai varian kue dan cookies yang lembut, manis, dan menggugah
                                selera—sempurna untuk
                                momen spesial Anda, dari ulang tahun hingga hantaran istimewa.
                            </p>
                            <p class="text-muted mb-4 text-justify">
                                Nikmati cita rasa autentik dari resep keluarga dengan sentuhan modern.
                                Karena bagi kami, setiap gigitan kue adalah cara untuk berbagi kebahagiaan.
                            </p>

                            <!-- Badge kecil / highlight -->
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                Fresh Baked • Handmade with Love
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Aksen gradient dekoratif -->
                <div class="cake-accent d-none d-lg-block"></div>
            </div>
        </div>
    </section>  --}}

    {{--  <div class="container-fluid py-5" style="background-color: #ffffff;" data-aos="zoom-in">
        <div class="container">
            <div class="row align-items-center">
                <!-- Kiri -->
                <div class="col-md-6 mb-4">
                    <p class="section-subtitle text-uppercase text-brown fw-semibold">
                        Waroeng Koe Ree Cake & Cookies – Homemade & Fresh!
                    </p>
                    <h2 class="section-title fw-bold text-dark">
                        Nikmati Kelezatan Kue dan Cookies Spesial Setiap Hari!
                    </h2>
                    <p class="section-desc text-muted">
                        <strong>Waroeng Koe Ree</strong> menghadirkan berbagai pilihan cake dan cookies lezat
                        yang dibuat dengan bahan premium dan tanpa pengawet.
                        Cocok untuk momen spesial, hampers, atau sekadar teman ngopi sore Anda.
                    </p>
                    <a href="{{ url('https://api.whatsapp.com/send?phone=628116666604&text=Nama%20:%0ANo%20HP%20:%0AAlamat%20:%0AHalo,%20saya%20ingin%20pesan%20kue%20dari%20Waroeng%20Koe%20Ree') }}"
                        class="btn btn-outline-brown rounded-pill px-4">
                        Pesan Sekarang!
                    </a>
                </div>

                <!-- Kanan -->
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="info-card bg-white shadow-lg rounded-4 p-4">
                        <h4 class="info-title d-flex align-items-center mb-3">
                            <img src="{{ asset('user/assets/img/clock.png') }}" alt="Jam Operasional" class="me-2"
                                style="width: 32px; height: 32px;">
                            Jam Operasional
                        </h4>
                        <hr class="mb-3">
                        <p><strong>Toko & Pemesanan</strong><br> Senin – Minggu : 10:00 – 21:00 WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>  --}}

    <section class="operational-section">
        <div class="operational-card" data-aos="zoom-in" data-aos-duration="800" data-aos-easing="ease-out-cubic">

            <div class="icon-operasional" data-aos="zoom-in" data-aos-delay="150" data-aos-duration="600">
                <i class="bi bi-clock-fill"></i>
            </div>

            <span class="status-badge" data-aos="fade-up" data-aos-delay="250" data-aos-duration="600">
                Buka Setiap Hari
            </span>

            <h4 data-aos="fade-up" data-aos-delay="320" data-aos-duration="600">
                Jam Operasional
            </h4>

            <p class="schedule" data-aos="fade-up" data-aos-delay="380" data-aos-duration="600">
                <span>Senin – Minggu</span>
                <strong>10:00 – 21:00 WIB</strong>
            </p>

            <p class="subtext" data-aos="fade-up" data-aos-delay="440" data-aos-duration="600">
                Kami siap melayani Anda setiap hari dengan pelayanan terbaik.
            </p>

        </div>
    </section>






@endsection

@section('footer')
    @include('user.partials.footer')
@endsection

@push('styles')
    <style>
        {{--  ================ Jam Operasinal =================  --}} .operational-section {
            min-height: 55vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff9f0;
            font-family: "Poppins", sans-serif;
            padding: 60px 20px;
        }

        /* Card */
        .operational-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 42px 46px;
            text-align: center;
            max-width: 420px;
            width: 100%;
            border: 1px solid rgba(212, 183, 142, 0.35);
            box-shadow: 0 22px 48px rgba(212, 183, 142, 0.35);
            transition: all 0.35s ease;
        }

        .operational-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 32px 70px rgba(212, 183, 142, 0.45);
        }

        /* Icon */
        .icon-operasional {
            width: 76px;
            height: 76px;
            margin: 0 auto 14px;
            background: linear-gradient(135deg, #d4b78e, #caa36a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 16px 30px rgba(212, 183, 142, 0.5);
        }

        .icon-operasional i {
            font-size: 2.3rem;
            color: #ffffff;
        }

        /* Status badge */
        .status-badge {
            display: inline-block;
            margin-bottom: 14px;
            padding: 5px 16px;
            font-size: 0.7rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-radius: 999px;
            background: rgba(212, 183, 142, 0.25);
            color: #8a6b3f;
            font-weight: 600;
        }

        /* Title */
        .operational-card h4 {
            font-size: 1.5rem;
            margin-bottom: 16px;
            font-weight: 600;
            color: #7a5b34;
        }

        /* Schedule */
        .schedule span {
            display: block;
            font-size: 0.95rem;
            color: #7a6856;
            margin-bottom: 8px;
        }

        .schedule strong {
            display: inline-block;
            padding: 10px 24px;
            background: #fff3e2;
            border-radius: 14px;
            font-weight: 600;
            letter-spacing: 0.7px;
            color: #5a4630;
        }

        /* Subtext */
        .subtext {
            margin-top: 16px;
            font-size: 0.9rem;
            color: #8a7a66;
            line-height: 1.6;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .operational-card {
                padding: 38px 26px;
            }

            .operational-card h4 {
                font-size: 1.3rem;
            }
        }

        {{--  ============== Home Product ===============  --}} .home-products {
            padding: 70px 0;
            background: #ffffff;
            font-family: "Poppins", sans-serif;
        }

        /* HEADER */
        .section-header h1 {
            font-size: 38px;
            font-weight: 600;
            color: #7a3e14;
            margin-bottom: 6px;
        }

        .section-header h2 {
            font-size: 38px;
            font-weight: 600;
            color: #d19a48;
            margin-bottom: 6px;
        }

        .section-header p {
            font-size: 16px;
            color: #9a9a9a;
        }

        /* GRID */
        .home-product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 36px;
        }

        @media (max-width: 992px) {
            .home-product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .home-product-grid {
                grid-template-columns: 1fr;
            }
        }

        /* CARD */
        .product-card {
            text-align: center;
            display: flex;
            flex-direction: column;
            transition: transform .25s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
        }

        /* IMAGE (ANTI CROP) */
        .product-thumb {
            height: 190px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .product-thumb img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            /* ⬅️ PENTING */
        }

        /* NAME */
        .product-name {
            font-size: 16px;
            font-weight: 500;
            color: #7a3e14;
            margin-bottom: 4px;
        }

        /* PRICE */
        .product-price {
            font-size: 14px;
            color: #9a9a9a;
            margin-bottom: 12px;
        }

        /* BUTTON */
        .product-action {
            margin-top: auto;
        }

        .btn-cart-oval {
            background: transparent;
            border: 1px solid #e5d3b3;
            color: #7a3e14;
            padding: 7px 0;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
            transition: all .25s ease;
            width: 100%;
            cursor: pointer;
        }

        .btn-cart-oval:hover {
            background: #7a3e14;
            color: #ffffff;
        }


        /* =====================
                                                                            GENERAL
                                                                    ===================== */
        body {
            background-color: #FFF6EA;
        }

        /* =====================
                                                                        PRODUK SECTION
                                                                    ===================== */
        .product-section {
            padding: 80px 0;
        }

        .product-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .product-header h2 {
            font-size: 32px;
            letter-spacing: 2px;
            margin: 0;
        }

        /* =====================
                                                                                                                   CATEGORY GRID (Klik Gambar) - ukuran rapi kayak contoh
                                                                                                                ===================== */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 28px;
            max-width: 1180px;
            margin: 0 auto 55px;
            padding: 0 12px;
        }

        .cat-card {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        /* kunci: tinggi gambar fix + crop */
        .cat-img {
            width: 100%;
            height: 320px;
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 26px rgba(16, 24, 40, .10);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .cat-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .cat-title {
            text-align: center;
            margin-top: 14px;
            font-size: 24px;
            font-weight: 500;
            letter-spacing: .04em;
        }

        .cat-line {
            width: 72%;
            height: 2px;
            background: #d8dadd;
            border-radius: 999px;
            margin: 12px auto 0;
        }

        .cat-card:hover .cat-img {
            transform: translateY(-3px);
            box-shadow: 0 16px 36px rgba(16, 24, 40, .16);
        }

        /* jika item kategori kamu 4, yang ke-4 akan turun baris kedua (rapi di tengah) */
        .cat-card:nth-child(4) {
            grid-column: 2 / span 1;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .category-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 22px;
                margin-bottom: 40px;
            }

            .cat-img {
                height: 260px;
            }

            .cat-title {
                font-size: 20px;
            }

            .cat-card:nth-child(4) {
                grid-column: auto;
            }
        }

        @media (max-width: 576px) {
            .category-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .cat-img {
                height: 230px;
            }
        }

        .product-card {
            text-align: center;
            padding: 10px;
        }

        .product-image {
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 14px;
            display: block;
        }

        .product-name {
            font-size: 16px;
            font-weight: 700;
            margin: 8px 0 6px;
        }

        .item-price {
            display: block;
            margin-bottom: 12px;
            font-weight: 700;
            color: black;
        }

        .btn-category-oval {
            border: 2px solid #b78b6f;
            background: transparent;
            color: #7a5230;
            border-radius: 50px;
            padding: 8px 20px;
            font-size: 14px;
            transition: .3s;
            text-decoration: none;
        }

        .btn-category-oval:hover {
            background: #b78b6f;
            color: #fff;
        }

        /* ===== PROMO SECTION ===== */
        .promo-section {
            background: linear-gradient(135deg, #fffaf4, #ffffff);
            padding: 80px 0;
            font-family: "Poppins", sans-serif;
        }

        /* ROW */
        .promo-row {
            gap: 28px;
            align-items: center;
        }

        /* IMAGE */
        .promo-img-wrap {
            max-width: 620px;
            margin: 0 auto;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
            transition: transform .35s ease, box-shadow .35s ease;
        }

        .promo-img-wrap:hover {
            transform: translateY(-6px);
            box-shadow: 0 28px 60px rgba(0, 0, 0, 0.18);
        }

        .promo-image {
            width: 100%;
            height: 340px;
            object-fit: cover;
            display: block;
            transition: transform .45s ease;
        }

        .promo-img-wrap:hover .promo-image {
            transform: scale(1.05);
        }

        /* CONTENT */
        .promo-content h2 {
            font-size: 40px;
            font-weight: 800;
            color: #111827;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .promo-content p {
            font-size: 15px;
            color: #ffffff;
            margin-bottom: 28px;
            max-width: 420px;
        }

        /* BUTTON */
        .promo-link {
            display: inline-block;
            padding: 14px 34px;
            border-radius: 999px;
            background: #d4b78e;
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .06em;
            text-decoration: none;
            transition: all .3s ease;
            border: none;
            outline: none;
        }

        /* HOVER */
        .promo-link:hover {
            background: #c7a874;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(117, 87, 46, 0.5);
        }

        /* AKTIF + FOCUS + VISITED (INI YANG PENTING) */
        .promo-link:active,
        .promo-link:focus,
        .promo-link:visited {
            background: #d4b78e;
            color: #ffffff !important;
            text-decoration: none;
            outline: none;
            box-shadow: 0 8px 20px rgba(117, 87, 46, 0.4);
        }


        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .promo-img-wrap {
                max-width: 520px;
            }

            .promo-image {
                height: 280px;
            }

            .promo-content h2 {
                font-size: 32px;
            }
        }

        @media (max-width: 576px) {
            .promo-section {
                padding: 60px 0;
            }

            .promo-img-wrap {
                max-width: 100%;
            }

            .promo-image {
                height: 220px;
            }

            .promo-content h2 {
                font-size: 26px;
            }
        }

        {{--  =============== Banner  ==============  --}} .banner-img {
            height: 100vh;
            object-fit: cover;
            filter: brightness(55%) saturate(120%);
            transition: transform 8s ease-in-out;
        }

        .carousel-item.active .banner-img {
            transform: scale(1.07);
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(2px);
        }

        .banner-text {
            z-index: 2;
            animation: fadeInUp 1.5s ease;
        }

        /* Tombol Modern */
        .btn-modern {
            background: linear-gradient(90deg, #f8b84e, #f1a238);
            color: #fff;
            padding: 12px 36px;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.4s ease;
            box-shadow: 0 4px 12px rgba(249, 184, 78, 0.4);
        }

        .btn-modern:hover {
            background: linear-gradient(90deg, #f1a238, #f8b84e);
            color: #fff;
            transform: scale(1.07);
            box-shadow: 0 6px 16px rgba(249, 184, 78, 0.6);
        }

        /* Dot Indicator Modern (Lebih kecil & putih) */
        .custom-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
            margin: 0 5px;
        }

        .custom-indicators .active {
            background-color: #ffffff;
            width: 11px;
            height: 11px;
        }

        /* Animasi Teks */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cake-card {
            position: relative;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .cake-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 1.25rem 2.5rem rgba(0, 0, 0, .12);
        }

        .cake-accent {
            position: absolute;
            inset: 0 auto 0 0;
            width: 38%;
            background: radial-gradient(120% 100% at 0% 50%, rgba(205, 32, 2, .12), transparent 60%);
            pointer-events: none;
        }

        /* Utilities untuk badge Bootstrap 5.3+ fallback */
        .bg-danger-subtle {
            background-color: rgba(205, 32, 2, .12) !important;
        }

        .text-danger-emphasis {
            color: #cd2002 !important;
        }

        .features h3 {
            font-size: 2rem;
        }

        @media (max-width: 576px) {
            .features h3 {
                font-size: 1.6rem;
            }
        }

        .feature-card {
            transition: transform .35s ease, box-shadow .35s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 18px 45px rgba(0, 0, 0, .15);
        }
    </style>
@endpush
