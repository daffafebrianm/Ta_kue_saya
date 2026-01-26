@extends('admin.layouts.main')

@section('content')
    <style>
        /* 🌐 Style dasar tabel & teks */
        .table td,
        .table th {
            color: #111827 !important;
            vertical-align: middle !important;
        }

        .table thead th {
            background: #f8fafc !important;
            color: #0f172a !important;
            font-weight: 600;
            border-bottom: 2px solid #e5e7eb !important;
        }

        .table {
            border-color: #e5e7eb !important;
            width: 100%;
        }

        .table tbody tr:hover {
            background: #f3f4f6 !important;
            transition: background 0.2s ease;
        }

        .table td {
            white-space: nowrap;
        }

        /* Badge status */
        .badge-pill {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: capitalize;
        }

        .badge-green {
            background-color: #28a745;
            color: white;
        }

        .badge-orange {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-red {
            background-color: #dc3545;
            color: white;
        }

        .badge-gray {
            background-color: #adb5bd;
            color: white;
        }

        .badge-blue {
            background-color: #60a5fa !important;
            color: #fff !important;
        }

        /* Tombol aksi */
        .btn-action {
            border-radius: 8px;
            transition: all 0.2s ease;
            padding: 6px 10px !important;
        }

        .btn-action i {
            font-size: 1rem;
        }

        .btn-action.view {
            background-color: #3b82f6;
            color: #fff;
            border: none;
        }

        .btn-action.view:hover {
            background-color: #2563eb;
        }
    </style>

    <div class="container-fluid px-3 px-md-4">
        <div class="card mt-4 border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0 fw-semibold text-dark">Daftar Order</h4>
            </div>

            <div class="card-body">
                {{-- Form Filter Bulan & Tahun --}}
                <form id="filterForm" method="GET" action="{{ route('orders.index') }}"
                    class="row g-3 mb-3 align-items-center">
                    @php
                        $currentMonth = date('n');
                        $currentYear = date('Y');
                    @endphp

                    <div class="col-md-3">
                        <select name="bulan" class="form-select" id="bulanSelect">
                            <option value="">-- Pilih Bulan --</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}"
                                    {{ request('bulan') == $i || (!request('bulan') && $currentMonth == $i) ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="tahun" class="form-select" id="tahunSelect">
                            @for ($i = $currentYear - 5; $i <= $currentYear; $i++)
                                <option value="{{ $i }}"
                                    {{ request('tahun') == $i || (!request('tahun') && $currentYear == $i) ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Tombol Cetak PDF di ujung kanan -->
                    <div class="col d-flex justify-content-end">
                        <a href="{{ route('orders.pdf', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}"
                            class="btn btn-success" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
                        </a>
                    </div>
                </form>


                {{-- Form Search --}}
                <form action="{{ route('orders.index') }}" method="GET" id="formSearch" class="d-flex mb-3">
                    <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}"
                        class="form-control me-2" placeholder="Cari berdasarkan kode order...">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>


                {{-- Tabel Order --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle text-center">
                        <thead class="text-nowrap">
                            <tr>
                                <th>No</th>
                                <th>Order Code</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Total</th>
                                <th>Tanggal Pesanan</th>
                                <th>Payment Status</th>
                                <th>Shipping Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $index => $order)
                                @php
                                    $pay = strtolower($order->payment_status ?? '');
                                    $ship = strtolower($order->shipping_status ?? '');

                                    $payClass = match (true) {
                                        in_array($pay, ['paid', 'success', 'settlement']) => 'badge-green',
                                        $pay === 'pending' => 'badge-orange',
                                        in_array($pay, ['failed', 'expire', 'cancel', 'canceled']) => 'badge-red',
                                        default => 'badge-gray',
                                    };

                                    $shipClass = match (true) {
                                        in_array($ship, ['completed', 'delivered', 'done']) => 'badge-green',
                                        in_array($ship, ['shipped']) => 'badge-orange',
                                        in_array($ship, ['processing', 'process', 'packing']) => 'badge-blue',
                                        in_array($ship, ['cancel', 'canceled']) => 'badge-red',
                                        default => 'badge-gray',
                                    };
                                @endphp

                                <tr>
                                    <td>{{ $orders->firstItem() + $index }}</td>
                                    <td>{{ $order->order_code }}</td>
                                    <td>{{ $order->user->nama ?? '-' }}</td>
                                    <td class="text-start" style="max-width:280px; white-space:normal;">
                                        {{ $order->alamat }}
                                    </td>
                                    <td class="text-end fw-semibold">Rp
                                        {{ number_format($order->totalharga, 0, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                                    <td><span
                                            class="badge-pill {{ $payClass }}">{{ ucfirst($order->payment_status ?? '-') }}</span>
                                    </td>

                                    {{-- 🔄 Shipping Status (editable) --}}
                                    <td>
                                        @php
                                            $current = $order->shipping_status;
                                            $options = match ($current) {
                                                'pending' => ['processing'],
                                                'processing' => ['shipped', 'cancelled'],
                                                'shipped' => ['completed'],
                                                'completed', 'cancelled' => [],
                                                default => [],
                                            };

                                            // Tentukan warna badge
                                            $badgeColor = match ($current) {
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'shipped' => 'primary',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp

                                        @if (in_array($current, ['completed', 'cancelled']))
                                            {{-- Jika sudah completed/cancelled, tampil badge saja --}}
                                            <span
                                                class="badge bg-{{ $badgeColor }} text-capitalize px-3 py-2 fw-semibold shadow-sm"
                                                style="font-size: 0.85rem; min-width: 110px;">
                                                {{ ucfirst($current) }}
                                            </span>
                                        @else
                                            {{-- Jika belum selesai, tampil dropdown --}}
                                            <form action="{{ route('orders.updateShippingStatus', $order->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <select name="shipping_status"
                                                    class="form-select form-select-sm fw-semibold text-capitalize shadow-sm"
                                                    style="border: 1px solid #e5e7eb;
                                                        border-radius: 10px;
                                                        background-color: #f9fafb;
                                                        color: #111827;
                                                        font-size: 0.85rem;
                                                        padding: 6px 10px;
                                                        min-width: 140px;
                                                        cursor: pointer;
                                                        transition: all 0.2s ease;
                                                    "
                                                    onchange="this.form.submit()">
                                                    <option value="{{ $current }}" selected>{{ ucfirst($current) }}
                                                    </option>
                                                    @foreach ($options as $opt)
                                                        <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        @endif
                                    </td>


                                    <td class="text-center">
                                        <a href="{{ route('orders.show', $order->id) }}"
                                            class="btn btn-sm btn-primary me-1" title="Lihat Order">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-3">Belum ada order.</td>
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
    </div>
@endsection
{{-- Script otomatis submit filter & search --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Filter Bulan & Tahun ---
        const filterForm = document.getElementById('filterForm');
        const bulanSelect = document.getElementById('bulanSelect');
        const tahunSelect = document.getElementById('tahunSelect');

        if (bulanSelect && tahunSelect && filterForm) {
            // Submit otomatis saat dropdown berubah
            bulanSelect.addEventListener('change', () => filterForm.submit());
            tahunSelect.addEventListener('change', () => filterForm.submit());
        }

        // --- Search otomatis ---
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            let delayTimer;
            searchInput.addEventListener('input', function() {
                clearTimeout(delayTimer);
                delayTimer = setTimeout(() => {
                    this.form.submit(); // otomatis submit saat mengetik
                }, 500); // 0.5 detik setelah user berhenti mengetik
            });
        }
    });
</script>
