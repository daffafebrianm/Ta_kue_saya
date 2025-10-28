{{-- resources/views/admin/produk/edit.blade.php --}}
@extends('admin.layouts.main')
@section('content')

<div class="container mt-4">
    <h2 class="mb-4">Edit Produk</h2>

    <!-- Notifikasi sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tampilkan error validasi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <!-- Kategori -->
<div class="form-group">
    <label>Kategori</label>
    <select name="id_kategori" class="form-control" required>
        <option value="" disabled {{ old('id_kategori', $produk->id_kategori) ? '' : 'selected' }}>
            -- Pilih Kategori --
        </option>
        @foreach ($kategoris as $kategori)
            <option value="{{ $kategori->id }}"
                {{ (string) old('id_kategori', $produk->id_kategori) === (string) $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
        @endforeach
    </select>
    @error('id_kategori')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
        <!-- Nama Produk -->
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Produk</label>
            <input
                type="text"
                name="nama"
                id="nama"
                value="{{ old('nama', $produk->nama) }}"
                class="form-control @error('nama') is-invalid @enderror"
                required
            >
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Harga -->
        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <input
                type="number"
                name="harga"
                id="harga"
                value="{{ old('harga', $produk->harga) }}"
                step="0.01" min="0"
                class="form-control @error('harga') is-invalid @enderror"
                required
            >
            @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Stok -->
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input
                type="number"
                name="stok"
                id="stok"
                value="{{ old('stok', $produk->stok) }}"
                min="0"
                class="form-control @error('stok') is-invalid @enderror"
                required
            >
            @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Berat -->
        <div class="mb-3">
            <label for="berat" class="form-label">Berat (gram)</label>
            <input
                type="number"
                name="berat"
                id="berat"
                value="{{ old('berat', $produk->berat) }}"
                step="0.01" min="0"
                class="form-control @error('berat') is-invalid @enderror"
                required
            >
            @error('berat') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Status -->
<div class="form-group mb-3">
    <label>Status</label>
    <select name="status" class="form-control" required>
        <option value="" disabled {{ old('status', $produk->status) ? '' : 'selected' }}>
            -- Pilih Status --
        </option>
        <option value="aktif" {{ old('status', $produk->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ old('status', $produk->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>
    @error('status')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

        <!-- Gambar Produk -->
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Produk</label>
            @if ($produk->gambar)
                <div class="mb-2">
                    <img src="{{ asset('uploads/produk/' . $produk->gambar) }}"
                         alt="Gambar Produk"
                         style="max-height:160px;border-radius:.5rem;">
                </div>
            @endif
            <input
                type="file"
                name="gambar"
                id="gambar"
                class="form-control @error('gambar') is-invalid @enderror"
                accept="image/*"
            >
            @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar.</div>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea
                name="deskripsi"
                id="deskripsi"
                rows="3"
                class="form-control @error('deskripsi') is-invalid @enderror"
                required
            >{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection
