@extends('admin.layouts.main')

@section('content')
    <style>
        /* ====== LAYOUT STYLE ====== */
        body {
            background-color: #f9fafb;
            font-family: 'Poppins', sans-serif;
        }

        .dash-wrap {
            padding-top: 8px;
        }

        h2.fw-black {
            font-weight: 800;
            color: #1f2937;
        }

        /* ====== KPI CARD ====== */
        .kpi-card {
            border-radius: 16px;
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            padding: 20px 24px;
            transition: all 0.3s ease;
        }

        .kpi-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.07);
        }

        .kpi-title {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
        }

        .kpi-value {
            font-size: 22px;
            font-weight: 800;
            color: #111827;
            margin-top: 6px;
        }

        /* ====== PANEL / CARD ====== */
        .panel {
            border: none;
            border-radius: 18px;
            background: #fff;
            padding: 18px 20px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .panel:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 26px rgba(0, 0, 0, 0.06);
        }

        .panel-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .panel-title {
            font-size: 15px;
            font-weight: 700;
            color: #1f2937;
        }

        .link-mini {
            font-size: 13px;
            text-decoration: none;
            color: #3b82f6;
            font-weight: 500;
        }

        /* ====== TABLE ====== */
        .table thead th {
            background: #f3f4f6 !important;
            color: #374151 !important;
            font-weight: 700;
        }

        .badge-soft {
            border-radius: 50px;
            padding: 0.4rem 0.7rem;
            font-weight: 700;
            font-size: 12px;
        }

        .bg-gradient-success {
            background: linear-gradient(to right, #22c55e, #16a34a);
            color: #fff !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(to right, #facc15, #eab308);
            color: #fff !important;
        }

        .bg-gradient-danger {
            background: linear-gradient(to right, #ef4444, #b91c1c);
            color: #fff !important;
        }
    </style>

    <div class="container dash-wrap">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="m-0 fw-black">Dashboard Admin</h2>

        </div>

        {{-- KPI Section --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="kpi-card text-center">
                    <p class="kpi-title">Today Orders</p>
                    <p class="kpi-value">{{ $todayOrdersCount }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card text-center">
                    <p class="kpi-title">Orders This Month</p>
                    <p class="kpi-value">{{ $monthlyOrdersCount }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card text-center">
                    <p class="kpi-title">Today Revenue</p>
                    <p class="kpi-value">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card text-center">
                    <p class="kpi-title">Total Revenue This Month</p>
                    <p class="kpi-value">Rp {{ number_format($totalRevenueThisMonth, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- CHARTS --}}
        <div class="row g-3 mb-4">
            <div class="col-lg-6">
                <div class="panel">
                    <div class="panel-head">
                        <h3 class="panel-title">💹 Analisis Jumlah Order (12 Bulan Terakhir)</h3>
                        <a class="link-mini" href="{{ route('orders.index') }}">Lihat Detail</a>
                    </div>
                    <div id="comboChart"></div>
                </div>
            </div>



            <div class="col-lg-6">
                <div class="panel h-100">
                    <div class="panel-head d-flex justify-content-between align-items-center">
                        <h3 class="panel-title">🚚 Status Pesanan Bulan Sekarang</h3>
                        <a class="link-mini" href="{{ route('orders.index') }}">
                            Lihat Semua
                        </a>
                    </div>

                    <div id="statusChart"></div>
                </div>
            </div>

        </div>

        <div class="row g-3 mb-4">
            <div class="col-12"> <!-- full width -->
                <div class="panel h-100">
                    <div class="panel-head">
                        <h3 class="panel-title">💹 Grafik Keuangan (Penjualan, Modal, & Laba)</h3>
                    </div>
                    <div id="financeChart"></div>
                </div>
            </div>
        </div>

 {{-- RECENT PAID ORDERS (THIS MONTH) --}}
<div class="panel mb-4 h-100">
    <div class="panel-head d-flex justify-content-between align-items-center">
        <h3 class="panel-title">🧾 Order Terbaru (Bulan Ini)</h3>
        <a class="link-mini" href="{{ route('orders.index') }}">Lihat Semua</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle text-center mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Kode Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Pengiriman</th>
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
                            'completed', 'delivered' => 'bg-success',
                            'shipped' => 'bg-primary',
                            'processing' => 'bg-warning',
                            default => 'bg-secondary',
                        };
                    @endphp

                    <tr>
                        <td class="text-muted">
                            {{ \Carbon\Carbon::parse($o->order_date)->format('d M Y') }}
                        </td>

                        <td class="fw-semibold">
                            {{ $o->order_code }}
                        </td>

                        <td>
                            {{ $o->user->nama ?? '-' }}
                        </td>

                        <td class="fw-semibold">
                            Rp {{ number_format($o->totalharga, 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="badge {{ $payClass }}">
                                {{ ucfirst($o->payment_status) }}
                            </span>
                        </td>

                        <td>
                            <span class="badge {{ $shipClass }}">
                                {{ ucfirst($o->shipping_status) }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('orders.show', $o->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted py-4">
                            Belum ada order dibayar bulan ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    </div>

    {{-- ApexCharts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* === Data dari Controller === */
            const revenueLabels = @json($labels);
            const revenueData = @json($dataRevenue);
            const statusLabels = @json($statusLabels);
            const statusData = @json($statusData);
            const orderCountData = @json($orderCountData);
            const profitData = @json($profitData);
            const salesData = @json($salesData);
            const capitalData = @json($capitalData);

            /* ==========================================================
               📈 REVENUE AREA CHART
            ========================================================== */
            new ApexCharts(document.querySelector("#revenueChart"), {
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: "Revenue",
                    data: revenueData
                }],
                colors: ['#4f46e5'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        opacityFrom: 0.5,
                        opacityTo: 0.1
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 5
                },
                xaxis: {
                    categories: revenueLabels
                },
                yaxis: {
                    labels: {
                        formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                    }
                },
                markers: {
                    size: 4,
                    colors: ['#fff'],
                    strokeColors: '#4f46e5',
                    strokeWidth: 2
                }
            }).render();

            /* ==========================================================
               🚚 SHIPPING STATUS DONUT
               ========================================================== */

            new ApexCharts(document.querySelector("#statusChart"), {
                chart: {
                    type: 'donut',
                    height: 320,
                    fontFamily: 'Poppins, sans-serif'
                },

                series: statusData,
                labels: statusLabels,

                colors: [
                    '#facc15', // Processing
                    '#3b82f6', // Shipped
                    '#22c55e' // Completed
                ],

                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: true,

                                name: {
                                    show: true,
                                    fontSize: '14px',
                                    fontWeight: 600
                                },

                                value: {
                                    show: true,
                                    fontSize: '20px',
                                    fontWeight: 700
                                },

                                total: {
                                    show: true,
                                    label: 'Total Pengiriman',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },

                legend: {
                    position: 'bottom',
                    fontSize: '12px',
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 12
                    }
                },

                tooltip: {
                    y: {
                        formatter: val => `${val} Order`
                    }
                }
            }).render();


            /* ==========================================================
               📦 BAR CHART: JUMLAH ORDER PER BULAN
            ========================================================== */
            const comboChartOptions = {
                series: [{
                    name: 'Jumlah Order',
                    data: orderCountData
                }],
                chart: {
                    height: 380,
                    type: 'bar',
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 120
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 500
                        }
                    }
                },
                colors: ['#3b82f6'],
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '45%',
                        endingShape: 'rounded',
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: val => val,
                    offsetY: -8,
                    style: {
                        fontSize: '12px',
                        colors: ['#374151'],
                        fontWeight: 600
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        gradientToColors: ['#60a5fa'],
                        opacityFrom: 0.9,
                        opacityTo: 0.4,
                        stops: [0, 100]
                    }
                },
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 5
                },
                xaxis: {
                    categories: revenueLabels,
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontWeight: 500,
                            fontSize: '12px'
                        },
                        rotate: -30
                    }
                },
                yaxis: {
                    title: {
                        text: "Jumlah Order",
                        style: {
                            color: '#3b82f6',
                            fontWeight: 700
                        }
                    },
                    labels: {
                        style: {
                            colors: '#6b7280',
                            fontWeight: 500
                        }
                    }
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: val => val + ' Order'
                    },
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Poppins, sans-serif'
                    }
                },
                legend: {
                    show: false
                },
            };
            new ApexCharts(document.querySelector("#comboChart"), comboChartOptions).render();

            /* ==========================================================
               💰 GRAFIK KEUANGAN (Penjualan, Modal, & Laba) — SEMUA BATANG
            ========================================================== */
            /* ==========================================================
               💰 GRAFIK KEUANGAN (Penjualan, Modal, & Laba) — RAPIH
            ========================================================== */
            const financeChartOptions = {
                chart: {
                    height: 400,
                    type: 'bar',
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeout',
                        speed: 900
                    }
                },

                series: [{
                        name: 'Penjualan',
                        data: salesData
                    },
                    {
                        name: 'Modal',
                        data: capitalData
                    },
                    {
                        name: 'Laba Bersih',
                        data: profitData
                    }
                ],

                colors: ['#60a5fa', '#fbbf24', '#22c55e'],

                plotOptions: {
                    bar: {
                        borderRadius: 12,
                        columnWidth: '38%',
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },

                dataLabels: {
                    enabled: true,
                    formatter: (val) => {
                        if (!val || val < 50000) return '';
                        return 'Rp ' + val.toLocaleString('id-ID');
                    },
                    offsetY: -10,
                    style: {
                        fontSize: '11px',
                        fontWeight: 600,
                        colors: ['#0f172a']
                    }
                },

                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 3,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },

                xaxis: {
                    categories: revenueLabels,
                    tickPlacement: 'between',
                    labels: {
                        rotate: -25,
                        style: {
                            colors: '#64748b',
                            fontSize: '11px'
                        }
                    }
                },

                yaxis: {
                    labels: {
                        formatter: val => 'Rp ' + val.toLocaleString('id-ID'),
                        style: {
                            colors: '#64748b',
                            fontSize: '11px'
                        }
                    }
                },

                tooltip: {
                    shared: true,
                    intersect: false,
                    theme: 'light',
                    custom: function({
                        series,
                        dataPointIndex,
                        w
                    }) {
                        const bulan = w.globals.labels[dataPointIndex];

                        const dot = (color) => `
            <span style="
                display:inline-block;
                width:8px;
                height:8px;
                border-radius:50%;
                background:${color};
                margin-right:6px;
            "></span>
        `;

                        return `
            <div style="padding:10px 12px;font-size:12px">
                <div style="font-weight:600;margin-bottom:6px">
                    ${bulan}
                </div>

                <div style="display:flex;align-items:center;margin-bottom:4px">
                    ${dot('#60a5fa')}
                    <span>Penjualan:</span>&nbsp;
                    <strong>Rp ${series[0][dataPointIndex].toLocaleString('id-ID')}</strong>
                </div>

                <div style="display:flex;align-items:center;margin-bottom:4px">
                    ${dot('#fbbf24')}
                    <span>Modal:</span>&nbsp;
                    <strong>Rp ${series[1][dataPointIndex].toLocaleString('id-ID')}</strong>
                </div>

                <div style="display:flex;align-items:center">
                    ${dot('#22c55e')}
                    <span style="font-weight:600">Laba:</span>&nbsp;
                    <strong style="color:#16a34a">
                        Rp ${series[2][dataPointIndex].toLocaleString('id-ID')}
                    </strong>
                </div>
            </div>
        `;
                    }
                },


                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    fontSize: '12px',
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 999
                    }
                },

                title: {
                    text: 'Grafik Keuangan Bulanan',
                    style: {
                        fontSize: '16px',
                        fontWeight: 700,
                        color: '#0f172a'
                    }
                },


                responsive: [{
                    breakpoint: 768,
                    options: {
                        plotOptions: {
                            bar: {
                                columnWidth: '55%'
                            }
                        },
                        xaxis: {
                            labels: {
                                rotate: -45
                            }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            new ApexCharts(
                document.querySelector("#financeChart"),
                financeChartOptions
            ).render();



        });
    </script>
@endsection
