@extends('admin.layouts.main')

@section('content')
    <style>
        .dash-wrap {
            padding: 18px 0 40px;
        }

        .kpi-card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #fff;
            padding: 14px 16px;
            box-shadow: 0 8px 22px rgba(16, 24, 40, .06);
            height: 100%;
        }

        .kpi-title {
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
            margin: 0;
        }

        .kpi-value {
            font-size: 20px;
            font-weight: 900;
            color: #111827;
            margin: 6px 0 0;
        }

        .panel {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #fff;
            padding: 14px 16px;
            box-shadow: 0 8px 22px rgba(16, 24, 40, .06);
        }

        .panel-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .panel-title {
            font-size: 14px;
            font-weight: 900;
            color: #111827;
            margin: 0;
        }

        .link-mini {
            font-size: 12px;
            text-decoration: none;
        }

        .table td,
        .table th {
            color: #111827 !important;
        }

        .table thead th {
            background: #f8fafc !important;
            color: #0f172a !important;
        }

        .badge-soft {
            border-radius: 999px;
            padding: .35rem .6rem;
            font-weight: 800;
        }
    </style>

    <div class="container dash-wrap">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h1 class="m-0 fw-black">Dashboard Admin</h1>
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Order</a>
        </div>

        {{-- KPI --}}
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-3">
                <div class="kpi-card">
                    <p class="kpi-title">Today Sale (Jumlah Order)</p>
                    <p class="kpi-value">{{ $todayOrdersCount }}</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="kpi-card">
                    <p class="kpi-title">Total Sale (Jumlah Order)</p>
                    <p class="kpi-value">{{ $totalOrdersCount }}</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="kpi-card">
                    <p class="kpi-title">Today Revenue (Paid)</p>
                    <p class="kpi-value">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="kpi-card">
                    <p class="kpi-title">Total Revenue (Paid)</p>
                    <p class="kpi-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- CHARTS --}}
        <div class="row g-3 mb-3">
            <div class="col-12 col-lg-6">
                <div class="panel">
                    <div class="panel-head">
                        <h3 class="panel-title">Revenue (12 Bulan Terakhir)</h3>
                        <a class="link-mini" href="{{ route('orders.index') }}">Show All</a>
                    </div>
                    <canvas id="revenueChart" height="130"></canvas>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="panel">
                    <div class="panel-head">
                        <h3 class="panel-title">Order by Payment Status</h3>
                        <a class="link-mini" href="{{ route('orders.index') }}">Show All</a>
                    </div>
                    <canvas id="statusChart" height="130"></canvas>
                </div>
            </div>
        </div>

        {{-- RECENT ORDERS --}}
        <div class="panel mb-3">
            <div class="panel-head">
                <h3 class="panel-title">Recent Orders</h3>
                <a class="link-mini" href="{{ route('orders.index') }}">Show All</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Shipping</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $o)
                            @php
                                $pay = strtolower($o->payment_status ?? '');
                                $ship = strtolower($o->shipping_status ?? '');

                                $payClass = match ($pay) {
                                    'paid', 'success', 'settlement' => 'bg-success',
                                    'pending' => 'bg-warning',
                                    'failed', 'expire', 'cancel' => 'bg-danger',
                                    default => 'bg-secondary',
                                };

                                $shipClass = match ($ship) {
                                    'delivered', 'done' => 'bg-success',
                                    'shipped', 'process' => 'bg-primary',
                                    'pending' => 'bg-warning',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <tr>
                                <td class="text-nowrap">{{ \Carbon\Carbon::parse($o->order_date)->format('d M Y') }}</td>
                                <td class="fw-bold">{{ $o->order_code }}</td>
                                <td>{{ $o->user->nama ?? '-' }}</td>
                                <td class="text-nowrap">Rp {{ number_format($o->totalharga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-soft {{ $payClass }}">
                                        {{ ucfirst($o->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-soft {{ $shipClass }}">
                                        {{ ucfirst($o->shipping_status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $o->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">Belum ada order.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- BOTTOM WIDGETS (ringan, opsional) --}}
        <div class="row g-3">
            <div class="col-12 col-lg-4">
                <div class="panel">
                    <div class="panel-head">
                        <h3 class="panel-title">Quick Stats</h3>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted fw-semibold">Total Produk</span>
                        <span class="fw-black">{{ $produkCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted fw-semibold">Total Kategori</span>
                        <span class="fw-black">{{ $kategoriCount }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="panel">
                    <div class="panel-head">
                        <h3 class="panel-title">To Do (Dummy)</h3>
                    </div>
                    <div class="input-group mb-2">
                        <input class="form-control" placeholder="Enter task (dummy UI)" />
                        <button class="btn btn-primary" type="button">Add</button>
                    </div>
                    <div class="small text-muted">*Ini UI saja. Kalau mau real, kita bikin tabel tasks.</div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="panel">
                    <div class="panel-head">
                        <h3 class="panel-title">Catatan</h3>
                    </div>
                    <div class="small text-muted">
                        Dashboard ini ambil ringkasan dari: Orders, Produk, Kategori.
                        Kalau definisi “paid” kamu beda (midtrans dll), statusnya tinggal disesuaikan.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const revenueLabels = @json($labels);
        const revenueData = @json($dataRevenue);

        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Revenue',
                    data: revenueData,
                    tension: 0.35,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const statusLabels = @json($statusLabels);
        const statusData = @json($statusData);

        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'Orders',
                    data: statusData
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
