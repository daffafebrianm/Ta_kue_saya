@extends('admin.layouts.main')

@section('content')
    <style>
        /* Style tabel dan tombol */
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

        .btn-primary {
            background-color: #4CAF50 !important;
            border: none;
        }

        .btn-primary:hover {
            background-color: #43a047 !important;
        }

        .btn-action {
            border-radius: 8px;
            transition: all 0.2s ease;
            padding: 6px 10px !important;
        }

        .btn-action i {
            font-size: 1rem;
        }

        .btn-action.edit {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffecb5;
        }

        .btn-action.edit:hover {
            background-color: #ffeb99;
        }

        .btn-action.delete {
            background-color: #fde2e1;
            color: #a71d2a;
            border: 1px solid #f5c2c7;
        }

        .btn-action.delete:hover {
            background-color: #f8d7da;
        }

        .alert {
            font-size: 0.95rem;
        }

        /* Flex untuk filter + tombol sejajar horizontal */
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .filter-row select {
            width: auto;
            /* agar dropdown tidak terlalu lebar */
        }

        .filter-row .buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        @media (max-width: 576px) {
            .filter-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-row .buttons {
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>

    <div class="container-fluid px-3 px-md-4">
        <div class="card mt-4 border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <h4 class="mb-0 fw-semibold text-dark">Daftar Barang Masuk</h4>
            </div>

            <div class="card-body">
                {{-- 🔹 Filter Bulan & Tahun + Tombol Tambah & PDF sejajar --}}
                <div class="filter-row">
                    @php
                        $currentMonth = date('n');
                        $currentYear = date('Y');
                    @endphp

                    <form method="GET" action="{{ route('barang-masuk.index') }}" id="filterForm"
                        class="d-flex gap-2 flex-wrap align-items-center">
                        <select name="bulan" class="form-select" id="bulanSelect">
                            <option value="">-- Pilih Bulan --</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}"
                                    {{ request('bulan', $currentMonth) == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>

                        <select name="tahun" class="form-select" id="tahunSelect">
                            @for ($i = $currentYear - 5; $i <= $currentYear; $i++)
                                <option value="{{ $i }}"
                                    {{ request('tahun', $currentYear) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </form>

                    <div class="buttons ms-auto d-flex gap-2 align-items-center">
                        <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Barang Masuk
                        </a>
                        <a href="{{ route('barang-masuk.pdf', [
                            'bulan' => request('bulan'),
                            'tahun' => request('tahun'),
                        ]) }}"
                            class="btn btn-success d-flex align-items-center">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Download PDF
                        </a>
                    </div>

                </div>

                {{-- 🔹 Tabel Barang Masuk --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle text-center">
                        <thead class="text-nowrap">
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Modal</th>
                                <th>Harga Jual</th>
                                <th>Tanggal Masuk</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangMasuk as $bm)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bm->produk->nama ?? '-' }}</td>
                                    <td>{{ $bm->jumlah }}</td>
                                    <td>Rp {{ number_format($bm->harga_modal, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($bm->harga_jual, 0, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bm->tanggal_masuk)->format('d M Y') }}</td>
                                    <td>{{ $bm->keterangan ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('barang-masuk.edit', $bm->id) }}"
                                                class="btn btn-sm btn-action edit" title="Edit Data">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('barang-masuk.destroy', $bm->id) }}" method="POST"
                                                class="form-delete m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-action delete btn-delete"
                                                    title="Hapus Data">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada data barang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 Script otomatis submit filter --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const bulanSelect = document.getElementById('bulanSelect');
            const tahunSelect = document.getElementById('tahunSelect');

            // Submit otomatis saat dropdown berubah
            bulanSelect.addEventListener('change', () => filterForm.submit());
            tahunSelect.addEventListener('change', () => filterForm.submit());

            // Submit otomatis saat halaman pertama kali dibuka jika belum ada query bulan/tahun
            const urlParams = new URLSearchParams(window.location.search);
            const bulan = urlParams.get('bulan');
            const tahun = urlParams.get('tahun');

            if (!bulan && !tahun) {
                filterForm.submit();
            }
        });
    </script>
@endsection
