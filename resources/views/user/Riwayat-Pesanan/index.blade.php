@extends('user.layouts.main')

@section('content')

<style>
/* ==============================
   CARD & ORDER STYLING
   ============================== */
.order-card {
    transition: all .25s ease;
    border-radius: 18px;
    overflow: hidden;
}
.order-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0,0,0,.12) !important;
}

.status-strip {
    width: 6px;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    border-radius: 18px 0 0 18px;
}

.product-thumb {
    width: 72px;
    height: 72px;
    object-fit: cover;
    border-radius: 14px;
    background: #e5e7eb;
}

.badge-status {
    font-size: .75rem;
    padding: 8px 14px;
}

.empty-state {
    background: linear-gradient(135deg,#f8fafc,#eef2ff);
}

.text-muted-small {
    font-size: 0.85rem;
}
</style>

<div class="container mt-4">

    {{-- HEADER --}}
    <div class="text-center mb-5">
        <h3 class="fw-bold text-primary mb-1">🧾 Riwayat Pesanan</h3>
        <p class="text-muted text-muted-small">Pantau status pesanan dan pengiriman Anda</p>
    </div>

    {{-- EMPTY STATE --}}
    @if($orders->isEmpty())
        <div class="empty-state text-center p-5 rounded-4 shadow-sm">
            <div class="fs-1 mb-3">📦</div>
            <h5 class="fw-bold">Belum Ada Pesanan</h5>
            <p class="text-muted mb-4">Pesanan Anda akan muncul di sini</p>
            <a href="{{ route('products.index') }}"
               class="btn btn-primary rounded-pill px-4">
                Mulai Belanja
            </a>
        </div>
    @else

    <div class="row g-3"> <!-- gap dikurangi supaya lebih rapat -->
        @foreach($orders as $o)
        @php
            /** ===============================
             * STATUS MAPPING
             * =============================== */
            if ($o->payment_status === 'pending') {
                $status = ['secondary','Menunggu Pembayaran','hourglass'];
            } elseif ($o->payment_status === 'cancelled' || $o->shipping_status === 'cancelled') {
                $status = ['danger','Pesanan Dibatalkan','x-circle'];
            } else {
                $status = match($o->shipping_status) {
                    'processing' => ['warning','Sedang Diproses','clock'],
                    'shipped'    => ['primary','Dalam Pengiriman','truck'],
                    'completed'  => ['success','Pesanan Selesai','check-circle'],
                    default      => ['secondary','Menunggu','hourglass']
                };
            }

            $firstItem = $o->orderDetails->first();
            $moreItem  = max($o->orderDetails->count() - 1, 0);
        @endphp

        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card order-card border-0 shadow-sm h-100 position-relative">

                {{-- STATUS STRIP --}}
                <div class="status-strip bg-{{ $status[0] }}"></div>

                {{-- BADGE --}}
                <span class="badge bg-{{ $status[0] }} badge-status
                      position-absolute top-0 end-0 m-3 rounded-pill">
                    <i class="bi bi-{{ $status[2] }} me-1"></i>
                    {{ $status[1] }}
                </span>

                {{-- CARD BODY --}}
                <div class="card-body ps-4">
                    <div class="mb-2">
                        <div class="fw-bold">Order #{{ $o->order_code }}</div>
                        <small class="text-muted-small">
                            {{ \Carbon\Carbon::parse($o->order_date)->translatedFormat('d F Y') }}
                        </small>
                    </div>

                    {{-- PRODUK --}}
                    @if($firstItem)
                    <div class="d-flex align-items-center mb-3">
                        @if($firstItem->produk->gambar)
                            <img src="{{ asset('storage/'.$firstItem->produk->gambar) }}"
                                 class="product-thumb shadow-sm me-3">
                        @else
                            <div class="product-thumb me-3"></div>
                        @endif

                        <div>
                            <div class="fw-semibold">{{ $firstItem->produk->nama }}</div>
                            <small class="text-muted-small">
                                {{ $firstItem->jumlah }} item
                                @if($moreItem > 0)
                                    • +{{ $moreItem }} produk lainnya
                                @endif
                            </small>
                        </div>
                    </div>
                    @endif

                    <small class="text-muted-small">
                        <i class="bi bi-truck me-1"></i>
                        Pengiriman: <strong>{{ strtoupper($o->shipping_method ?? '-') }}</strong>
                    </small>
                 </div>

                {{-- TOTAL --}}
                <div class="px-4 py-3 border-top d-flex justify-content-between">
                    <span class="fw-semibold">Total</span>
                    <span class="fw-bold text-success">
                        Rp {{ number_format($o->totalharga,0,',','.') }}
                    </span>
                </div>

                {{-- ACTION --}}
                <div class="card-footer bg-white border-0 px-4 pb-4">
                    <div class="d-flex gap-2">

                        {{-- DETAIL --}}
                        <a href="{{ route('Riwayat.show',$o->id) }}"
                           class="btn btn-outline-primary btn-sm rounded-pill w-100">
                            <i class="bi bi-eye me-1"></i> Detail
                        </a>

                        {{-- PESAN LAGI --}}
                        @if($o->shipping_status === 'completed')
                            <a href="{{ route('products.index') }}"
                               class="btn btn-outline-success btn-sm rounded-pill w-100">
                                <i class="bi bi-arrow-repeat me-1"></i>
                                Pesan Lagi
                            </a>
                        @endif

                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $orders->links() }}
    </div>

    @endif
</div>

@endsection
