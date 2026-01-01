@extends('user.layouts.main')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="container my-2">
    <div class="text-center card shadow-lg border-0 py-4">
        <div class="card-header bg-success text-white text-center">
            <h4>Pembayaran Berhasil!</h4>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                <i class="fas fa-check-circle fa-5x text-success"></i>
                <p class="lead mt-3">Terima kasih, pembayaran Anda telah berhasil. Pesanan Anda sedang diproses.</p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5>Detail Pesanan:</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nomor Pesanan:</strong> {{ $order->order_code }}</li>
                        <li class="list-group-item"><strong>Nama:</strong> {{ $order->nama }}</li>
                        <li class="list-group-item"><strong>Total Pembayaran:</strong> Rp {{ number_format($order->totalharga, 0, ',', '.') }}</li>
                        <li class="list-group-item"><strong>Status Pembayaran:</strong> <span class="badge bg-success">{{ ucfirst($order->payment_status) }}</span></li>
                        <li class="list-group-item"><strong>Status Pengiriman:</strong> <span class="badge bg-primary">{{ ucfirst($order->shipping_status) }}</span></li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <h5>Produk yang Dipesan:</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($order->orderDetails as $item)
                            <li class="list-group-item">
                                <strong>{{ $item->produk->nama_produk }}</strong> -
                                {{ $item->jumlah }} x Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('landing') }}" class="btn btn-primary btn-lg">
                    Kembali ke Daftar Pesanan <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
