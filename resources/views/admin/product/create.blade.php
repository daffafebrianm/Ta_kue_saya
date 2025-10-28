@extends('admin.layouts.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tambah Produk</h2>

    {{-- Notifikasi sukses (opsional, kalau controller set flash) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Notifikasi error umum (opsional) --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Error validasi (list) --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        {{-- Kategori (samakan gaya seperti di Edit: form-group + form-control) --}}
        <div class="form-group mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                <option value="" disabled {{ old('id_kategori') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ (string) old('id_kategori') === (string) $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
            @error('id_kategori') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Nama Produk --}}
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Produk</label>
            <input
                type="text"
                name="nama"
                id="nama"
                class="form-control @error('nama') is-invalid @enderror"
                placeholder="Masukkan nama produk"
                value="{{ old('nama') }}"
                required
            >
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Harga --}}
        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <input
                type="number"
                name="harga"
                id="harga"
                class="form-control @error('harga') is-invalid @enderror"
                placeholder="Masukkan harga produk"
                value="{{ old('harga') }}"
                step="0.01" min="0" required
            >
            @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Stok --}}
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input
                type="number"
                name="stok"
                id="stok"
                class="form-control @error('stok') is-invalid @enderror"
                value="{{ old('stok', 0) }}"
                min="0" required
            >
            @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Berat --}}
        <div class="mb-3">
            <label for="berat" class="form-label">Berat (gram)</label>
            <input
                type="number"
                name="berat"
                id="berat"
                class="form-control @error('berat') is-invalid @enderror"
                placeholder="Masukkan berat produk"
                value="{{ old('berat') }}"
                step="0.01" min="0" required
            >
            @error('berat') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Status (samakan gaya seperti Kategori) --}}
        <div class="form-group mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="" disabled {{ old('status') ? '' : 'selected' }}>-- Pilih Status --</option>
                <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Gambar Produk --}}
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Produk</label>
            <input
                type="file"
                name="gambar"
                id="gambar"
                class="form-control @error('gambar') is-invalid @enderror"
                accept="image/*"
                onchange="previewImage(event)"
            >
            @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror

            <img id="image-preview" src="#" alt="Preview Gambar"
                 class="mt-2 img-fluid rounded-3 shadow-sm"
                 style="display:none; max-height: 200px;">
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea
                name="deskripsi"
                id="deskripsi"
                class="form-control @error('deskripsi') is-invalid @enderror"
                rows="3"
                placeholder="Masukkan deskripsi produk"
            >{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan Produk
            </button>
        </div>
    </form>
</div>

{{-- Preview Gambar --}}
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('image-preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}
</script>
@endsection
