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

        .table img {
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .btn-primary {
            background-color: #4CAF50 !important;
            border: none;
        }

        .btn-primary:hover {
            background-color: #43a047 !important;
        }

        .alert {
            font-size: 0.95rem;
        }

        .dropdown-menu a:hover {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
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

        /* Kolom deskripsi — batasi panjang teks biar gak merusak layout */
        .table td.desc-cell {
            max-width: 220px;
            /* atur lebar maksimal kolom (bisa kamu sesuaikan) */
            white-space: nowrap;
            /* cegah teks turun ke baris baru */
            overflow: hidden;
            /* sembunyikan teks yang melampaui batas */
            text-overflow: ellipsis;
            /* tambahkan tanda “…” otomatis */
            vertical-align: middle;
        }

        /* Di layar kecil, izinkan teks turun baris */
        @media (max-width: 768px) {
            .table td.desc-cell {
                white-space: normal;
                max-width: 100%;
            }
        }
    </style>

    <div class="container-fluid px-3 px-md-4">
        <div class="card mt-4 border-0 shadow-sm">
           <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
    <h4 class="mb-0 fw-semibold text-dark">Daftar Produk</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('produk.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
        <a href="{{ route('produk.pdf') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF
        </a>
    </div>
</div>


            <div class="card-body">
                {{-- Form Pencarian --}}
                <form action="{{ route('produk.index') }}" method="GET" id="formSearch" class="d-flex mb-3">
                    <input type="text" name="search" id="searchInput" value="{{ $search }}"
                        class="form-control me-2" placeholder="Cari nama produk...">
                    {{-- Tombol Cari hanya tampilan, tidak aktif --}}
                    <button type="button" class="btn btn-primary" disabled style="pointer-events:none;">Cari</button>
                </form>

                {{-- Tabel Produk --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle text-center">
                        <thead class="text-nowrap">
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Berat</th>
                                <th>Gambar</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produks as $produk)
                                <tr>
                                    <td>{{ $loop->iteration + $produks->firstItem() - 1 }}</td>
                                    <td>{{ $produk->nama }}</td>
                                    <td>{{ $produk->kategori->nama ?? '-' }}</td>
                                    <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                    <td>{{ $produk->stok }}</td>
                                    <td>{{ $produk->berat }} gr</td>
                                    <td>
                                        @if ($produk->gambar && Storage::disk('public')->exists($produk->gambar))
                                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk"
                                                width="60">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge rounded-pill {{ $produk->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($produk->status) }}
                                        </span>
                                    </td>
                                    <td class="desc-cell" title="{{ $produk->deskripsi }}">
                                        {{ Str::limit($produk->deskripsi, 50, '…') }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('produk.edit', $produk->id) }}"
                                                class="btn btn-sm btn-action edit" title="Edit Produk">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>

                                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                                                class="form-delete m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-action delete btn-delete"
                                                    title="Hapus Produk">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">Tidak ada data produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $produks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SweetAlert2 Notification --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ✅ Notifikasi produk berhasil ditambahkan
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1800
            });
        @endif

        // 🗑️ Notifikasi produk berhasil dihapus
        @if (session('deleted'))
            Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                text: '{{ session('deleted') }}',
                showConfirmButton: false,
                timer: 1800
            });
        @endif

        // ⚠️ Konfirmasi sebelum hapus produk
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const form = this.closest('.form-delete');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Produk yang dihapus tidak bisa dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // 🔍 Auto-search (submit otomatis setelah berhenti mengetik)
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            let delayTimer;
            searchInput.addEventListener('input', function() {
                clearTimeout(delayTimer);
                delayTimer = setTimeout(() => {
                    this.form.submit();
                }, 500);
            });
        }
    });
</script>
