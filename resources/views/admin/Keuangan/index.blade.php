@extends('admin.layouts.main')

@section('content')
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

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 🔹 Filter otomatis submit
            const filterForm = document.getElementById('filterForm');
            const bulanSelect = document.getElementById('bulanSelect');
            const tahunSelect = document.getElementById('tahunSelect');

            bulanSelect.addEventListener('change', () => filterForm.submit());
            tahunSelect.addEventListener('change', () => filterForm.submit());

            // 🔹 Chart.js
            const ctx = document.getElementById('keuanganChart');

            const data = {
                labels: ['Penjualan', 'Modal', 'Laba Bersih'],
                datasets: [{
                    label: 'Jumlah (Rupiah)',
                    data: [
                        {{ $total_penjualan ?? 0 }},
                        {{ $total_modal ?? 0 }},
                        {{ $total_laba ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(25, 135, 84, 0.7)',
                        'rgba(220, 53, 69, 0.7)',
                        'rgba(13, 110, 253, 0.7)'
                    ],
                    borderColor: [
                        'rgba(25, 135, 84, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(13, 110, 253, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            };

            const options = {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                }
            };

            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        });
    </script>
@endsection
