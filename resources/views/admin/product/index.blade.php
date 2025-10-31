@extends('admin.layouts.main')

@section('content')

<style>

    /* Naikkan kontras teks & border tabel */
.table td, .table th { color:#111827 !important; }         /* slate-900 */
.table thead th { background:#f8fafc !important; color:#0f172a !important; } /* header terang */
.table { border-color:#e5e7eb !important; }               /* border abu terang */
.table tbody tr:hover { background: #f3f4f6 !important; } /* hover jelas */
</style>
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
  <table class="table table-bordered table-hover table-striped table-sm align-middle">
    <thead class="table-light">
      <tr class="text-nowrap">
        <th class="text-center">No</th>
        <th class="text-start">Nama Produk</th>
        <th class="text-start">Kategori</th>
        <th class="text-start">Deskripsi</th>
        <th class="text-end">Harga</th>
        <th class="text-end">Stok</th>
        <th class="text-end">Berat (gram)</th>
        <th class="text-center">Status</th>
        <th class="text-center">Gambar</th>
        <th class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">
      @forelse ($produks as $index => $produk)
        <tr>
          <td class="text-center">{{ $produks->firstItem() + $index }}</td>
          <td class="text-start fw-semibold text-dark">{{ $produk->nama }}</td>
          <td class="text-start text-dark">{{ $produk->kategori->nama ?? '-' }}</td>
          <td class="text-start">
            <span title="{{ $produk->deskripsi }}">{{ Str::limit($produk->deskripsi, 50, '…') }}</span>
          </td>
          <td class="text-end">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
          <td class="text-end">{{ $produk->stok }}</td>
          <td class="text-end">{{ number_format($produk->berat, 2, '.', '') }}</td>
          <td class="text-center">
            <span class="badge rounded-pill {{ $produk->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
              {{ ucfirst($produk->status) }}
            </span>
          </td>
          <td class="text-center">
            @if ($produk->gambar && file_exists(storage_path('app/public/' . $produk->gambar)))
              <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" width="52" height="52"
                   style="object-fit: cover; border-radius: 8px; border:1px solid #e5e7eb;">
            @else
              <span class="text-muted">Tidak ada</span>
            @endif
          </td>
          <td class="text-center">
            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-sm btn-warning" title="Edit">
              <i class="bi bi-pencil-square"></i>
            </a>
            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
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
