@extends('user.layouts.main')

@section('title', 'Home')


@section('products')

    {{-- ===================== --}}
    {{-- PRODUK SECTION --}}
    {{-- ===================== --}}
    <section id="mobile-products" class="product-section">
        <div class="container my-5">

            {{-- ===================== --}}
            {{-- KATEGORI (Klik Gambar) --}}
            {{-- ===================== --}}
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
            <div class="swiper product-swiper">
                <div class="swiper-wrapper my-4">
                    @foreach ($produks as $p)
                        @php
                            $img = $p->gambar
                                ? asset('storage/' . $p->gambar)
                                : asset('user/assets/images/placeholder-product.jpg');
                        @endphp

                        <div class="swiper-slide">
                            <div class="product-card">

                                <div class="product-image">
                                    <img src="{{ $img }}" alt="{{ $p->nama }}">
                                </div>

                                <div class="card-body text-center">
                                    <h3 class="product-name text-uppercase">{{ $p->nama }}</h3>

                                    <span class="item-price">
                                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                                    </span>

                                    <div class="cart-button">
                                        @auth
                                            <form action="{{ route('keranjang.store') }}" method="POST"
                                                class="w-100 add-to-cart-form" data-success="Produk ditambahkan!">
                                                @csrf
                                                <input type="hidden" name="produk_id" value="{{ $p->id }}">
                                                <input type="hidden" name="jumlah" value="1">
                                                <button type="submit" class="btn-category-oval w-100">
                                                    Add to Cart
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn-category-oval w-100">
                                                Add to Cart
                                            </a>
                                        @endauth
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>

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
    {{-- ===================== --}}
    {{-- ABOUT --}}
    {{-- ===================== --}}
    <section class="about-section">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-md-6 mb-4 mb-md-0">
                    <h2>Tentang Waroeng Koe Ree Cake n Cookies</h2>
                    <p>
                        Pada tahun 2022, Waroeng Koe Ree Cake & Cookies memulai perjalanannya sebagai usaha kuliner rumahan
                        yang didirikan oleh Leni di Muara Bungo, Indonesia. Berlokasi di Jl. H. Al Sudin Pal 2, Bangko Lamo,
                        Pasir Putih, usaha ini lahir dari keinginan untuk menghadirkan aneka kue dan cookies dengan cita
                        rasa berkualitas yang dapat dinikmati oleh berbagai kalangan masyarakat.
                    </p>
                </div>

                <div class="col-md-6">
                    <div class="about-img-wrap">
                        <img src="{{ asset('user/assets/images/lokasi.jpeg') }}" class="about-image" alt="About">
                    </div>
                </div>


            </div>
        </div>
    </section>

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

        /* =====================
                                                       PRODUCT CARD
                                                    ===================== */
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

        /* =====================
                                                       BUTTON
                                                    ===================== */
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

        /* =====================
                                                       PROMO
                                                    ===================== */
        /* =====================
                                   PROMO
                                ===================== */
        .promo-section {
            background: #fff;
            padding: 70px 0;
            /* sebelumnya 100px, kebesaran */
        }

        .promo-row {
            gap: 18px;
            /* biar jarak rapi */
        }

        /* ini kuncinya: batasi ukuran gambar */
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

        /* teks */
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
    </style>
@endpush
