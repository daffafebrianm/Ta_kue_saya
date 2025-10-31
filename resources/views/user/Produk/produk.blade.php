@extends('user.layouts.main')
@section('content')

<style>
/* CSS untuk Produk Store */
.product-store-new {
    padding-top: 180px; /* jarak dari navbar */
    padding-bottom: 50px;
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

/* 🔽 Judul "Produk" dengan garis bawah */
.display-header-new {
    margin-top: 120px;
    margin-bottom: 40px;
    text-align: center;
    position: relative;
}

.display-header-new h2 {
    font-size: 2rem;
    font-weight: 600;
    color: #333;
    display: inline-block;
    position: relative;
    padding-bottom: 10px;
}

/* Garis bawah di bawah tulisan "Produk" */
.display-header-new h2::after {
    content: "";
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
    width: 100px; /* panjang garis */
    height: 3px;
    background-color: #e74c3c; /* warna merah senada tombol */
    border-radius: 5px;
}

/* 🔘 Tombol kategori berbentuk oval panjang */
.category-buttons {
    margin-top: 20px;
    margin-bottom: 50px;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 15px;
}

.btn-category-oval {
    border: 2px solid #b78b6f;
    background-color: transparent;
    color: #7a5230;
    border-radius: 50px; /* membuat oval */
    padding: 10px 35px; /* oval panjang */
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-category-oval:hover,
.btn-category-oval.active {
    background-color: #b78b6f;
    color: #fff;
    box-shadow: 0 4px 10px rgba(183, 139, 111, 0.3);
}

.swiper-pagination {
    bottom: -20px;
}

@media (max-width: 768px) {
    .display-header-new {
        margin-top: 100px;
    }

    .btn-category-oval {
        padding: 8px 25px;
        font-size: 0.9rem;
    }
}
</style>

<section id="product-store-new" class="product-store-new position-relative padding-large no-padding-top">
    <div class="container">
        <div class="row">
            <!-- 🔽 Judul Produk dengan garis bawah -->
            <div class="display-header-new pb-3">
                <h2 class="display-7 text-uppercase">Produk</h2>
            </div>

            <!-- Tombol kategori berbentuk oval -->
            <div class="category-buttons">
                <button class="btn-category-oval active">Cakes</button>
                <button class="btn-category-oval">Dry Cake</button>
                <button class="btn-category-oval">Hampers</button>
                <button class="btn-category-oval">Gifting</button>
            </div>

            <!-- Produk -->
            <div class="row products-container">
                @forelse ($produks as $p)
                    @php
                        $img = $p->gambar ? asset('storage/' . $p->gambar) : asset('user/assets/images/placeholder-product.jpg');
                    @endphp
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="product-card-new position-relative">
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
                        <p class="text-muted text-center">Belum ada produk.</p>
                    </div>
                @endforelse
            </div>

            <div class="swiper-pagination position-absolute text-center"></div>
        </div>
    </div>
</section>

@endsection
