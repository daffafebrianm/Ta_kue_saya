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
                    <h2 class="display-7 text-dark text-uppercase">Produk</h2>
                    <div class="btn-right">
                        <a href="{{ route('produk.index') }}" class="btn btn-medium btn-normal text-uppercase">Go to Shop</a>
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
                                    <div class="image-holder">
                                        <img src="{{ $img }}" alt="{{ $p->nama }}" class="img-fluid"
                                            style="width:100%;height:260px;object-fit:cover;">
                                    </div>
                                    <div class="cart-concern position-absolute">
                                        <div class="cart-button d-flex">
                                            @auth
                                                <form action="{{ route('keranjang.store') }}" method="POST"
                                                    class="w-100 add-to-cart-form" data-success="Produk ditambahkan!">
                                                    @csrf
                                                    <input type="hidden" name="produk_id" value="{{ $p->id }}">
                                                    <input type="hidden" name="jumlah" value="1">
                                                    <button type="submit" class="btn btn-medium btn-black w-100">
                                                        Add to Cart
                                                        <svg class="cart-outline">
                                                            <use xlink:href="#cart-outline"></use>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-medium btn-black w-100">Add to
                                                    Cart</a>
                                            @endauth
                                        </div>
                                    </div>

                                    <div class="card-detail d-flex justify-content-between align-items-baseline pt-3">
                                        <h3 class="card-title text-uppercase m-0" style="font-size:1rem;">
                                            <a href="{{ route('detai.index', $p->id) }}">{{ $p->nama }}</a>
                                        </h3>
                                        <span class="item-price text-primary">Rp
                                            {{ number_format($p->harga, 0, ',', '.') }}</span>
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


