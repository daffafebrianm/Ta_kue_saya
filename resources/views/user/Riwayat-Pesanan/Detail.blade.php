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
</style>

<div class="container my-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <a href="{{ route('orders.index') }}"
           class="text-decoration-none text-muted">
            ← Kembali ke Riwayat Pesanan
        </a>
        <h3 class="fw-bold mt-2">
            Detail Pesanan #{{ $order->order_code }}
        </h3>
        <small class="text-muted">
            {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}
        </small>
    </div>

    {{-- STATUS --}}
    @php
        if ($order->payment_status === 'pending') {
            $status = ['secondary','Menunggu Pembayaran','hourglass'];
        } elseif ($order->shipping_status === 'cancelled') {
            $status = ['danger','Pesanan Dibatalkan','x-circle'];
        } else {
            $status = match($order->shipping_status) {
                'processing' => ['warning','Sedang Diproses','clock'],
                'shipped'    => ['primary','Dalam Pengiriman','truck'],
                'completed'  => ['success','Pesanan Selesai','check-circle'],
                default      => ['secondary','Menunggu','hourglass']
            };
        }
    @endphp

    <div class="alert alert-{{ $status[0] }} rounded-4">
        <i class="bi bi-{{ $status[2] }} me-1"></i>
        <strong>Status:</strong> {{ $status[1] }}
    </div>

    <div class="row g-4">

        {{-- PRODUK --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">

                    <h5 class="fw-bold mb-3">📦 Produk</h5>

                    @foreach($order->orderDetails as $item)
                        <div class="d-flex align-items-center mb-3">
                            @if($item->produk->gambar)
                                <img src="{{ asset('storage/'.$item->produk->gambar) }}"
                                     width="70" height="70"
                                     class="rounded-3 me-3">
                            @endif

                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $item->produk->nama }}</div>
                                <small class="text-muted">
                                    {{ $item->jumlah }} x
                                    Rp {{ number_format($item->harga,0,',','.') }}
                                </small>
                            </div>

                            <strong>
                                Rp {{ number_format($item->jumlah * $item->harga,0,',','.') }}
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


                    <div class="d-flex justify-content-between mb-2">
                        <span>Pengiriman</span>
                        <strong>{{ strtoupper($order->shipping_method ?? '-') }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fs-5">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold text-success">
                            Rp {{ number_format($order->totalharga,0,',','.') }}
                        </span>
                    </div>

                    {{-- ACTION --}}
                    <div class="mt-4 d-grid gap-2">

                        @if($order->payment_status === 'pending')
                            <button class="btn btn-outline-danger rounded-pill">
                                Batalkan Pesanan
                            </button>
                        @endif

                        @if($order->shipping_status === 'completed')
                            <a href="{{ route('products.index') }}"
                               class="btn btn-outline-success rounded-pill">
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
