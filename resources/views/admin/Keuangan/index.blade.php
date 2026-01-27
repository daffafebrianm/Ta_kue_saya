@extends('admin.layouts.main')

@section('content')
    <style>
        #keuanganChart {
            height: 380px !important;
            max-height: 400px;
        }

        table.table-bordered {
            border: 1px solid #dee2e6;
        }

        table.table-bordered th,
        table.table-bordered td {
            vertical-align: middle;
        }

        tr.subtotal:hover {
            background-color: #fff3cd !important;
            /* highlight saat hover subtotal */
        }

        .table thead th {
            border-bottom: 2px solid #0d6efd;
        }

        .table tfoot td {
            border-top: 2px solid #0d6efd;
        }

        .table td,
        .table th {
            vertical-align: middle;
            font-size: 14px;
        }

        .table-hover tbody tr:hover {
            background-color: #f8fafc;
            transition: 0.2s ease-in-out;
        }




        .bg-light {
            background-color: #f1f5f9 !important;
        }

        .table ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .table ul li {
            position: relative;
            padding-left: 12px;
            margin-bottom: 5px;
            font-size: 14px;
            color: #374151;
        }

        .table ul li::before {
            content: "";
            position: absolute;
            left: 0;
            top: 6px;
            width: 4px;
            height: 12px;
            background: linear-gradient(180deg, #60a5fa, #2563eb);
            border-radius: 2px;
        }


        .table-hover tbody tr:hover {
            background-color: #f8fafc;
            transition: background 0.2s ease-in-out;
        }

        .card {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .btn-pdf {
            background: linear-gradient(90deg, #16a34a, #22c55e);
            border: none;
            color: #fff;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .btn-pdf:hover {
            background: linear-gradient(90deg, #15803d, #16a34a);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(34, 197, 94, 0.3);
        }

        h3.page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
    </style>

    <div class="container mt-4">
        {{-- Header Judul + Tombol PDF --}}
        <h3 class="fw-semibold mb-4  page-title">
            <span> Laporan Keuangan</span>
            <a href="{{ route('Keuangan.pdf', [
                'tanggal' => request('tanggal'),
                'bulan' => request('bulan'),
                'tahun' => request('tahun') ?? date('Y'),
                'minggu' => request('minggu'),
            ]) }}"
                class="btn btn-pdf d-flex align-items-center gap-2 shadow-sm" target="_blank">
                <i class="bi bi-file-earmark-pdf fs-5"></i> <span>Cetak PDF</span>
            </a>
        </h3>

        {{-- Filter Bulan, Minggu & Tahun --}}
        <form method="GET" action="{{ route('keuangan.index') }}" id="filterForm" class="row g-3 mb-4">
            @php
                $currentMonth = date('n');
                $currentYear = date('Y');
            @endphp

            <div class="col-md-3">
                <label class="form-label fw-semibold text-secondary">Tanggal</label>
                <select name="tanggal" class="form-select" id="tanggalSelect">
                    <option value="">-- Semua Tanggal --</option>
                    @for ($i = 1; $i <= 31; $i++)
                        <option value="{{ $i }}" {{ request('tanggal') == $i ? 'selected' : '' }}>
                            Tanggal {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold text-secondary">Bulan</label>
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
                <label class="form-label fw-semibold text-secondary">Minggu</label>
                <select name="minggu" class="form-select" id="mingguSelect">
                    <option value="">-- Semua Minggu --</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('minggu') == $i ? 'selected' : '' }}>
                            Minggu ke-{{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold text-secondary">Tahun</label>
                <select name="tahun" class="form-select" id="tahunSelect">
                    @for ($i = $currentYear - 5; $i <= $currentYear; $i++)
                        <option value="{{ $i }}"
                            {{ request('tahun') == $i || (!request('tahun') && $currentYear == $i) ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </form>

        {{-- 🔹 Rincian Penjualan --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-semibold text-secondary mb-4">
                    <i class="bi bi-receipt text-primary me-2"></i>Rincian Penjualan
                </h5>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Kode Order</th>
                                <th>Tanggal Order</th>
                                <th>Nama Customer</th>
                                <th>Produk</th>
                                <th>Modal (Rp)</th>
                                <th>Harga (Rp)</th>
                                <th>Qty</th>
                                <th>Total (Rp)</th>
                                <th>Laba (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $total_modal_global = 0;
                                $total_harga_global = 0;
                                $total_penjualan_global = 0;
                                $total_laba_global = 0;
                            @endphp

                            @forelse ($orders as $order)
                                @php
                                    $jumlah_produk = count($order->orderDetails);
                                @endphp

                                @foreach ($order->orderDetails as $index => $detail)
                                    @php
                                        $modal = ($detail->harga_modal ?? 0) * ($detail->jumlah ?? 0);
                                        $harga = ($detail->harga ?? 0) * ($detail->jumlah ?? 0);
                                        $total = $detail->total ?? ($detail->harga ?? 0) * ($detail->jumlah ?? 0);
                                        $laba =
                                            (($detail->harga ?? 0) - ($detail->harga_modal ?? 0)) *
                                            ($detail->jumlah ?? 0);

                                        // akumulasi global
                                        $total_modal_global += $modal;
                                        $total_harga_global += $harga;
                                        $total_penjualan_global += $total;
                                        $total_laba_global += $laba;
                                    @endphp

                                    <tr>
                                        {{-- Kolom hanya muncul sekali per order --}}
                                        @if ($index === 0)
                                            <td rowspan="{{ $jumlah_produk }}" class="text-center align-middle">
                                                {{ $no++ }}</td>
                                            <td rowspan="{{ $jumlah_produk }}"
                                                class="text-center align-middle fw-semibold">
                                                {{ $order->order_code ?? '-' }}</td>
                                            <td rowspan="{{ $jumlah_produk }}" class="text-center align-middle">
                                                {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}
                                            </td>
                                            <td rowspan="{{ $jumlah_produk }}" class="align-middle">
                                                {{ $order->nama ?? '-' }}</td>
                                        @endif

                                        {{-- Produk per baris --}}
                                        <td class="align-middle">{{ $detail->produk->nama ?? '-' }}</td>
                                        <td class="text-end text-danger align-middle">Rp
                                            {{ number_format($detail->harga_modal ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end align-middle">Rp
                                            {{ number_format($detail->harga ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-center align-middle">{{ $detail->jumlah ?? 0 }}</td>
                                        <td class="text-end text-success align-middle">Rp
                                            {{ number_format($total, 0, ',', '.') }}</td>
                                        <td class="text-end text-primary fw-semibold align-middle">Rp
                                            {{ number_format($laba, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach

                                {{-- Baris subtotal per order --}}
                                <tr class="table-warning fw-bold text-end border-top border-2 subtotal">
                                    <td colspan="5" class="text-center text-dark">Subtotal Order</td>
                                    <td class="text-danger">
                                        Rp
                                        {{ number_format($order->orderDetails->sum(fn($d) => ($d->harga_modal ?? 0) * ($d->jumlah ?? 0)), 0, ',', '.') }}
                                    </td>
                                    <td>—</td>
                                    <td class="text-center">
                                        {{ $order->orderDetails->sum(fn($d) => $d->jumlah) }}
                                    </td>
                                    <td class="text-success">
                                        Rp
                                        {{ number_format($order->orderDetails->sum(fn($d) => $d->total ?? ($d->harga ?? 0) * ($d->jumlah ?? 0)), 0, ',', '.') }}
                                    </td>
                                    <td class="text-primary">
                                        Rp
                                        {{ number_format($order->orderDetails->sum(fn($d) => (($d->harga ?? 0) - ($d->harga_modal ?? 0)) * ($d->jumlah ?? 0)), 0, ',', '.') }}
                                    </td>
                                </tr>


                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-3">
                                        Tidak ada data penjualan untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        {{-- Baris Total Keseluruhan --}}
                        <tfoot>
                            <tr class="table-secondary fw-bold text-end">
                                <td colspan="5" class="text-center text-dark">Total Keseluruhan</td>
                                <td class="text-danger">Rp {{ number_format($total_modal_global ?? 0, 0, ',', '.') }}</td>
                                <td>—</td>
                                <td>—</td>
                                <td class="text-success">Rp {{ number_format($total_penjualan_global ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="text-primary">Rp {{ number_format($total_laba_global ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


        {{-- 🔹 Ringkasan Keuangan --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-semibold text-secondary mb-3">
                    <i class="bi bi-bar-chart-line text-primary me-2"></i>Ringkasan Keuangan
                </h5>

                @php
                    use Carbon\Carbon;
                    $tanggal = request('tanggal');
                    $bulan = request('bulan');
                    $tahun = request('tahun', date('Y'));
                    $minggu = request('minggu');
                    $periodeTeks = '';

                    if ($tanggal) {
                        $bulan = request('bulan');
                        $tahun = request('tahun', date('Y'));

                        if ($bulan) {
                            $periodeTeks =
                                "Tanggal $tanggal " .
                                Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F') .
                                " $tahun";
                        } else {
                            $periodeTeks = "Tanggal $tanggal Tahun $tahun";
                        }
                    } elseif ($bulan && $minggu) {
                        $awalBulan = Carbon::create($tahun, $bulan, 1, 0, 0, 0, 'Asia/Jakarta');
                        $startDate = $awalBulan
                            ->copy()
                            ->addWeeks($minggu - 1)
                            ->startOfWeek(Carbon::MONDAY);
                        $endDate = $awalBulan
                            ->copy()
                            ->addWeeks($minggu - 1)
                            ->endOfWeek(Carbon::SUNDAY);

                        if ($startDate->month != $bulan) {
                            $startDate = $awalBulan->copy();
                        }
                        if ($endDate->month != $bulan) {
                            $endDate = $awalBulan->copy()->endOfMonth();
                        }

                        $periodeTeks =
                            "Minggu ke-$minggu (" .
                            $startDate->translatedFormat('d F Y') .
                            ' - ' .
                            $endDate->translatedFormat('d F Y') .
                            ')';
                    } elseif ($bulan) {
                        $periodeTeks = Carbon::createFromDate(null, $bulan, 1)->translatedFormat('F') . " $tahun";
                    } else {
                        $periodeTeks = "Keseluruhan Tahun $tahun";
                    }
                @endphp


                <p class="text-muted mb-3 fst-italic">
                    <i class="bi bi-calendar-event text-primary me-1"></i>
                    <strong>Periode:</strong> {{ $periodeTeks }}
                </p>

                <table class="table table-bordered mt-3 align-middle">
                    <tbody>
                        <tr>
                            <th class="bg-light text-dark fw-semibold" style="width: 250px;">Total Penjualan</th>
                            <td class="text-end text-success fw-bold">
                                Rp {{ number_format($total_penjualan_global ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light text-dark fw-semibold">Total Modal</th>
                            <td class="text-end text-danger fw-bold">
                                Rp {{ number_format($total_modal_global ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light text-dark fw-semibold">Total Laba Bersih</th>
                            <td class="text-end text-primary fw-bold">
                                Rp {{ number_format($total_laba_global ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 🔹 Grafik Keuangan --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-semibold text-secondary mb-4">
                    <i class="bi bi-graph-up-arrow text-primary me-2"></i>Grafik Keuangan
                </h5>
                <canvas id="keuanganChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            ['tanggalSelect', 'bulanSelect', 'tahunSelect', 'mingguSelect'].forEach(id => {
                document.getElementById(id).addEventListener('change', () => filterForm.submit());
            });

            const ctx = document.getElementById('keuanganChart').getContext('2d');
            const gradientPenjualan = ctx.createLinearGradient(0, 0, 0, 300);
            gradientPenjualan.addColorStop(0, '#22c55e');
            gradientPenjualan.addColorStop(1, 'rgba(34,197,94,0.3)');
            const gradientModal = ctx.createLinearGradient(0, 0, 0, 300);
            gradientModal.addColorStop(0, '#ef4444');
            gradientModal.addColorStop(1, 'rgba(239,68,68,0.3)');
            const gradientLaba = ctx.createLinearGradient(0, 0, 0, 300);
            gradientLaba.addColorStop(0, '#3b82f6');
            gradientLaba.addColorStop(1, 'rgba(59,130,246,0.3)');

            const data = {
                labels: ['Penjualan', 'Modal', 'Laba Bersih'],
                datasets: [{
                    type: 'bar',
                    label: 'Deskripsi Keuangan',
                    data: [
                        {{ $total_penjualan_global ?? 0 }},
                        {{ $total_modal_global ?? 0 }},
                        {{ $total_laba_global ?? 0 }}
                    ],
                    backgroundColor: [gradientPenjualan, gradientModal, gradientLaba],
                    borderColor: ['#22c55e', '#ef4444', '#3b82f6'],
                    borderWidth: 1.8,
                    borderRadius: 12,
                    hoverBackgroundColor: ['#16a34a', '#dc2626', '#2563eb'],
                    barPercentage: 0.5,
                }, {
                    type: 'line',
                    label: 'Grafik',
                    data: [
                        {{ $total_penjualan_global ?? 0 }},
                        {{ $total_modal_global ?? 0 }},
                        {{ $total_laba_global ?? 0 }}
                    ],
                    borderColor: '#0ea5e9',
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#0ea5e9',
                    tension: 0.4,
                    fill: false
                }]
            };

            new Chart(ctx, {
                data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17,24,39,0.9)',
                            titleColor: '#f3f4f6',
                            bodyColor: '#f9fafb',
                            padding: 12,
                            cornerRadius: 10,
                            displayColors: false,
                            callbacks: {
                                label: (context) => 'Rp ' + new Intl.NumberFormat('id-ID').format(context
                                    .raw || 0)
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(209,213,219,0.3)',
                                borderDash: [6, 4]
                            },
                            ticks: {
                                callback: (v) => 'Rp ' + new Intl.NumberFormat('id-ID').format(v)
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
