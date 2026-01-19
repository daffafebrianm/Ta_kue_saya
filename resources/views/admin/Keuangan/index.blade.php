@extends('admin.layouts.main')

@section('content')
  <style>
    #keuanganChart {
        height: 380px !important;
        max-height: 400px;
    }
</style>


    <div class="container mt-5">
        <h3 class="fw-semibold mb-4 text-primary">Laporan Keuangan</h3>

        {{-- Filter Bulan & Tahun (otomatis submit, tanpa tombol) --}}
        <form method="GET" action="{{ route('keuangan.index') }}" id="filterForm" class="row g-3 mb-4">
            @php
                $currentMonth = date('n'); // bulan sekarang (1–12)
                $currentYear = date('Y'); // tahun sekarang
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
        </form>

        {{-- Ringkasan Keuangan --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold text-secondary">Ringkasan Keuangan</h5>
                    <a href="{{ route('Keuangan.pdf', [
                        'bulan' => request('bulan'),
                        'tahun' => request('tahun') ?? date('Y'),
                    ]) }}"
                        class="btn btn-success d-flex align-items-center gap-2" target="_blank">
                        <i class="bi bi-file-earmark-pdf fs-5"></i>
                        <span>Cetak PDF</span>
                    </a>
                </div>

                <table class="table table-bordered mt-3">
                    <tr>
                        <th>Total Penjualan</th>
                        <td class="text-end text-success fw-bold">Rp {{ number_format($total_penjualan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Modal</th>
                        <td class="text-end text-danger fw-bold">Rp {{ number_format($total_modal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Laba Bersih</th>
                        <td class="text-end text-primary fw-bold">Rp {{ number_format($total_laba, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Grafik Keuangan --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-semibold text-secondary mb-4">Grafik Keuangan</h5>
                <canvas id="keuanganChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart.js (Modern Glassmorphism Style) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 🔹 Auto Filter Submit
            const filterForm = document.getElementById('filterForm');
            const bulanSelect = document.getElementById('bulanSelect');
            const tahunSelect = document.getElementById('tahunSelect');
            bulanSelect.addEventListener('change', () => filterForm.submit());
            tahunSelect.addEventListener('change', () => filterForm.submit());

            // === Chart.js Setup ===
            const ctx = document.getElementById('keuanganChart').getContext('2d');

            // Gradient for Bars
            const gradientPenjualan = ctx.createLinearGradient(0, 0, 0, 300);
            gradientPenjualan.addColorStop(0, '#22c55e');
            gradientPenjualan.addColorStop(1, 'rgba(34,197,94,0.3)');

            const gradientModal = ctx.createLinearGradient(0, 0, 0, 300);
            gradientModal.addColorStop(0, '#ef4444');
            gradientModal.addColorStop(1, 'rgba(239,68,68,0.3)');

            const gradientLaba = ctx.createLinearGradient(0, 0, 0, 300);
            gradientLaba.addColorStop(0, '#3b82f6');
            gradientLaba.addColorStop(1, 'rgba(59,130,246,0.3)');

            // === Data (Bar + Line combo) ===
            const data = {
                labels: ['Penjualan', 'Modal', 'Laba Bersih'],
                datasets: [{
                        type: 'bar',
                        label: 'Deskripsi Keuangan',
                        data: [
                            {{ $total_penjualan ?? 0 }},
                            {{ $total_modal ?? 0 }},
                            {{ $total_laba ?? 0 }}
                        ],
                        backgroundColor: [gradientPenjualan, gradientModal, gradientLaba],
                        borderColor: ['#22c55e', '#ef4444', '#3b82f6'],
                        borderWidth: 1.8,
                        borderRadius: 12,
                        hoverBackgroundColor: ['#16a34a', '#dc2626', '#2563eb'],
                        barPercentage: 0.5,
                    },
                    {
                        type: 'line',
                        label: 'Grafik',
                        data: [
                            {{ $total_penjualan ?? 0 }},
                            {{ $total_modal ?? 0 }},
                            {{ $total_laba ?? 0 }}
                        ],
                        borderColor: '#0ea5e9',
                        borderWidth: 2,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#0ea5e9',
                        tension: 0.4,
                        fill: false
                    }
                ]
            };

            const options = {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1300,
                    easing: 'easeOutQuint'
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#374151',
                            font: {
                                size: 13,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17,24,39,0.9)',
                        titleColor: '#f3f4f6',
                        bodyColor: '#f9fafb',
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#1f2937',
                            font: {
                                size: 14,
                                weight: '600'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(209, 213, 219, 0.3)',
                            borderDash: [6, 4]
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                layout: {
                    padding: 10
                }
            };

            new Chart(ctx, {
                data,
                options
            });
        });
    </script>
@endsection
