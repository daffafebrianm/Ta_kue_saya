@extends('admin.layouts.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tambah Produk</h2>

    {{-- Pesan Error --}}
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

    {{-- Form Tambah Produk --}}
    <div class="card shadow-sm p-4 rounded-3 border-0">
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                {{-- Kategori --}}
                <div class="col-md-6">
                    <label for="id_kategori" class="form-label">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-select rounded-3 shadow-sm" required>
                        <option value="" disabled {{ old('id_kategori') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Produk --}}
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Produk</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama produk"
                        value="{{ old('nama') }}" required>
                </div>

                {{-- Harga --}}
                <div class="col-md-6">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" class="form-control" placeholder="Masukkan harga produk"
                        value="{{ old('harga') }}" required>
                </div>

                {{-- Stok --}}
                <div class="col-md-6">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" value="{{ old('stok', 0) }}" required>
                </div>

                {{-- Berat --}}
                <div class="col-md-6">
                    <label for="berat" class="form-label">Berat (gram)</label>
                    <input type="number" name="berat" id="berat" class="form-control" placeholder="Masukkan berat produk"
                        value="{{ old('berat') }}" required>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select rounded-3 shadow-sm" required>
                        <option value="" disabled {{ old('status') ? '' : 'selected' }}>-- Pilih Status --</option>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                {{-- Gambar Produk --}}
                <div class="col-md-6">
                    <label for="gambar" class="form-label">Gambar Produk</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <img id="image-preview" src="#" alt="Preview Gambar" class="mt-2 img-fluid rounded-3 shadow-sm" style="display:none; max-height: 200px;">
                </div>

                {{-- Deskripsi --}}
                <div class="col-12">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Preview Gambar --}}
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('image-preview');

    if(input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}
</script>

@endsection
