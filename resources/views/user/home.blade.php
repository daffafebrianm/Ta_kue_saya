@extends('user.layouts.main')

@section('title', 'Home')


@section('products')

    <section id="mobile-products" class="product-section">

        <div class="container-fluid hero-header py-7 mb-5" data-aos="fade-down" style="background-color: #f8efe5;">
            <div class="container">
                <div class="row align-items-center g-5">

                    <!-- Left Content -->
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="display-4 fw-bold text-dark mb-3">
                            Freshly Baked <em>With Love & Passion</em>
                        </h1>

                        <p class="fs-5 text-dark mb-4">
                            Nikmati kelezatan kue buatan tangan dari
                            <strong>Waroeng Koe Ree Cake & Cookies</strong> —
                            dibuat dengan bahan berkualitas dan cinta di setiap gigitan.
                        </p>

                        <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                            <a href="{{ url('products') }}" class="btn btn-dark py-2 px-4 animated slideInRight">
                                Order Now
                            </a>
                            <a href="{{ url('https://api.whatsapp.com/send?phone=628116666604&text=Halo%20Waroeng%20Koe%2C%20saya%20ingin%20pesan%20kue!%20Berikut%20data%20saya%3A%0ANama%3A%0AAlamat%3A%0APesanan%3A') }}"
                                class="btn btn-outline-dark py-2 px-4 animated slideInRight">
                                Chat via WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Right Image -->
                    <div class="col-lg-6 text-center">
                        <img src="{{ asset('user/assets/images/Banner-kue.png') }}" alt="Fresh Cake"
                            class="img-fluid rounded-4" style="max-height: 500px;">
                    </div>

                </div>
            </div>
        </div>
        <!-- ===================== -->
        <!-- HERO SECTION END -->
        <!-- ===================== -->

        <div class="container my-5">
            <div class="category-grid">

                <a href="{{ route('products.index', ['category' => 6]) }}" class="cat-card">
                    <div class="cat-img">
                        <img src="{{ asset('user/assets/images/cookies.jpg') }}" alt="Kue Basah">
                    </div>
                    <div class="cat-title">Cookies</div>
                    <div class="cat-line"></div>
                </a>

                <a href="{{ route('products.index', ['category' => 7]) }}" class="cat-card">
                    <div class="cat-img">
                        <img src="{{ asset('user/assets/images/cakes.jpg') }}" alt="Kue Kering">
                    </div>
                    <div class="cat-title">Cakes</div>
                    <div class="cat-line"></div>
                </a>

                <a href="{{ route('products.index', ['category' => 8]) }}" class="cat-card">
                    <div class="cat-img">
                        <img src="{{ asset('user/assets/images/dry-cakes.jpg') }}" alt="Hampers">
                    </div>
                    <div class="cat-title">Dry Cake</div>
                    <div class="cat-line"></div>
                </a>
            </div>
            {{-- ===================== --}}
            {{-- PRODUK --}}
            {{-- ===================== --}}

        </div>
    </section>

    <!-- Feature Section Start -->
    <section class="features py-5" style="background-color: #fff9f0;">
        <div class="container text-center">
            <h3 class="fw-bold mb-5">Kenapa Memilih Kami</h3>
            <div class="row g-4 justify-content-center">
                <!-- Feature Card 1 -->
                <div class="col-md-4 col-sm-6">
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
                <div class="col-md-4 col-sm-6">
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
                <div class="col-md-4 col-sm-6">
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
    <!-- Feature Section End -->


    {{-- ===================== --}}
    {{-- PROMO SHOP --}}
    {{-- ===================== --}}
    <section class="promo-section">
        <div class="container">
            <div class="row align-items-center g-4 my-5">
                <div class="col-12 col-md-7">
                    <div class="promo-img-wrap">
                        <img src="{{ asset('user/assets/images/dessertbox.jpg') }}" class="promo-image" alt="Promo">
                    </div>
                </div>

                <div class="col-12 col-md-5">
                    <div class="promo-content">
                        <h2>
                            Be the early bird<br>
                            and get special offer!
                        </h2>

                        <a href="{{ route('products.index') }}" class="promo-link">
                            SHOP NOW
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="cake-section py-5">
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
    </section>

    <div class="container-fluid py-5" style="background-color: #ffffff;" data-aos="zoom-in">
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
    </div>



@endsection

@section('footer')
    @include('user.partials.footer')
@endsection

@push('styles')
    <style>
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

        .promo-section {
            background: #fff;
            padding: 70px 0;
            /* sebelumnya 100px, kebesaran */
        }

        .promo-row {
            gap: 18px;
            /* biar jarak rapi */
        }

        .promo-img-wrap {
            max-width: 640px;
            /* ukuran gambar jadi “lebih kecil” */
            margin: 0 auto;
            /* center di kolom */
        }

        .promo-image {
            width: 100%;
            height: 320px;
            /* bikin tinggi konsisten seperti contoh */
            object-fit: cover;
            border-radius: 10px;
            display: block;
        }

        .promo-content h2 {
            font-size: 42px;
            color: black;
            margin-bottom: 25px;
        }

        @media (max-width: 992px) {
            .promo-img-wrap {
                max-width: 520px;
            }

            .promo-image {
                height: 280px;
            }

            .promo-content h2 {
                font-size: 34px;
            }
        }

        @media (max-width: 576px) {
            .promo-section {
                padding: 50px 0;
            }

            .promo-img-wrap {
                max-width: 100%;
            }

            .promo-image {
                height: 220px;
            }
        }

        /* =====================
                                   ABOUT
                                ===================== */
        .about-section {
            padding: 80px 0;
            background: #fff9f0;
        }

        .about-img-wrap {
            max-width: 520px;
            /* batas ukuran biar gak kegedean */
            margin-left: auto;
            /* dorong ke kanan biar rapi */
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 18px 40px rgba(16, 24, 40, .12);
        }

        .about-image {
            width: 100%;
            height: 340px;
            /* tinggi konsisten */
            object-fit: cover;
            display: block;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .about-img-wrap {
                max-width: 460px;
                margin: 0 auto;
                /* center kalau layar mengecil */
            }

            .about-image {
                height: 300px;
            }
        }

        @media (max-width: 576px) {
            .about-img-wrap {
                max-width: 100%;
            }

            .about-image {
                height: 220px;
            }
        }

        /*** Hero Header ***/
        .hero-header {
            position: relative;
            margin-top: -85px;
            padding-top: 10rem;
            padding-bottom: 5rem;
            background: #fff9f0;
            /* base putih */
        }

        .hero-header::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 55%;
            height: 100%;
            background: #dfc8a7;
            clip-path: polygon(20% 0%, 100% 0%, 100% 100%, 0% 100%);
            z-index: 0;
        }

        .hero-header .container {
            position: relative;
            z-index: 1;
        }

        .hero-header .breadcrumb-item+.breadcrumb-item::before {
            color: var(--bs-light);
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
    </style>
@endpush
