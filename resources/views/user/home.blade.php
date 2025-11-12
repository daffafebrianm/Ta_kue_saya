@extends('user.layouts.main')

@section('title', 'Home')

@section('billboard')
    @include('user.partials.billboard')
@endsection

@section('products')
    <section id="mobile-products" class="product-store position-relative padding-large no-padding-top">
        <div class="container">
            <div class="row">
                <div class="display-header d-flex justify-content-between pb-3">
                    <h2 class="display-7 text-dark text-uppercase mt-5">Produk</h2>
                    <div class="btn-right">
                        <a href="{{ route('products.index') }}" class="btn btn-medium btn-normal text-uppercase">Shop</a>
                    </div>
                </div>

                <div class="swiper product-swiper">
                    <div class="swiper-wrapper">
                        @forelse ($produks as $p)
                            @php
                                $img = $p->gambar
                                    ? asset('storage/' . $p->gambar)
                                    : asset('user/assets/images/placeholder-product.jpg');
                            @endphp
                            <div class="swiper-slide">
                                <div class="product-card position-relative">
                                    <!-- Gambar produk -->
                                    <div class="image-holder">
                                        <img src="{{ $img }}" alt="{{ $p->nama }}" class="img-fluid"
                                            style="width:100%;height:260px;object-fit:cover;">
                                    </div>
                                    <!-- Detail produk -->
                                    <div class="card-body text-center">
                                        <h3 class="product-name text-uppercase">{{ $p->nama }}</h3>
                                        <span class="item-price text-primary">Rp
                                            {{ number_format($p->harga, 0, ',', '.') }}</span>
                                        <!-- Tombol "Add to Cart" -->
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
                                                <a href="{{ route('login') }}" class="btn-category-oval w-100">Add to Cart</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <p class="text-muted">Belum ada produk.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-pagination position-absolute text-center"></div>
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
        /* Styling untuk tombol Add to Cart berbentuk oval */
        .cart-button {
            margin-top: 15px;
            /* Menambahkan jarak antara harga dan tombol */
            display: flex;
            justify-content: center;
            /* Menjaga tombol tetap berada di tengah */
        }

        .cart-button button {
            background-color: transparent;
            color: #7a5230;
            /* Warna teks */
            border: 2px solid #b78b6f;
            /* Border warna senada dengan desain */
            border-radius: 50px;
            /* Membuat tombol berbentuk oval */
            padding: 10px 35px;
            /* Membuat tombol lebih panjang */
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            width: auto;
            /* Membuat lebar tombol menyesuaikan */
        }

        .cart-button button:hover,
        .cart-button button:active {
            background-color: #b78b6f;
            /* Warna latar belakang saat hover */
            color: #fff;
            /* Mengubah warna teks saat hover */
            box-shadow: 0 4px 10px rgba(183, 139, 111, 0.3);
            /* Efek bayangan saat hover */
        }

        /* Styling untuk kondisi ketika produk belum login */
        .cart-button a {
            background-color: transparent;
            color: #7a5230;
            border: 2px solid #b78b6f;
            border-radius: 50px;
            padding: 10px 35px;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            width: auto;
        }

        .cart-button a:hover,
        .cart-button a:active {
            background-color: #b78b6f;
            color: #fff;
            box-shadow: 0 4px 10px rgba(183, 139, 111, 0.3);
        }

        /* Menetapkan background color halaman */
        body {
            background-color: #FFF6EA;
            /* Warna latar belakang sesuai dengan yang Anda inginkan */
        }

        /* Anda juga bisa menambahkan style lain untuk elemen tertentu */
        #header {
            background-color: #FFF6EA;
            /* Menambahkan background pada header jika diperlukan */
        }

        /* Mengubah warna latar belakang header menjadi coklat */
        #header {
            background-color: #7a5230;
            /* Ganti dengan warna coklat yang diinginkan */
        }
    </style>
@endpush
