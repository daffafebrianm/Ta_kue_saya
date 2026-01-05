@extends('user.layouts.main')

@section('content')

<div class="container py-5">
    <h3 class="text-center mb-5 fw-bold" style="color:#a47c4a;">Konfirmasi Pembayaran</h3>

    {{-- Flash Message SweetAlert --}}
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        </script>
    @endif

    @if ($order)
        {{-- Detail Pesanan --}}
        <div class="card mb-4 mt-3 shadow border-0 rounded-4">
            <div class="card-header text-white rounded-top-4" style="background: linear-gradient(90deg, #a47c4a, #caa77b);">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Detail Pesanan #{{ $order->order_code }}</h5>
            </div>
            <div class="card-body table-responsive p-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $detail)
                        <tr class="text-center align-middle">
                            <td>
                                <img src="{{ asset('storage/' . ($detail->produk->gambar ?? '')) }}"
                                     alt="{{ $detail->produk->nama ?? 'Produk Tidak Ditemukan' }}"
                                     class="rounded-3" style="width:70px; height:70px; object-fit:cover;">
                            </td>
                            <td class="text-start">{{ $detail->produk->nama ?? 'Produk Tidak Ditemukan' }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td class="fw-bold text-success">Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Total Pembayaran --}}
        <div class="card mb-4 shadow-sm border-0 rounded-4">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <span class="fw-semibold fs-5">Total Pembayaran:</span>
                <span class="fw-bold fs-4 text-success">Rp {{ number_format($order->totalharga, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Catatan --}}
        @if ($order->note)
            <div class="alert alert-info shadow-sm border-0 rounded-4 py-3 px-4 mb-4">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Catatan:</strong> {{ $order->note }}
            </div>
        @endif

        {{-- Tombol Lanjutkan Pembayaran --}}
        <div class="text-center mb-5">
            <button id="pay-button"
                    class="btn btn-lg text-white fw-bold px-5 py-3 rounded-pill shadow"
                    style="background: linear-gradient(90deg, #a47c4a, #caa77b); border:none; transition: transform .2s;">
                <i class="bi bi-credit-card-2-front me-2"></i> Lanjutkan Pembayaran
            </button>
        </div>
    @else
        <div class="alert alert-danger text-center shadow-sm rounded-4 py-3">
            Pesanan tidak ditemukan.
        </div>
    @endif
</div>

{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const payButton = document.getElementById('pay-button');
    if(payButton) {
        payButton.addEventListener('click', function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    console.log(result);
                    window.location.href = "{{ route('Pembayaran.success', $order->id) }}";
                },
                onPending: function(result) {
                    console.log(result);
                    Swal.fire({
                        icon: 'info',
                        title: 'Menunggu Pembayaran',
                        text: 'Pembayaran sedang diproses, silakan cek status di riwayat pesanan.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                },
                onError: function(result) {
                    console.log(result);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Pembayaran gagal, silakan coba lagi.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                },
                onClose: function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Dibatalkan',
                        text: 'Kamu menutup popup tanpa menyelesaikan pembayaran.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            });
        });
    }
});
</script>
@endsection
