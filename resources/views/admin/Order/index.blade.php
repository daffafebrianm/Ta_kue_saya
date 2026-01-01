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
            padding: 18px;
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

        /* Badge pill kayak Admin/Customer */
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

        .badge-red {
            background: #ff4d4d;
            color: #fff;
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
            text-decoration: none;
        }

        .btn-view {
            background: #3b82f6;
            color: #fff;
        }

        /* biru */
    </style>

    <div class="container py-3">

        <div class="page-title">Daftar Order</div>

        <div class="panel">
            <div class="table-wrap">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width:70px;">No</th>
                            <th>Order Code</th>
                            <th class="text-left">Nama</th>
                            <th class="text-left">Alamat</th>
                            <th class="text-right">Total</th>
                            <th>Payment Status</th>
                            <th>Shipping Status</th>
                            <th>Tanggal Pesanan</th>
                            <th class="text-left">Note</th>
                            <th style="width:90px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($orders as $index => $order)
                            @php
                                $pay = strtolower($order->payment_status ?? '');
                                $ship = strtolower($order->shipping_status ?? '');

                                // Sesuaikan mapping status kamu
                                $payClass = match (true) {
                                    in_array($pay, ['paid', 'success', 'settlement']) => 'badge-green',
                                    $pay === 'pending' => 'badge-orange',
                                    in_array($pay, ['failed', 'expire', 'cancel']) => 'badge-red',
                                    default => 'badge-gray',
                                };

                                $shipClass = match (true) {
                                    in_array($ship, ['delivered', 'done']) => 'badge-green',
                                    in_array($ship, ['shipped', 'process']) => 'badge-orange',
                                    default => 'badge-gray',
                                };
                            @endphp

                            <tr>
                                <td>{{ $orders->firstItem() + $index }}</td>

                                <td style="font-weight:900; color:#111827;">
                                    {{ $order->order_code }}
                                </td>

                                <td class="text-left">
                                    {{ $order->user->nama ?? '-' }}
                                </td>

                                <td class="text-left" style="max-width:340px; white-space:normal;">
                                    {{ $order->alamat }}
                                </td>

                                <td class="text-right" style="font-weight:900;">
                                    Rp {{ number_format($order->totalharga, 0, ',', '.') }}
                                </td>

                                <td>
                                    <span class="badge-pill {{ $payClass }}">
                                        {{ ucfirst($order->payment_status ?? '-') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge-pill {{ $shipClass }}">
                                        {{ ucfirst($order->shipping_status ?? '-') }}
                                    </span>
                                </td>

                                {{-- FIX: ini harus order_date, bukan shipping_method --}}
                                <td class="text-nowrap">
                                    {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}
                                </td>

                                <td class="text-left" style="max-width:260px; white-space:normal;">
                                    {{ $order->note ?? '-' }}
                                </td>

                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn-icon btn-view"
                                        title="Lihat">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="padding:18px; color:#6b7280;">
                                    Belum ada order.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
