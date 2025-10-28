@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Produk</h1>

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tombol Tambah Produk -->
        <a href="{{ route('produk.create') }}" class="btn mb-3" style="background-color: #4CAF50; color: white;">
            <i class="bi bi-plus-circle-fill"></i> Tambah Produk
        </a>

        <!-- Tabel Produk -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead style="background-color: #f2f2f2;">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Berat (gram)</th>
                        <th>Status</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $index => $produk)
                        <tr>
                            <td>{{ $produks->firstItem() + $index }}</td>
                            <td>{{ $produk->nama }}</td>
                            <td>{{ $produk->kategori->nama ?? '-' }}</td>
                            <td>{{ Str::limit($produk->deskripsi, 50, '...') }}</td>
                            <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td>{{ $produk->berat }}</td>
                            <td>
                                <span class="badge {{ $produk->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($produk->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($produk->gambar && file_exists(storage_path('app/public/' . $produk->gambar)))
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" width="60"
                                        height="60" style="object-fit: cover; border-radius: 8px;">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-sm btn-warning"
                                    title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                        onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $produks->links() }}
        </div>
    </div>
@endsection
