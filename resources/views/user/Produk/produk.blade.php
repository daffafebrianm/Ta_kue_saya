@extends('user.layouts.main')
@section('content')

<style>
/* CSS untuk Produk Store yang baru */
.product-store-new {
    padding-top: 30px;
    padding-bottom: 30px;
}

.product-card-new {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 30px;
}

.product-card-new:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.image-holder-new {
    position: relative;
    height: 280px;
    overflow: hidden;
    border-radius: 15px;
}

.product-image-new {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 15px;
}

.card-body-new {
    padding-top: 15px;
    padding-bottom: 15px;
}

.product-title-new {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
}

.item-price-new {
    font-size: 1.3rem;
    font-weight: 700;
    color: #e74c3c;
}

.cart-concern-new {
    bottom: 10px;
    left: 10px;
    right: 10px;
    display: none;
}

.product-card-new:hover .cart-concern-new {
    display: block;
}

.cart-button-new button {
    background-color: #e74c3c;
    color: white;
    font-weight: bold;
    padding: 12px;
    text-transform: uppercase;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.cart-button-new button:hover {
    background-color: #c0392b;
}

.category-buttons {
    margin-bottom: 20px;
}

.btn-outline-secondary {
    border-radius: 5px;
    padding: 8px 16px;
    font-size: 1rem;
    margin-right: 8px;
}

.display-header-new h2 {
    font-size: 2rem;
    font-weight: 600;
}

.swiper-pagination {
    bottom: -20px;
}

@media (max-width: 768px) {
    .product-card-new {
        margin-bottom: 30px;
    }
    .cart-concern-new {
        position: static;
        display: block;
        padding: 10px;
    }
}

</style>

<section id="product-store-new" class="product-store-new position-relative padding-large no-padding-top">
    <div class="container">
        <div class="row">
            <div class="display-header-new d-flex justify-content-between pb-3">
                <h2 class="display-7 text-dark text-uppercase">Produk</h2>
            </div>
            <!-- Search bar moved to the top -->
            <div class="row mb-3">
                <div class="col-12">
                    <input type="text" class="form-control" placeholder="Search Product" aria-label="Search Product">
                </div>
            </div>
            <!-- Category Buttons -->
            <div class="category-buttons d-flex mb-4">
                <button class="btn btn-outline-secondary mx-2">Cakes</button>
                <button class="btn btn-outline-secondary mx-2">Dry Cake</button>
                <button class="btn btn-outline-secondary mx-2">Hampers</button>
                <button class="btn btn-outline-secondary mx-2">Gifting</button>
            </div>

            <div class="row">
                @forelse ($produks as $p)
                    @php
                        $img = $p->gambar ? asset('storage/' . $p->gambar) : asset('user/assets/images/placeholder-product.jpg');
                    @endphp
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="product-card-new position-relative">
                            <!-- Gambar menjadi link ke halaman detail produk -->
                            <a href="{{ route('detai.index', $p->id) }}">
                                <div class="image-holder-new">
                                    <img src="{{ $img }}" alt="{{ $p->nama }}" class="img-fluid product-image-new">
                                </div>
                            </a>
                            <div class="card-body-new text-center">
                                <h3 class="product-title-new text-uppercase">{{ $p->nama }}</h3>
                                <span class="item-price-new">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="cart-concern-new position-absolute">
                                <div class="cart-button-new d-flex">
                                    @auth
                                        <form action="{{ route('keranjang.store') }}" method="POST" class="w-100 add-to-cart-form" data-success="Produk ditambahkan!">
                                            @csrf
                                            <input type="hidden" name="produk_id" value="{{ $p->id }}">
                                            <input type="hidden" name="jumlah" value="1">
                                            <button type="submit" class="btn btn-medium btn-black w-100">Add to Cart</button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-medium btn-black w-100">Add to Cart</a>
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
</section>

@endsection
