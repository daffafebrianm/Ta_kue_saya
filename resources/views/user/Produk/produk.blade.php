@extends('user.layouts.main')
@section('content')
    <style>
        /* ====== CATEGORY BUTTONS ====== */
        .category-buttons {
            margin-top: 120px;
            /* Menambah jarak atas */
            margin-bottom: 10px;
            /* Menambah jarak bawah */
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }


        .btn-category-oval {
            border: 2px solid #b78b6f;
            background: transparent;
            color: #7a5230;
            border-radius: 999px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 500;
            transition: .25s;
            cursor: pointer;
        }

        .btn-category-oval:hover,
        .btn-category-oval.active {
            background: #b78b6f;
            color: #fff;
            box-shadow: 0 4px 10px rgba(183, 139, 111, .25);
        }

        /* ====== GRID PRODUK: 3 kolom ====== */
        .product-store-new {
            padding-top: 90px;
            padding-bottom: 50px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 46px;
            align-items: start;
        }

        @media (max-width: 992px) {
            .products-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 28px;
            }
        }

        @media (max-width: 576px) {
            .products-grid {
                grid-template-columns: 1fr;
                gap: 22px;
            }
        }

        /* ====== CARD STYLE ====== */
        .product-card-clean {
            text-align: center;
        }

        .product-thumb {
            border-radius: 16px;
            overflow: hidden;
            background: #f3f4f6;
        }

        .product-thumb img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            display: block;
        }

        @media (max-width: 576px) {
            .product-thumb img {
                height: 220px;
            }
        }

        .product-name {
            margin-top: 16px;
            margin-bottom: 6px;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #111827;
        }

        .product-price {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 14px;
        }

        /* ====== BUTTON STYLE ====== */
        .btn-cart-oval {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 190px;
            padding: 12px 22px;
            border-radius: 999px;
            border: 1.8px solid #b58db6;
            color: #b58db6;
            background: transparent;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            transition: .2s;
        }

        .btn-cart-oval:hover {
            background: #b58db6;
            color: #fff;
        }

        .product-category {
            font-size: 14px;
            /* Ukuran font untuk kategori */
            font-weight: 600;
            /* Membuat teks kategori lebih tebal */
            color: #7a5230;
            /* Warna teks kategori */
            background-color: #f3f4f6;
            /* Latar belakang kategori yang terang */
            padding: 8px 12px;
            /* Memberikan padding di dalam kategori */
            border-radius: 8px;
            /* Sudut yang melengkung pada kategori */
            margin-top: 10px;
            /* Memberikan jarak atas pada kategori */
            text-transform: capitalize;
            /* Mengubah teks kategori menjadi huruf besar di awal kata */
            display: inline-block;
            /* Menampilkan kategori dalam satu baris */
        }
    </style>
    <section id="product-store-new" class="product-store-new position-relative padding-large no-padding-top">
        <div class="container">
            <div class="row">
                {{-- Tombol Kategori --}}
                <div class="category-buttons mb-5 ">
                    <button class="btn-category-oval {{ !$category ? 'active' : '' }}" data-category="">Semua</button>
                    <button class="btn-category-oval {{ $category == '6' ? 'active' : '' }}"
                        data-category="6">Cookies</button>
                    <button class="btn-category-oval {{ $category == '7' ? 'active' : '' }}" data-category="7">Cakes</button>
                    <button class="btn-category-oval {{ $category == '8' ? 'active' : '' }}" data-category="8">Dry
                        Cake</button>
                </div>

                {{-- Produk Grid --}}
                <div class="products-grid">
                    @foreach ($produks as $produk)
                        <div class="product-card">
                            <div class="product-thumb">
                                <!-- Menampilkan gambar produk -->
                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}">
                            </div>
                            <div class="product-name">
                                <!-- Menampilkan nama produk -->
                                {{ $produk->nama }}
                            </div>
                            <div class="product-price">
                                <!-- Menampilkan harga produk -->
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </div>
                            <div class="product-action">
                                <!-- Menambahkan tombol untuk menambahkan produk ke keranjang -->
                                @auth
                                    <form action="{{ route('keranjang.store') }}" method="POST" class="add-to-cart-form"
                                        data-success="Produk ditambahkan!">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                        <input type="hidden" name="jumlah" value="1">
                                        <button type="submit" class="btn-cart-oval">ADD TO CART</button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn-cart-oval" style="text-decoration:none;">ADD TO
                                        CART</a>
                                @endauth
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('.btn-category-oval').forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                const url = new URL(window.location.href);
                if (category === "") url.searchParams.delete('category');
                else url.searchParams.set('category', category);
                window.location.href = url.toString();
            });
        });
    </script>
@endsection

@section('footer')
    @include('user.partials.footer')
@endsection
