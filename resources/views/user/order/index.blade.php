@extends('user.layouts.main')

@section('content')
    <style>
        body {
            background: #fff;
        }

        /* wrapper */
        .checkout-wrap {
            padding-top: 40px;
            padding-bottom: 60px;
        }

        /* judul kiri */
        .checkout-title {
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-size: 18px;
            margin-bottom: 18px;
        }

        .title-bar {
            width: 110px;
            height: 4px;
            background: #7a3e8a;
            border-radius: 999px;
            margin-top: 10px;
        }

        /* form control */
        .form-label {
            font-weight: 800;
            font-size: 14px;
            color: #111827;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select,
        textarea {
            border-radius: 10px !important;
            border: 1px solid #d0d5dd !important;
            padding: 12px 14px !important;
            font-size: 14px;
            box-shadow: none !important;
        }

        textarea {
            resize: vertical;
        }

        /* card kanan */
        .card-box {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #fff;
            padding: 18px 18px;
        }

        .card-box+.card-box {
            margin-top: 16px;
        }

        .card-title {
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-size: 14px;
            margin: 0 0 14px;
        }

        .card-title.purple {
            color: #7a3e8a;
            text-transform: none;
            letter-spacing: 0;
            font-size: 18px;
        }

        .card-title .title-bar {
            width: 95px;
            height: 3px;
            margin-top: 10px;
        }

        /* voucher */
        .voucher-empty {
            text-align: center;
            color: #667085;
            font-size: 14px;
            padding: 28px 0 18px;
        }

        /* summary */
        .summary-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .summary-list li {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
            color: #111827;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 14px;
            color: #111827;
        }

        .summary-row strong {
            font-weight: 900;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 14px;
            border-top: 2px solid #111827;
            margin-top: 10px;
            font-size: 16px;
            font-weight: 900;
        }

        .summary-total .amount {
            color: #7a3e8a;
        }

        /* proceed button */
        .btn-proceed {
            width: 100%;
            margin-top: 16px;
            padding: 14px 18px;
            border-radius: 10px;
            border: 0;
            background: #7a3e8a;
            color: #fff;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
            cursor: pointer;
        }

        /* shipping method UI */
        .ship-title {
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-top: 22px;
            margin-bottom: 14px;
        }

        .ship-options {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .ship-option {
            position: relative;
            flex: 0 0 210px;
        }

        .ship-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .ship-card {
            border-radius: 6px;
            background: #b08f5a;
            color: #fff;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            user-select: none;
        }

        .ship-dot {
            width: 14px;
            height: 14px;
            border-radius: 999px;
            border: 2px solid rgba(255, 255, 255, .9);
            display: inline-block;
            position: relative;
            flex: 0 0 auto;
        }

        .ship-option input:checked+label .ship-dot::after {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #fff;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .ship-text {
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-size: 14px;
        }

        @media (max-width: 992px) {
            .checkout-wrap {
                padding-top: 20px;
            }
        }
    </style>

    <div class="checkout-wrap">
        <div class="container">
            <div class="row g-4 my-5">

                {{-- LEFT: FORM CHECKOUT --}}
                <div class="col-lg-7">
                    <div class="checkout-title">
                        Detail Pemesanan
                        <div class="title-bar"></div>
                    </div>

                    {{-- Form (data tetap) --}}
                    <form id="checkoutForm" action="{{ route('Checkout.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror" placeholder="Nama lengkap"
                                    required value="{{ old('nama', Auth::user()->nama) }}">
                                @error('nama')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <input type="text" id="phone_number" name="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    placeholder="Nomor telepon" required
                                    value="{{ old('phone_number', Auth::user()->phone_number) }}">
                                @error('phone_number')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat Pengiriman</label>
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                    placeholder="Alamat pengiriman..." required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="note" class="form-label">Catatan</label>
                                <textarea id="note" name="note" class="form-control @error('note') is-invalid @enderror" rows="2"
                                    placeholder="Catatan tambahan (opsional)">{{ old('note') }}</textarea>
                            </div>
                        </div>

                        {{-- Shipping method UI (cuma desain) --}}
                        <div class="ship-title">Shipping Method</div>

                        <div class="ship-options">
                            <div class="ship-option">
                                <input type="radio" id="ship_delivery" name="shipping_method" value="delivered" checked>
                                <label class="ship-card" for="ship_delivery">
                                    <span class="ship-dot"></span>
                                    <span class="ship-text">Delivery</span>
                                </label>
                            </div>

                            <div class="ship-option">
                                <input type="radio" id="ship_pickup" name="shipping_method" value="picked up">
                                <label class="ship-card" for="ship_pickup">
                                    <span class="ship-dot"></span>
                                    <span class="ship-text">Pickup</span>
                                </label>
                            </div>
                        </div>
                        @error('shipping_method')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror


                        {{-- TOMBOL "Proses Pembayaran" DIHAPUS sesuai permintaan --}}
                    </form>
                </div>

                {{-- RIGHT: VOUCHERS + ORDER SUMMARY --}}
                <div class="col-lg-5">

                    {{-- ORDER SUMMARY --}}
                    <div class="card-box">
                        <div class="card-title">
                            ORDER SUMMARY
                            <div class="title-bar"></div>
                        </div>

                        <ul class="summary-list">
                            @foreach ($keranjangs as $keranjang)
                                <li>
                                    <span>{{ $keranjang->produk->nama }} ({{ $keranjang->jumlah }}x)</span>
                                    <strong>Rp
                                        {{ number_format($keranjang->produk->harga * $keranjang->jumlah, 0, ',', '.') }}</strong>
                                </li>
                            @endforeach
                        </ul>

                        <div class="summary-row">
                            <span>Sub Total</span>
                            <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>

                        <div class="summary-row" style="border-bottom:1px solid #e5e7eb; padding-bottom:14px;">
                            <span>Shipping</span>
                            <strong>Rp 0</strong>
                        </div>

                        <div class="summary-total">
                            <span>Total Pembayaran</span>
                            <span class="amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        {{-- Tombol ungu ini yang submit form checkout --}}
                        <button type="submit" form="checkoutForm" class="btn-proceed">
                            Proceed to Payment
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
