@extends('user.layouts.main')

@section('content')

<style>
    body {
        background: linear-gradient(180deg, #f9f7f3 0%, #f0ece6 100%);
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    h3 {
        color: #a47c4a;
        letter-spacing: 1px;
    }

    .order-section {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 2.5rem;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .order-header h5 {
        color: #a47c4a;
        font-weight: 700;
        text-transform: uppercase;
    }

    .order-header p {
        color: #7b6e5a;
        font-size: 0.95rem;
    }

    .product-list {
        max-height: 420px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        padding-right: 8px;
        scrollbar-width: thin;
        scrollbar-color: #caa77b #f4ede5;
        animation: fadeIn 0.8s ease-in-out 0.1s backwards;
    }

    .product-list::-webkit-scrollbar {
        width: 8px;
    }
    .product-list::-webkit-scrollbar-track {
        background: #f1eae2;
        border-radius: 10px;
    }
    .product-list::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #a47c4a, #caa77b);
        border-radius: 10px;
    }

    .product-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        background: #fff;
        border-radius: 14px;
        padding: 1rem 1.2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid #eee4d5;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 22px rgba(164, 124, 74, 0.18);
        background: #fffdf9;
    }

    .product-card img {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        object-fit: cover;
        border: 1px solid #f1eae0;
        transition: all 0.3s ease;
    }

    .product-card img:hover {
        transform: scale(1.05);
    }

    .price-text {
        color: #a47c4a;
        font-weight: 700;
        font-size: 1rem;
    }

    /* Footer total + tombol */
    .total-fixed {
        position: sticky;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(6px);
        border-top: 1px solid #e9dfce;
        box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.05);
        border-radius: 0 0 1.5rem 1.5rem;
        padding: 1.2rem 1.5rem;
        margin-top: 1.8rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        animation: fadeIn 0.8s ease-in-out 0.3s backwards;
    }

    .total-fixed h6 {
        color: #6b5d4b;
        margin-bottom: 0.25rem;
    }

    .total-fixed h4 {
        color: #a47c4a;
        font-weight: 700;
        margin: 0;
    }

    /* Tombol utama & cancel */
    .btn-pay {
        background: linear-gradient(90deg, #a47c4a, #caa77b);
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 40px;
        padding: 10px 26px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(164, 124, 74, 0.25);
    }

    .btn-pay:hover {
        background: linear-gradient(90deg, #caa77b, #a47c4a);
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(164, 124, 74, 0.4);
    }

    .btn-cancel {
        background: #fff;
        color: #a47c4a;
        font-weight: 600;
        border: 2px solid #caa77b;
        border-radius: 40px;
        padding: 10px 26px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #fff4ec;
        border-color: #a47c4a;
        transform: translateY(-2px);
    }

    .alert-note {
        background: #fffaf2;
        border: 1px solid #e7d8c2;
        border-left: 4px solid #caa77b;
        border-radius: 10px;
        margin-top: 1.2rem;
    }

    .alert-note strong {
        color: #a47c4a;
    }

    .empty-order {
        background: #fff5f5;
        border: 1px solid #f8d7da;
        border-radius: 12px;
        color: #a94442;
    }

    @media (max-width: 768px) {
        .order-section { padding: 1.4rem; }

        .product-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .product-card img {
            width: 100%;
            height: 150px;
        }

        .total-fixed {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .btn-pay, .btn-cancel {
            width: 100%;
        }
    }
</style>

<div class="container py-5">
    <h3 class="text-center mt-5 mb-5 fw-bold">KONFIRMASI PEMBAYARAN</h3>

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
    <div class="order-section">
        {{-- Header --}}
        <div class="order-header text-center mb-4">
            <h5 class="fw-bold">Detail Pesanan</h5>
            <p class="text-muted mb-0">Kode Pesanan: <span class="fw-semibold">{{ $order->order_code }}</span></p>
            <p class="text-muted small">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
        </div>

        {{-- Produk List --}}
        <div class="product-list">
            @foreach ($order->orderDetails as $detail)
                <div class="product-card">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('storage/' . ($detail->produk->gambar ?? '')) }}"
                             alt="{{ $detail->produk->nama ?? 'Produk Tidak Ditemukan' }}">
                        <div>
                            <div class="fw-semibold text-dark">{{ $detail->produk->nama ?? 'Produk Tidak Ditemukan' }}</div>
                            <div class="text-muted small">Jumlah: {{ $detail->jumlah }}x</div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="price-text">Rp {{ number_format($detail->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Catatan --}}
        @if ($order->note)
            <div class="alert alert-note shadow-sm py-3 px-4">
                <i class="bi bi-info-circle me-2 text-warning"></i>
                <strong>Catatan:</strong> {{ $order->note }}
            </div>
        @endif

        {{-- Total & Tombol --}}
        <div class="total-fixed">
            <div>
                <h6>Total Pembayaran</h6>
                <h4>Rp {{ number_format($order->totalharga, 0, ',', '.') }}</h4>
            </div>
            <div class="d-flex gap-2">
                <button id="cancel-button" class="btn btn-cancel shadow-sm">
                    <i class="bi bi-x-circle me-2"></i> Batalkan Pesanan
                </button>
                <button id="pay-button" class="btn btn-pay shadow">
                    <i class="bi bi-credit-card-2-front me-2"></i> Lanjutkan Pembayaran
                </button>
            </div>
        </div>
    </div>

    @else
        <div class="alert empty-order text-center shadow-sm rounded-4 py-3">
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
    const cancelButton = document.getElementById('cancel-button');

    // Tombol Pembayaran
    if (payButton) {
        payButton.addEventListener('click', function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = "{{ route('Pembayaran.success', $order->id) }}";
                },
                onPending: function(result) {
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
                onError: function() {
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

    // Tombol Cancel Pesanan
    if (cancelButton) {
        cancelButton.addEventListener('click', function() {
            Swal.fire({
                title: 'Batalkan Pesanan?',
                text: "Pesanan ini akan dibatalkan dan tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#a47c4a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('Pembayaran.cancel', $order->id) }}";
                }
            });
        });
    }
});
</script>
@endsection
