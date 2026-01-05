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
        grid-template-columns: repeat(4, 1fr); /* 4 produk per baris */
        gap: 30px;
        align-items: start;
    }

    @media (max-width: 1200px) {
        .products-grid {
            grid-template-columns: repeat(3, 1fr); /* 3 per baris */
        }
    }

    @media (max-width: 992px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr); /* 2 per baris */
        }
    }

    @media (max-width: 576px) {
        .products-grid {
            grid-template-columns: 1fr; /* 1 per baris di mobile */
        }
    }

    /* ====== CARD PRODUK ====== */
    .product-card {
        text-align: center;
        background: #fff;
        border-radius: 16px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .product-thumb {
        border-radius: 12px;
        overflow: hidden;
        background: #f3f4f6;
    }

    .product-thumb img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        transition: transform 0.3s;
    }

    .product-thumb img:hover {
        transform: scale(1.05);
    }

    .product-name {
        margin-top: 12px;
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        text-transform: capitalize;
    }

    .product-price {
        font-size: 16px;
        font-weight: 600;
        color: #7a5230;
        margin-bottom: 12px;
    }

    .btn-cart-oval {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 10px 0;
        border-radius: 999px;
        border: 1.5px solid #dfc8a7;
        color: #dfc8a7;
        font-weight: 700;
        text-transform: uppercase;
        transition: all 0.3s;
    }

    .btn-cart-oval:hover {
        background: #dfc8a7;
        color: #fff;
    }
</style>

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
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}">
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
                                <a href="{{ route('login') }}" class="btn-cart-oval" style="text-decoration:none;">ADD TO CART</a>
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

                fetch(action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message || 'Produk ditambahkan ke keranjang!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1800
                            });

                            const badge = document.querySelector('#cart-count');
                            if (badge && data.cart_count !== undefined) badge.textContent = data.cart_count;
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
