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

</style>

<div class="container-fluid px-3 px-md-4">
    <div class="card mt-4 border-0 shadow-sm">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="mb-0 fw-semibold text-dark">Daftar Kategori</h4>
            <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Kategori
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped align-middle text-center">
                    <thead class="text-nowrap">
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategoris as $kategori)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('kategori.edit', $kategori->id) }}"
                                            class="btn btn-sm btn-action edit" title="Edit Kategori">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                            class="form-delete m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-action delete btn-delete"
                                                title="Hapus Kategori">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $kategoris->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

{{-- SweetAlert2 Notification --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ✅ Notifikasi berhasil tambah / edit / hapus
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1800
            });
        @endif

        @if (session('deleted'))
            Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                text: '{{ session('deleted') }}',
                showConfirmButton: false,
                timer: 1800
            });
        @endif

        // ⚠️ Konfirmasi sebelum hapus kategori
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const form = this.closest('.form-delete');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data kategori yang dihapus tidak bisa dikembalikan.",
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
    });
</script>
