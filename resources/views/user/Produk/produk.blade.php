@extends('user.layouts.main')
@section('content')
<section id="#" class="product-store position-relative padding-large no-padding-top">
    <div class="container">
        <div class="row">
            <div class="display-header d-flex justify-content-between pb-3">
                <h2 class="display-7 text-dark text-uppercase">Produk</h2>
            </div>
            <!-- Search bar moved to the top -->
            <div class="row mb-3">
                <div class="col-12">
                    <input type="text" class="form-control" placeholder="Search Product" aria-label="Search Product">
                </div>
            </div>
            <!-- Category Buttons -->
            <div class="d-flex mb-4">
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
                        <div class="product-card position-relative">
                            <div class="image-holder">
                                <img src="{{ $img }}" alt="{{ $p->nama }}" class="img-fluid" style="width:100%; height:260px; object-fit:cover;">
                            </div>
                            <div class="cart-concern position-absolute">
                                <div class="cart-button d-flex">
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
                            <div class="card-detail d-flex justify-content-between align-items-baseline pt-3">
                                <h3 class="card-title text-uppercase m-0" style="font-size:1rem;">
                                    <a href="{{ route('products.show', $p->id) }}">{{ $p->nama }}</a>
                                </h3>
                                <span class="item-price text-primary">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
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
