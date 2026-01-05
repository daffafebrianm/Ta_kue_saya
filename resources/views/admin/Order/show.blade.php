@extends('admin.layouts.main')

@section('content')
<style>
    .page-title {
        font-size: 35px;
        font-weight: 800;
        color: #1f2a44;
        margin: 10px 0 22px;
    }

    .panel {
        background: #fff;
        border: 1px solid #e6e9ef;
        border-radius: 10px;
        padding: 18px 18px 10px;
        box-shadow: 0 10px 28px rgba(16, 24, 40, .06);
    }

    .table-wrap {
        overflow-x: auto;
        border-radius: 10px;
        border: 1px solid #e6e9ef;
    }

    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 15px;
    }

    .table-custom thead th {
        background: #f8fafc;
        color: #0f172a;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: .02em;
        font-size: 13px;
        padding: 14px;
        border-bottom: 1px solid #e5e7eb;
        text-align: center;
        white-space: nowrap;
    }

    .table-custom tbody td {
        padding: 14px;
        border-bottom: 1px solid #eef1f5;
        text-align: center;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background: #f3f4f6;
        transition: background 0.2s ease;
    }

    .table-custom img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .text-left {
        text-align: left !important;
    }

    .text-right {
        text-align: right !important;
    }

    .meta {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 16px;
        color: #374151;
        font-weight: 600;
    }

    .meta .chip {
        background: #f6f7f9;
        border: 1px solid #e6e9ef;
        padding: 8px 12px;
        border-radius: 999px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .badge-pill {
        display: inline-block;
        padding: 7px 14px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 12px;
        color: #fff;
    }

    .badge-green {
        background: #28a745;
    }

    .badge-orange {
        background: #ffc107;
        color: #111;
    }

    .badge-gray {
        background: #adb5bd;
    }

    .btn-back {
        border: 1px solid #e5e7eb;
        background: #fff;
        padding: 10px 14px;
        border-radius: 8px;
        font-weight: 700;
        color: #111827;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back:hover {
        background: #f3f4f6;
    }
</style>

<div class="container py-3">

    <div class="d-flex align-items-center justify-content-between flex-wrap">
        <div class="page-title">Order Detail</div>

        <a href="{{ route('orders.index') }}" class="btn-back">
            ← Kembali
        </a>
    </div>

    <div class="panel mb-3">
        <div class="meta">
            <div class="chip">Kode Pemesanan: <strong>{{ $order->order_code }}</strong></div>
            <div class="chip">Pembeli: <strong>{{ $order->user->nama ?? '-' }}</strong></div>
            <div class="chip">Tanggal Order:
                <strong>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</strong>
            </div>

            @php
                $pay = strtolower($order->payment_status ?? '');
                $ship = strtolower($order->shipping_status ?? '');

                $payClass = in_array($pay, ['paid', 'success', 'settlement'])
                    ? 'badge-green'
                    : ($pay === 'pending'
                        ? 'badge-orange'
                        : 'badge-gray');

                $shipClass = in_array($ship, ['delivered', 'done'])
                    ? 'badge-green'
                    : (in_array($ship, ['shipped', 'process'])
                        ? 'badge-orange'
                        : 'badge-gray');
            @endphp

            <div class="chip">Payment:
                <span class="badge-pill {{ $payClass }}">{{ ucfirst($order->payment_status ?? '-') }}</span>
            </div>
            <div class="chip">Shipping:
                <span class="badge-pill {{ $shipClass }}">{{ ucfirst($order->shipping_status ?? '-') }}</span>
            </div>

            <div class="chip">Total:
                <strong>Rp {{ number_format($order->totalharga, 0, ',', '.') }}</strong>
            </div>
        </div>

        <div class="table-wrap">
            <table class="table-custom">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->orderDetails as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if ($detail->produk && $detail->produk->gambar && Storage::disk('public')->exists($detail->produk->gambar))
                                    <img src="{{ asset('storage/' . $detail->produk->gambar) }}" alt="Gambar Produk">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td class="text-left fw-semibold text-dark">
                                {{ $detail->produk->nama ?? '-' }}
                            </td>
                            <td>{{ $detail->jumlah }}</td>
                            <td class="text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td class="text-right fw-bold">
                                Rp {{ number_format($detail->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                Tidak ada detail produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

       @if (!empty($order->note))
    <div class="mt-4">
        <div style="
            background-color:#ecfdf5;
            border-left:5px solid #10b981;
            border-radius:8px;
            padding:14px 18px;
            box-shadow:0 1px 4px rgba(0,0,0,0.05);
            color:#065f46;
        ">
            <strong style="font-size:15px;">
                <i class="bi bi-sticky-fill me-1" style="color:#059669;"></i> Catatan Pelanggan
            </strong>
            <div style="margin-top:6px; font-size:14px; line-height:1.6;">
                {{ $order->note }}
            </div>
        </div>
    </div>
@endif
 

    </div>
</div>
@endsection
