@extends('admin.layouts.main')

@section('title', 'Data User')

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

        /* Tombol umum */
        .btn-primary {
            background-color: #4CAF50 !important;
            border: none;
        }

        .btn-primary:hover {
            background-color: #43a047 !important;
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
    </style>

    <div class="container-fluid px-3 px-md-4">
        <div class="card mt-4 border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0 fw-semibold text-dark">Daftar User</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('user.index') }}" method="GET" id="formSearch" class="d-flex mb-3">
                    <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}"
                        class="form-control me-2" placeholder="Cari nama atau email user...">
                    <button type="button" class="btn btn-primary" disabled style="pointer-events:none;">Cari</button>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle text-center">
                        <thead class="text-nowrap">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Nomor HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $dataUser)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td \>{{ $dataUser->nama }}</td>
                                    <td>{{ $dataUser->username }}</td>
                                    <td>
                                        @if ($dataUser->email)
                                            <a href="mailto:{{ $dataUser->email }}">{{ $dataUser->email }}</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $role = strtolower($dataUser->role ?? '');
                                            $badge =
                                                $role === 'admin'
                                                    ? 'bg-success'
                                                    : ($role === 'customer'
                                                        ? 'bg-warning text-dark'
                                                        : 'bg-secondary');
                                        @endphp
                                        <span class="badge rounded-pill {{ $badge }}">
                                            {{ ucfirst($dataUser->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $dataUser->phone_number ? preg_replace('/(\d{3})(\d{3,4})(\d+)/', '$1-$2-$3', $dataUser->phone_number) : '-' }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('user.edit', $dataUser->id) }}"
                                                class="btn btn-sm btn-action edit" title="Edit User">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada data user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SweetAlert2 Notification --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ✅ Notifikasi sukses tambah/edit
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

        // ⚠️ Konfirmasi sebelum hapus user
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const form = this.closest('.form-delete');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data user yang dihapus tidak bisa dikembalikan.",
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
