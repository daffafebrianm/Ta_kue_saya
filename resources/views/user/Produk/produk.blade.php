@extends('user.layouts.main')
@section('content')
    <style>
        /* ====== CATEGORY BUTTONS ====== */
        .category-buttons {
            margin-top: 120px;
            margin-bottom: 30px;
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

   /* ====== GRID PRODUK ====== */
.product-store-new {
    padding-top: 90px;
    padding-bottom: 50px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px; /* ⬅️ lebih lega seperti di gambar */
}

@media (max-width: 1200px) {
    .products-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 992px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .products-grid {
        grid-template-columns: 1fr;
    }
}

/* ====== CARD ====== */
.product-card {
    text-align: center;
    background: transparent; /* ⬅️ card terlihat ringan */
    padding: 0;
}

/* ====== IMAGE ====== */
.product-thumb {
    background: #f5f5f5;
    border-radius: 14px;
    height: 230px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: 14px;
}

.product-thumb img {
    max-width: 90%;
    max-height: 90%;
    width: auto;
    height: auto;
    object-fit: contain; /* ⬅️ gambar utuh */
    transition: transform 0.3s ease;
}

.product-card:hover .product-thumb img {
    transform: scale(1.06);
}

/* ====== TEXT ====== */
.product-name {
    font-size: 15px;
    font-weight: 600;
    color: #5b3a1e;
    margin-bottom: 4px;
    line-height: 1.3;
}

.product-price {
    font-size: 14px;
    font-weight: 500;
    color: #8b8b8b;
    margin-bottom: 14px;
}

/* ====== BUTTON ====== */
.product-action {
    padding: 0 10px;
}

.btn-cart-oval {
    width: 100%;
    padding: 9px 0;
    border-radius: 999px;
    border: 1px solid #d8c3a5;
    background: transparent;
    color: #5b3a1e;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.25s ease;
    text-decoration: none;
}

.btn-cart-oval:hover {
    background: #5b3a1e;
    color: #ffffff;
}

    </style>

    <!-- Floating WhatsApp Button -->
    <a href="https://api.whatsapp.com/message/LSTUC4YSGLHVL1?autoload=1&app_absent=0&utm_source=ig" class="whatsapp-float"
        target="_blank" aria-label="Chat via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <section id="product-store-new" class="product-store-new position-relative padding-large no-padding-top">
        <div class="container">
            <div class="row">
                {{-- Tombol Kategori --}}
                <div class="category-buttons mb-5">
                    @foreach ($categories as $categoryName => $label)
                        <button class="btn-category-oval {{ $selectedCategory == $categoryName ? 'active' : '' }}"
                            data-category="{{ $categoryName }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                {{-- Produk Grid --}}
                <div class="products-grid">
                    @foreach ($produks as $produk)
                        <div class="product-card">
                            <div class="product-thumb">
                                <a href="{{ route('detail.index', $produk->id) }}">
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}">
                                </a>
                            </div>

                            <div class="product-name">{{ $produk->nama }}</div>
                            <div class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                            <div class="product-action">
                                @auth
                                    <form action="{{ route('keranjang.store') }}" method="POST" class="add-to-cart-form">
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

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $produks->links() }}
                </div>
            </div>
        </div>
    </section>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // Tombol kategori
                document.querySelectorAll('.btn-category-oval').forEach(button => {
                    button.addEventListener('click', function() {
                        const category = this.getAttribute('data-category');
                        const url = new URL(window.location.href);
                        if (category === "") url.searchParams.delete('category');
                        else url.searchParams.set('category', category);
                        window.location.href = url.toString();
                    });
                });

                // Add to cart AJAX
                document.querySelectorAll('.add-to-cart-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        const action = this.getAttribute('action');
                        const badge = document.querySelector('#cart-count'); // badge di header

                        fetch(action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.ok) {
                                    // Tampilkan notifikasi sekali
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: data.message ||
                                            'Produk ditambahkan ke keranjang!',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 1800
                                    });

                                    // Update badge hanya jika ada produk di keranjang
                                    // Update badge berdasarkan jumlah produk unik
                                    if (badge) {
                                        if (data.cart_total_products && data.cart_total_products >
                                            0) {
                                            badge.textContent = data
                                                .cart_total_products; // jumlah produk unik
                                            badge.style.display = 'inline-block';
                                        } else {
                                            badge.style.display = 'none'; // sembunyikan jika kosong
                                        }
                                    }


                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: data.message || 'Terjadi kesalahan!',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 1800
                                    });
                                }
                            })
                            .catch(err => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan, coba lagi!',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 1800
                                });
                            });
                    });
                });

                // Session flash
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1800
                    });
                @endif

                @if (session('deleted'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: '{{ session('deleted') }}',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1800
                    });
                @endif

                @if ($errors->any())
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: `<ul style="text-align:left; padding-left:1rem;">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>`,
                        confirmButtonColor: '#d33'
                    });
                @endif

            });
        </script>
    @endpush
@endsection

@section('footer')
    @include('user.partials.footer')
@endsection
