@extends('user.layouts.main')

@section('content')
    <style>
        body {
            background-color: #fdf8f2;
        }

        /* Styling untuk order summary */
        .order-summary {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
            margin-top: 15px;
        }

        .order-summary h5 {
            font-size: 1rem; /* Ukuran font lebih kecil */
            font-weight: 600;
            margin-bottom: 8px;
            color: #7a5230;
        }

        .order-summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 0.85rem; /* Ukuran font lebih kecil */
        }

        .order-summary ul li {
            padding: 6px 0;
            border-bottom:  solid black  ;
            font-size: 0.85rem; /* Ukuran font lebih kecil */
            color: black;
            display: flex;
            justify-content: space-between;
        }

        .order-summary .total {
            font-weight: bold;
            font-size: 1rem; /* Ukuran font lebih kecil */
            margin-top: 8px;
            color: white;
        }
        header.site-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #fff;
            z-index: 9999;
            padding: 10px 0;
            width: 100%;
        }

        /* Styling untuk menu navbar */
        nav.navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        nav.navbar .navbar-nav {
            display: flex;
            gap: 15px;
        }

        body {
            padding-top: 150px; /* Mengurangi jarak top */
        }

        /* Styling untuk tulisan di bawah tombol checkout */
    </style>

    <div class="container my-3 cart-container">
        <div class="row">
            <!-- Bagian Kiri (Form Checkout) -->
            <div class="col-md-8 checkout-left">
                <h1 class="cart-title">Checkout</h1>
                <form action="{{ route('Checkout.store') }}" method="POST">
                    @csrf

                    <!-- Section untuk Nama Lengkap dan Nomor Telepon -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="h8 form-label">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror" placeholder="Nama lengkap"
                                    required value="{{ old('nama', Auth::user()->nama) }}">
                                @error('nama')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number" class="h8 form-label">Nomor Telepon</label>
                                <input type="text" id="phone_number" name="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    placeholder="Nomor telepon" required
                                    value="{{ old('phone_number', Auth::user()->phone_number) }}">
                                @error('phone_number')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alamat" class="h8 form-label">Alamat Pengiriman</label>
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                    placeholder="Alamat pengiriman..." required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Metode Pengiriman -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipping_method" class="h8 form-label">Metode Pengiriman</label>
                                <select id="shipping_method" name="shipping_method"
                                    class="form-control @error('shipping_method') is-invalid @enderror" required>
                                    <option value="picked up">Diambil</option>
                                    <option value="delivered">Dikirim</option>
                                </select>
                                @error('shipping_method')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="note" class="h8 form-label">Catatan</label>
                                <textarea id="note" name="note" class="form-control @error('note') is-invalid @enderror" rows="2"
                                    placeholder="Catatan tambahan (opsional)">{{ old('note') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Checkout -->
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-lg btn-success px-5 mt-6 ">Proses Pembayaran</button>
                    </div>
                </form>
            </div>

            <!-- Bagian Kanan (Order Summary) -->
            <div class="col-md-4 checkout-right">
                <div class="order-summary">
                    <h5>Order Summary</h5>
                    <ul>
                        @foreach ($keranjangs as $keranjang)
                            <li>
                                <span>{{ $keranjang->produk->nama }} ({{ $keranjang->jumlah }}x)</span>
                                <span>Rp
                                    {{ number_format($keranjang->produk->harga * $keranjang->jumlah, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="total">
                        <p>Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                        <p><strong>Total: Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
