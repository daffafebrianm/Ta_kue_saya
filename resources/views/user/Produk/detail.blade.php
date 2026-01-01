@extends('user.layouts.main')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;

        $img = $product->gambar ? Storage::url($product->gambar) : 'https://via.placeholder.com/800x800?text=No+Image';
        $price = (float) $product->harga;
    @endphp

    <style>
        .pd-wrap {
            padding: 55px 0;
        }

        .pd-grid {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 32px;
            align-items: start;
        }

        @media (max-width: 992px) {
            .pd-grid {
                grid-template-columns: 1fr;
                gap: 22px;
            }

            .pd-wrap {
                padding: 28px 0;
            }
        }

        .pd-main-img {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 26px rgba(16, 24, 40, .10);
            max-height: 430px;
        }

        .pd-main-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .pd-title {
            font-size: 26px;
            letter-spacing: .10em;
            font-weight: 800;
            margin: 0 0 8px;
        }

        .pd-price {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 14px;
        }

        .pd-desc {
            font-size: 14px;
            color: #475467;
            line-height: 1.65;
            margin: 0 0 10px;
        }

        .pd-stock {
            font-size: 14px;
            font-weight: 700;
            margin: 8px 0 14px;
        }

        .pd-divider {
            height: 1px;
            background: #EAECF0;
            margin: 14px 0 16px;
        }

        .pd-label {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .pd-qty {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 4px;
        }

        .pd-qty button {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #D0D5DD;
            background: #fff;
            font-size: 18px;
            line-height: 1;
        }

        .pd-qty input {
            width: 46px;
            text-align: center;
            border: 0;
            outline: 0;
            font-weight: 700;
            font-size: 16px;
            background: transparent;
        }

        .pd-subtotal {
            text-align: right;
        }

        .pd-subtotal small {
            font-size: 12px;
            color: #667085;
            display: block;
            margin-bottom: 2px;
        }

        .pd-subtotal strong {
            font-size: 20px;
            color: #7a3e8a;
        }

        .pd-toprow {
            display: flex;
            align-items: start;
            justify-content: space-between;
            gap: 12px;
        }

        .pd-share {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 1px solid #EAECF0;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
        }

        /* ====== ACTIONS: dibuat rapi seperti gambar 2 ====== */
        .pd-actions {
            display: flex;
            justify-content: flex-start;
            /* bisa center kalau mau */
            gap: 18px;
            margin-top: 14px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* Form jangan w-100 */
        .pd-actions form {
            flex: 0 0 auto;
        }

        .btn-outline {
            padding: 14px 26px;
            border-radius: 12px;
            border: 1px solid #D0D5DD;
            background: #fff;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: .08em;
            min-width: 210px;
            /* biar sama kayak gambar 2 */
            box-shadow: 0 10px 22px rgba(16, 24, 40, .08);
        }

        .btn-primaryx {
            padding: 14px 26px;
            border-radius: 12px;
            border: 0;
            background: #b58db6;
            color: #fff;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: .08em;
            min-width: 210px;
            /* biar sama kayak gambar 2 */
            box-shadow: 0 10px 22px rgba(181, 141, 182, .28);
        }

        /* Mobile: tombol jadi full biar enak dipencet */
        @media (max-width: 576px) {
            .pd-main-img {
                max-height: 320px;
            }

            .pd-title {
                font-size: 22px;
            }

            .pd-price {
                font-size: 19px;
            }

            .pd-actions {
                gap: 12px;
            }

            .btn-outline,
            .btn-primaryx {
                min-width: 100%;
                width: 100%;
            }
        }
    </style>

    <section class="pd-wrap">
        <div class="container">
            <div class="pd-grid my-5">

                {{-- LEFT: Gambar besar --}}
                <div class="pd-main-img">
                    <img src="{{ $img }}" alt="{{ $product->nama }}">
                </div>

                {{-- RIGHT: Info --}}
                <div>
                    <div class="pd-toprow">
                        <div>
                            <h1 class="pd-title">{{ strtoupper($product->nama) }}</h1>
                            <p class="pd-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        </div>

                        <button class="pd-share" type="button" title="Share"
                            onclick="navigator.clipboard.writeText(window.location.href)">
                            ↗
                        </button>
                    </div>

                    <p class="pd-desc">{{ $product->deskripsi }}</p>

                    <div class="pd-stock">
                        Only {{ $product->stok }} left in stock
                    </div>

                    <div class="pd-divider"></div>

                    {{-- Quantity + Subtotal --}}
                    <div class="row align-items-end g-3">
                        <div class="col-md-7">
                            <div class="pd-label">Quantity</div>
                            <div class="pd-qty">
                                <button type="button" id="qtyMinus">−</button>
                                <input id="qtyInput" type="text" value="1" readonly>
                                <button type="button" id="qtyPlus">+</button>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="pd-subtotal">
                                <small>Subtotal</small>
                                <strong id="subtotalText">Rp {{ number_format($product->harga, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="pd-divider"></div>

                    {{-- Actions --}}
                    <div class="pd-actions">
                        @auth
                            {{-- ADD TO CART --}}
                            <form action="{{ route('keranjang.store') }}" method="POST" class="add-to-cart-form"
                                data-success="Produk ditambahkan!">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $product->id }}">
                                <input type="hidden" name="jumlah" id="jumlahHidden" value="1">
                                <button type="submit" class="btn-outline">ADD TO CART</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn-outline text-center"
                                style="text-decoration:none; display:inline-flex; align-items:center; justify-content:center;">
                                ADD TO CART
                            </a>
                            <a href="{{ route('login') }}" class="btn-primaryx text-center"
                                style="text-decoration:none; display:inline-flex; align-items:center; justify-content:center;">
                                BUY NOW
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        const price = {{ (int) $price }};
        const qtyInput = document.getElementById('qtyInput');
        const subtotalText = document.getElementById('subtotalText');
        const qtyMinus = document.getElementById('qtyMinus');
        const qtyPlus = document.getElementById('qtyPlus');
        const jumlahHidden = document.getElementById('jumlahHidden');
        const jumlahHidden2 = document.getElementById('jumlahHidden2');

        function rupiah(n) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
        }

        function sync() {
            const qty = parseInt(qtyInput.value || '1', 10);
            subtotalText.textContent = rupiah(price * qty);
            if (jumlahHidden) jumlahHidden.value = qty;
            if (jumlahHidden2) jumlahHidden2.value = qty;
        }

        qtyMinus.addEventListener('click', () => {
            let q = parseInt(qtyInput.value, 10);
            qtyInput.value = Math.max(1, q - 1);
            sync();
        });

        qtyPlus.addEventListener('click', () => {
            let q = parseInt(qtyInput.value, 10);
            qtyInput.value = Math.min(999, q + 1);
            sync();
        });

        sync();
    </script>
@endsection

@section('footer')
    @include('user.partials.footer')
@endsection
