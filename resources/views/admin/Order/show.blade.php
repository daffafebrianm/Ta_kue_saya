@extends('admin.layouts.main')
@section('content')
    <style>
        .page-title {
            font-size: 44px;
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

        /* Tabel mirip gambar */
        .table-wrap {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid #e6e9ef;
        }

        .table-custom {
            margin: 0;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 15px;
        }

        .table-custom thead th {
            background: #f6f7f9;
            color: #111827;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: .02em;
            font-size: 13px;
            padding: 14px 14px;
            border-bottom: 1px solid #e6e9ef;
            text-align: center;
            white-space: nowrap;
        }

        .table-custom tbody td {
            padding: 14px 14px;
            border-bottom: 1px solid #eef1f5;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table-custom tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        .table-custom tbody tr:nth-child(even) {
            background: #fbfcfe;
        }

        .table-custom tbody tr:hover {
            background: #f2f4f7;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .meta {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin: 0 0 14px;
            color: #374151;
            font-weight: 600;
        }

        .meta .chip {
            background: #f6f7f9;
            border: 1px solid #e6e9ef;
            padding: 8px 10px;
            border-radius: 999px;
            font-size: 13px;
        }

        /* Badge mirip role Admin/Customer */
        .badge-pill {
            display: inline-block;
            padding: 7px 14px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 12px;
            color: #111827;
        }

        .badge-green {
            background: #7CDE5A;
        }

        .badge-orange {
            background: #F7B23B;
        }

        .badge-gray {
            background: #E5E7EB;
        }

        /* Tombol ikon */
        .btn-icon {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            color: #111;
        }

        .btn-edit {
            background: #f4a62a;
        }

        .btn-delete {
            background: #ff1e1e;
            color: #fff;
        }

        .btn-back {
            border: 1px solid #e6e9ef;
            background: #fff;
            padding: 10px 14px;
            border-radius: 8px;
            font-weight: 800;
        }
    </style>

    <div class="container py-3">

        <div class="d-flex align-items-center justify-content-between">
            <div class="page-title">Order Detail</div>

            <a href="{{ route('orders.index') }}" class="btn-back">
                ← Kembali
            </a>
        </div>

        <div class="panel mb-3">
            <div class="meta">
                <div class="chip">Order Code: <strong>{{ $order->order_code }}</strong></div>
                <div class="chip">User: <strong>{{ $order->user->nama ?? '-' }}</strong></div>
                <div class="chip">Tanggal:
                    <strong>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</strong></div>

                {{-- status contoh (sesuaikan fieldmu) --}}
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
                        <tr>
                            <th style="width:70px;">No</th>
                            <th class="text-left">Produk</th>
                            <th style="width:120px;">Jumlah</th>
                            <th class="text-right" style="width:160px;">Harga</th>
                            <th class="text-right" style="width:180px;">Total</th>
                            {{-- Kalau tidak butuh aksi, hapus kolom ini --}}
                            <th style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->orderDetails as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-left">
                                    <div style="font-weight:800; color:#111827;">
                                        {{ $detail->produk->nama ?? '-' }}
                                    </div>
                                </td>
                                <td>{{ $detail->jumlah }}</td>
                                <td class="text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td class="text-right" style="font-weight:900;">
                                    Rp {{ number_format($detail->total, 0, ',', '.') }}
                                </td>

                                {{-- Opsional: tombol aksi (hapus item). Kalau belum ada route, hapus blok ini --}}
                                <td>
                                    {{-- contoh tombol edit dummy --}}
                                    <button type="button" class="btn-icon btn-edit" title="Edit (opsional)">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    {{-- contoh tombol delete dummy --}}
                                    <button type="button" class="btn-icon btn-delete" title="Hapus (opsional)">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding:18px; color:#6b7280;">
                                    Tidak ada detail produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (!empty($order->note))
                <div class="mt-3" style="color:#374151;">
                    <strong>Note:</strong> {{ $order->note }}
                </div>
            @endif
        </div>
    </div>
@endsection
