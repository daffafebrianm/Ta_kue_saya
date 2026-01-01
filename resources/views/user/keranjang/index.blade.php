@extends('user.layouts.main')

@section('content')
    <style>
        body {
            background-color: #fdf8f2;
        }

        /* 🔽 Container utama diturunkan */
        .cart-page {
            padding: 160px 0 60px 0;
        }

        /* 🔽 Judul "Cart" rata kiri + garis bawah */
        .cart-title {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 30px;
            color: #333;
            text-align: left;
            margin-left: 10px;
            position: relative;
            display: inline-block;
            width: 100%;
            /* Menyelaraskan lebar dengan elemen lainnya */
        }

        /* Garis bawah ungu di bawah Cart */
        .cart-title::after {
            content: "";
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 70px;
            height: 4px;
            background-color: #7a3eb1;
            border-radius: 3px;
        }

        /* Card item produk */
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            flex: 1;
            /* Agar kolom cart dan order summary memiliki lebar yang seimbang */
        }

        /* Gambar produk */
        .cart-item img {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
        }

        /* Info produk */
        .cart-info {
            flex: 1;
            margin-left: 20px;
        }

        .cart-info h5 {
            font-weight: 700;
            color: #333;
            margin-bottom: 4px;
        }

        .cart-info p {
            color: #777;
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        .cart-info .price {
            font-weight: 700;
            color: #000;
            font-size: 1.1rem;
        }

        /* Quantity control */
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-control button {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #333;
            background: none;
            font-weight: bold;
            line-height: 1;
            cursor: pointer;
        }

        .quantity-control input {
            width: 40px;
            text-align: center;
            border: none;
            background: transparent;
            font-weight: 600;
        }

        /* Order Summary */
        .summary-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            flex: 1;
            /* Membuat Order Summary menggunakan lebar yang seimbang */
        }

        .summary-card h5 {
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
        }

        .summary-card h5::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: #7a3eb1;
            margin-top: 6px;
            border-radius: 2px;
        }

        /* Tombol checkout */
        .btn-checkout {
            background: #7a3eb1;
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 10px;
            padding: 15px;
            transition: background 0.3s ease;
            width: 100%;
            border: none;
        }

        .btn-checkout:hover {
            background: #692e97;
        }
    </style>

    <div class="container cart-page">
        <div class="row">
            <!-- CART ITEMS -->
            <div class="col-md-7">
                <h4 class="cart-title">Cart</h4>

                @forelse($keranjangs as $keranjang)
                    <div class="cart-item">
                        <img src="{{ $keranjang->produk->gambar ? Storage::url($keranjang->produk->gambar) : asset('default-image.jpg') }}"
                            alt="Produk">

                        <div class="cart-info">
                            <h5>{{ $keranjang->produk->nama }}</h5>
                            <p>{{ $keranjang->produk->deskripsi ?? 'Deskripsi produk' }}</p>
                            <span class="price">Rp {{ number_format($keranjang->produk->harga, 0, ',', '.') }}</span>
                        </div>

                        <form action="{{ route('keranjang.update', $keranjang->id) }}" method="post"
                            class="quantity-control" id="form-keranjang-{{ $keranjang->id }}">
                            @csrf
                            @method('PATCH')
                            <button type="button" id="btn-minus-{{ $keranjang->id }}">-</button>
                            <input type="text" name="jumlah" id="jumlah-{{ $keranjang->id }}"
                                value="{{ $keranjang->jumlah }}" readonly>
                            <button type="button" id="btn-plus-{{ $keranjang->id }}">+</button>
                        </form>

                        <form action="{{ route('keranjang.destroy', $keranjang->id) }}" method="post"
                            id="form-hapus-{{ $keranjang->id }}">
                            @csrf
                            @method('DELETE')
                        </form>

                        <script>
                            const minusBtn{{ $keranjang->id }} = document.getElementById('btn-minus-{{ $keranjang->id }}');
                            const plusBtn{{ $keranjang->id }} = document.getElementById('btn-plus-{{ $keranjang->id }}');
                            const jumlahInput{{ $keranjang->id }} = document.getElementById('jumlah-{{ $keranjang->id }}');

                            minusBtn{{ $keranjang->id }}.addEventListener('click', function() {
                                let val = parseInt(jumlahInput{{ $keranjang->id }}.value);
                                if (val > 1) {
                                    jumlahInput{{ $keranjang->id }}.value = val - 1;
                                    document.getElementById('form-keranjang-{{ $keranjang->id }}').submit();
                                } else {
                                    if (confirm('Hapus produk ini dari keranjang?')) {
                                        document.getElementById('form-hapus-{{ $keranjang->id }}').submit();
                                    }
                                }
                            });

                            plusBtn{{ $keranjang->id }}.addEventListener('click', function() {
                                let val = parseInt(jumlahInput{{ $keranjang->id }}.value);
                                if (val < {{ $keranjang->produk->stok }}) {
                                    jumlahInput{{ $keranjang->id }}.value = val + 1;
                                    document.getElementById('form-keranjang-{{ $keranjang->id }}').submit();
                                }
                            });
                        </script>
                    </div>
                @empty
                    <p class="text-muted">Keranjang kamu masih kosong.</p>
                @endforelse
            </div>

            <!-- ORDER SUMMARY -->
            <div class="col-md-5">
                <div class="summary-card">
                    <h5>Order Summary</h5>
                    <hr>
                    @php $total = 0; @endphp
                    @foreach ($keranjangs as $keranjang)
                        @php
                            $subtotal = $keranjang->produk->harga * $keranjang->jumlah;
                            $total += $subtotal;
                        @endphp
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $keranjang->produk->nama }} ({{ $keranjang->jumlah }}x)</span>
                            <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Sub Total</strong>
                        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>

                    <form action="{{ route('Checkout.index') }}" method="get">
                        <button type="submit" class="btn-checkout">Proceed to Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    @include('user.partials.footer')
@endsection
