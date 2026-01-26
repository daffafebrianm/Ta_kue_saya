    @extends('user.layouts.main')

    @section('content')
        <style>
            .timeline-step {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .timeline-icon {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            a.text-secondary:hover {
                color: #0d6efd !important;
                transform: translateX(-3px);
            }
        </style>
        <div class="container-fluid bg-primary hero-header py-4 mb-5"></div>
        <div class="container my-4">

            {{-- HEADER --}}
            <div class="mb-4">
                <a href="{{ route('Riwayat.index') }}"
                    class="d-inline-flex align-items-center gap-2 text-decoration-none text-secondary fw-semibold mb-3"
                    style="transition: all 0.2s ease;">
                    <i class="bi bi-arrow-left-circle-fill text-primary" style="font-size: 1.1rem;"></i>
                    <span>Kembali ke Riwayat Pesanan</span>
                </a>
                <h3 class="fw-bold mt-2">
                    Detail Pesanan #{{ $order->order_code }}
                </h3>
                <small class="text-muted">
                    {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}
                </small>
            </div>

            {{-- STATUS --}}
            {{-- STATUS --}}
            @php
                // Status utama: payment dan shipping
                if ($order->payment_status === 'pending') {
                    $status = ['secondary', 'Menunggu Pembayaran', 'hourglass'];
                } elseif ($order->shipping_status === 'cancelled') {
                    $status = ['danger', 'Pesanan Dibatalkan', 'x-circle'];
                } else {
                    $status = match ($order->shipping_status) {
                        'pending' => ['secondary', 'Menunggu Diproses', 'hourglass'],
                        'processing' => ['warning', 'Sedang Diproses', 'gear'],
                        'shipped' => ['primary', 'Dalam Pengiriman', 'truck'],
                        'completed' => ['success', 'Pesanan Selesai', 'check-circle'],
                        default => ['secondary', 'Menunggu Konfirmasi', 'hourglass'],
                    };
                }
            @endphp

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="timeline-icon bg-{{ $status[0] }} bg-opacity-25 text-{{ $status[0] }} me-3"
                            style="width:45px; height:45px; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-{{ $status[2] }}" style="font-size: 1.3rem;"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-{{ $status[0] }}" style="font-size:1rem;">
                                {{ $status[1] }}
                            </div>

                        </div>
                    </div>

                    @php
                        $status = strtolower($order->shipping_status ?? '-');

                        // Warna badge sesuai status
                        $statusColor = match ($status) {
                            'pending' => 'secondary',
                            'processing' => 'warning',
                            'shipped' => 'primary',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                            default => 'secondary',
                        };

                        // Terjemahan status ke Bahasa Indonesia
                        $statusLabel = match ($status) {
                            'pending' => 'Menunggu Diproses',
                            'processing' => 'Sedang Diproses',
                            'shipped' => 'Sedang Dikirim',
                            'completed' => 'Pesanan Selesai',
                            'cancelled' => 'Pesanan Dibatalkan',
                            default => 'Menunggu Konfirmasi',
                        };
                    @endphp

                    <span class="badge bg-{{ $statusColor }} px-3 py-2 text-capitalize fw-semibold">
                        {{ $statusLabel }}
                    </span>

                </div>
            </div>


            <div class="row g-4">

                {{-- PRODUK --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">

                            <h5 class="fw-bold mb-3">📦 Produk</h5>

                            @foreach ($order->orderDetails as $item)
                                <div class="d-flex align-items-center mb-3">
                                    @if ($item->produk->gambar)
                                        <img src="{{ asset('storage/' . $item->produk->gambar) }}" width="70"
                                            height="70" class="rounded-3 me-3">
                                    @endif

                                    <div class="flex-grow-1">
                                        <div class="fw-semibold">{{ $item->produk->nama }}</div>
                                        <small class="text-muted">
                                            {{ $item->jumlah }} x
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </small>
                                    </div>

                                    <strong>
                                        Rp {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}
                                    </strong>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                {{-- RINGKASAN --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">

                            <h5 class="fw-bold mb-3">🧾 Ringkasan</h5>


                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="fw-semibold d-block">Pengiriman</span>
                                </div>

                                @php
                                    $method = strtolower($order->shipping_method ?? '-');

                                    // 🌈 Warna glossy lembut berdasarkan metode pengiriman
                                    $methodStyle = match ($method) {
                                        'picked up',
                                        'pickup'
                                            => 'color:#fff; background:linear-gradient(135deg, #c89f77, #b78b6f);', // Coklat keemasan
                                        'delivered',
                                        'delivery'
                                            => 'color:#3e2f25; background: linear-gradient(135deg, #f8c8dc, #f19ab7)', // Kuning lembut
                                        default
                                            => 'color:#fff; background:linear-gradient(135deg, #9ca3af, #6b7280);', // Abu glossy
                                    };

                                    // 🇮🇩 Terjemahan metode pengiriman ke Bahasa Indonesia
                                    $methodLabel = match ($method) {
                                        'picked up', 'pickup' => 'Diambil di Toko',
                                        'delivered', 'delivery' => 'Dikirim ke Alamat',
                                        default => ucfirst($method),
                                    };
                                @endphp

                                <span class="badge px-3 py-2 fw-semibold text-capitalize shadow-sm"
                                    style="border:none; border-radius:12px; {{ $methodStyle }}">
                                    {{ $methodLabel }}
                                </span>


                            </div>


                            <hr>

                            <div class="d-flex justify-content-between fs-5">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($order->totalharga, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- ACTION --}}
                            <div class="mt-4 d-grid gap-2">

                                @if ($order->payment_status === 'pending')
                                    <button class="btn btn-outline-danger rounded-pill">
                                        Batalkan Pesanan
                                    </button>
                                @endif

                                @if ($order->shipping_status === 'completed')
                                    <a href="{{ route('products.index') }}" class="btn btn-outline-success rounded-pill">
                                        Pesan Lagi
                                    </a>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection
