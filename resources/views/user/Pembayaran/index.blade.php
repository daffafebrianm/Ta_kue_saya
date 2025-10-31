@extends('user.layouts.main')

@section('content')
<div class="container my-5">
    <h3 class="text-center mb-5">Konfirmasi Pembayaran</h3>

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($order)
        <div class="alert alert-info text-center mb-4">
            Silakan periksa detail pesanan Anda di bawah ini.
        </div>

        <!-- Detail Pesanan -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Detail Pesanan #{{ $order->order_code }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td>
                                @foreach($order->orderDetails as $detail)

                                    <div>{{ $detail->produk->nama ?? 'Produk Tidak Ditemukan' }} × {{ $detail->jumlah }}</div>
                                @endforeach
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                            <td>
                                @foreach($order->orderDetails as $detail)
                                     <div> {{ number_format($detail->jumlah, 0, ',', '.') }}</div>
                                @endforeach
                            </td>
                            <td>
                                 @foreach($order->orderDetails as $detail)
                                <div>Rp {{ number_format($detail->total, 0, ',', '.') }}</div>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Total Pembayaran -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="text-right">Total Pembayaran: <strong>Rp {{ number_format($order->totalharga, 0, ',', '.') }}</strong></h5>
            </div>
        </div>

        <!-- Catatan Pembayaran (Opsional) -->
        @if($order->note)
            <div class="mt-4 alert alert-info">
                <strong>Catatan:</strong> {{ $order->note }}
            </div>
        @endif

        <!-- Tombol untuk Melanjutkan Pembayaran -->
        <div class="text-right mt-4">
            <a href="{{ route('Pembayaran.index', ['orderId' => $order->id]) }}" class="btn btn-success btn-lg px-5">
                Lanjutkan Pembayaran
            </a>
        </div>

    @else
        <div class="alert alert-danger text-center">Pesanan tidak ditemukan.</div>
    @endif
</div>
@endsection
