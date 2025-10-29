@extends('user.layouts.main')

@section('content')
<style>
   .product-detail {
    padding: 100px 0; /* Menambahkan jarak atas dan bawah yang lebih besar */
}

.product-image-detail {
    width: 100%;
    max-height: 500px;
    object-fit: contain;
    border-radius: 15px;
    margin-bottom: 30px; /* Memberikan jarak bawah pada gambar produk */
}

.product-info {
    padding-left: 30px;
    padding-top: 20px; /* Memberikan jarak atas pada informasi produk */
}

.product-title-detail {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #333;
}

.item-price-detail {
    font-size: 1.5rem;
    font-weight: 700;
    color: #e74c3c;
}

.product-description {
    margin-top: 20px;
    font-size: 1rem;
    color: #666;
}

.product-weight {
    margin-top: 10px;
    font-size: 1rem;
    color: #333;
}

.product-stock {
    margin-top: 10px;
    font-size: 1rem;
    color: #27ae60;
}

.cart-button-detail {
    margin-top: 30px;
}

.btn-detail {
    background-color: #e74c3c;
    color: white;
    padding: 12px 24px;
    font-weight: bold;
    text-transform: uppercase;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn-detail:hover {
    background-color: #c0392b;
}

@media (max-width: 768px) {
    .product-info {
        padding-left: 0;
        padding-top: 10px; /* Menambahkan padding atas untuk tampilan kecil */
    }

    .product-image-detail {
        max-height: 400px;
    }

    .btn-detail {
        width: 100%;
    }
}

</style>

<section class="product-detail">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <!-- Gambar produk -->
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="product-image-detail">
            </div>
            <div class="col-md-6 product-info">
                <!-- Nama produk -->
                <h2 class="product-title-detail">{{ $product->nama }}</h2>

                <!-- Harga produk -->
                <span class="item-price-detail">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>

                <!-- Deskripsi produk -->
                <p class="product-description">
                    <strong>Deskripsi:</strong><br>
                    {{ $product->deskripsi }}
                </p>

                <!-- Berat produk -->
                <p class="product-weight">
                    <strong>Berat:</strong> {{ $product->berat }} kg
                </p>

                <!-- Stok produk -->
                <p class="product-stock">
                    <strong>Stok Tersedia:</strong> {{ $product->stok }} unit
                </p>

                <!-- Tombol "Add to Cart" -->
                <div class="cart-button-detail">
                    @auth
                        <form action="{{ route('keranjang.store') }}" method="POST" class="w-100 add-to-cart-form">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $product->id }}">
                            <input type="hidden" name="jumlah" value="1">
                            <button type="submit" class="btn btn-detail w-100">Add to Cart</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-detail w-100">Add to Cart</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
