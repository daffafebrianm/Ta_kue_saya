@extends('admin.layouts.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Produk</h2>

    {{-- tampilkan error validasi --}}
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

    {{-- form edit produk --}}
    <div class="card shadow-sm p-4 rounded-3 border-0">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                {{-- Kategori --}}
                <div class="col-md-6">
                    <label for="id_kategori" class="form-label">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-select rounded-3 shadow-sm" required>
                        <option value="" disabled {{ old('id_kategori', $produk->id_kategori) ? '' : 'selected' }}>-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('id_kategori', $produk->id_kategori) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Produk --}}
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Produk</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                           value="{{ old('nama', $produk->nama) }}" required>
                </div>

                {{-- Harga --}}
                <div class="col-md-6">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" class="form-control"
                           value="{{ old('harga', $produk->harga) }}" step="0.01" min="0" required>
                </div>

                {{-- Stok --}}
                <div class="col-md-6">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control"
                           value="{{ old('stok', $produk->stok) }}" min="0" required>
                </div>

                {{-- Berat --}}
                <div class="col-md-6">
                    <label for="berat" class="form-label">Berat (gram)</label>
                    <input type="number" name="berat" id="berat" class="form-control"
                           value="{{ old('berat', $produk->berat) }}" step="0.01" min="0" required>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select rounded-3 shadow-sm" required>
                        <option value="aktif" {{ old('status', $produk->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $produk->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                {{-- Gambar --}}
                <div class="col-md-6">
                    <label for="gambar" class="form-label">Gambar Produk</label><br>
                    @if ($produk->gambar)
                        <img id="image-preview" src="{{ asset('uploads/produk/' . $produk->gambar) }}"
                             alt="Gambar Produk" class="mb-2 img-fluid rounded-3 shadow-sm" style="max-height: 200px;">
                    @else
                        <img id="image-preview" src="#" alt="Preview Gambar" class="mb-2 img-fluid rounded-3 shadow-sm" style="display:none; max-height: 200px;">
                    @endif
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                </div>

                {{-- Deskripsi --}}
                <div class="col-12">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update Produk
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
    }
}
</script>

@endsection
