@extends('user.layouts.main')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
        $img = $product->gambar ? Storage::url($product->gambar) : 'https://via.placeholder.com/800x800?text=No+Image';
        $price = (float) $product->harga;
    @endphp

    <style>
        :root {
            --primary-color: #dfc8a7;
            --secondary-color: #f7f4f9;
            --text-dark: #1e293b;
            --text-light: #64748b;
        }

        .product-detail {
            padding: 60px 0;
            background: #fafafa;
        }

        .product-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08);
        }

        @media (max-width: 992px) {
            .product-container {
                grid-template-columns: 1fr;
                padding: 25px;
            }
        }

        .product-image {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }

        .product-image:hover img {
            transform: scale(1.04);
        }

        .product-info h1 {
            font-size: 30px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 26px;
            color: #00000 font-weight: 800;
            margin-bottom: 15px;
        }

        .product-desc {
            font-size: 15px;
            color: var(--text-light);
            line-height: 1.7;
            margin-bottom: 16px;
        }

        .product-stock {
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            background: var(--secondary-color);
            display: inline-block;
            padding: 6px 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .divider {
            border-bottom: 1px solid #e2e8f0;
            margin: 18px 0;
        }

        .qty-area {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .qty-box {
            display: flex;
            align-items: center;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            overflow: hidden;
        }

        .qty-box button {
            background: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 18px;
            cursor: pointer;
            color: #475569;
            transition: background 0.3s;
        }

        .qty-box button:hover {
            background: #f1f5f9;
        }

        .qty-box input {
            width: 50px;
            text-align: center;
            border: none;
            outline: none;
            font-weight: 700;
            font-size: 16px;
            color: #1e293b;
            background: transparent;
        }

        .subtotal strong {
            display: block;
            font-size: 22px;
            color: #0000 font-weight: 800;
        }

        .subtotal small {
            display: block;
            color: var(--text-light);
            font-size: 13px;
            margin-bottom: 2px;
        }

        .action-buttons {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            margin-top: 16px;
        }

        .btn-outline,
        .btn-primaryx {
            border-radius: 12px;
            padding: 14px 28px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-outline {
            background: #fff;
            color: #475569;
            border: 1px solid #cbd5e1;
            box-shadow: 0 4px 12px rgba(148, 163, 184, 0.2);
            transition: all 0.3s ease;
        }

        .btn-outline:hover,
        .btn-outline:focus,
        .btn-outline:active {
            background: #f1f5f9;
            color: #475569 !important;
            /* warna teks tidak berubah */
            border-color: #cbd5e1;
            transform: translateY(-2px);
            outline: none;
        }


        .btn-primaryx {
            background: var(--primary-color);
            color: #fff;
            border: none;
            box-shadow: 0 6px 16px rgba(223, 200, 167, 0.55);
            transition: all 0.3s ease;
        }

        .btn-primaryx:hover,
        .btn-primaryx:focus,
        .btn-primaryx:active {
            background: var(--primary-color);
            /* tetap sama */
            color: #fff !important;
            /* kunci warna teks agar tidak berubah */
            box-shadow: 0 10px 22px rgba(223, 200, 167, 0.7);
            transform: translateY(-2px);
            outline: none;
        }

        lateY(-2px);
        /* efek naik halus */
        }


        @media (max-width: 576px) {

            .btn-outline,
            .btn-primaryx {
                width: 100%;
                text-align: center;
            }
        }

        .share-btn {
            position: absolute;
            top: 14px;
            right: 14px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            transition: background .3s;
        }

        .share-btn:hover {
            background: #f1f5f9;
        }
    </style>
    <!-- Floating WhatsApp Button -->
    <a href="https://api.whatsapp.com/message/LSTUC4YSGLHVL1?autoload=1&app_absent=0&utm_source=ig" class="whatsapp-float"
        target="_blank" aria-label="Chat via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <section class="product-detail">
        <div class="container">
            <div class="product-container">
                {{-- Left: Image --}}
                <div class="product-image">
                    <img src="{{ $img }}" alt="{{ $product->nama }}">
                    <div class="share-btn" title="Salin Link" onclick="navigator.clipboard.writeText(window.location.href)">
                        ↗
                    </div>
                </div>

                {{-- Right: Info --}}
                <div class="product-info">
                    <h1>{{ strtoupper($product->nama) }}</h1>
                    <div class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                    <p class="product-desc">{{ $product->deskripsi }}</p>
                    <span class="product-stock">Stok: {{ $product->stok }}</span>

                    <div class="divider"></div>

                    <div class="qty-area">
                        <div>
                            <label class="fw-bold d-block mb-1">Jumlah</label>
                            <div class="qty-box">
                                <button id="qtyMinus">−</button>
                                <input id="qtyInput" type="text" value="1" readonly>
                                <button id="qtyPlus">+</button>
                            </div>
                        </div>
                        <div class="subtotal text-end">
                            <small>Subtotal</small>
                            <strong id="subtotalText">Rp {{ number_format($product->harga, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <div class="action-buttons">
                        @auth
                            <form action="{{ route('keranjang.store') }}" method="POST" class="add-to-cart-form"
                                data-success="Produk ditambahkan!">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $product->id }}">
                                <input type="hidden" name="jumlah" id="jumlahHidden" value="1">
                                <button type="submit" class="btn-outline">Tambah ke Keranjang</button>
                            </form>
                            <a id="buyNowBtn" href="{{ route('Checkout.index', ['produk_id' => $product->id, 'jumlah' => 1]) }}"
                                class="btn-primaryx"
                                style="text-decoration:none; display:inline-flex; align-items:center; justify-content:center;">
                                Beli Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-outline">Tambah ke Keranjang</a>
                            <a href="{{ route('login') }}" class="btn-primaryx">Beli Sekarang</a>
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
        const buyNowBtn = document.getElementById('buyNowBtn'); // ambil tombol beli sekarang

        const rupiah = n => 'Rp ' + new Intl.NumberFormat('id-ID').format(n);

        function sync() {
            const qty = parseInt(qtyInput.value || '1', 10);
            subtotalText.textContent = rupiah(price * qty);

            // sinkron ke input hidden untuk keranjang
            if (jumlahHidden) jumlahHidden.value = qty;

            // update URL tombol "Beli Sekarang"
            if (buyNowBtn) {
                const url = new URL(buyNowBtn.href);
                url.searchParams.set('jumlah', qty);
                buyNowBtn.href = url.toString();
            }
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
