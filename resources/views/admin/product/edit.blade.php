@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h2>Edit Produk</h2>

    {{-- tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- form edit produk --}}
    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Kategori --}}
        <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}"
                        {{ old('id_kategori', $produk->id_kategori) == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nama Produk --}}
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control"
                   value="{{ old('nama', $produk->nama) }}" required>
        </div>

        {{-- Deskripsi --}}
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
        </div>

        {{-- Harga --}}
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control"
                   value="{{ old('harga', $produk->harga) }}" step="0.01" min="0" required>
        </div>

        {{-- Stok --}}
        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control"
                   value="{{ old('stok', $produk->stok) }}" min="0" required>
        </div>

        {{-- Gambar --}}
        <div class="form-group">
            <label>Gambar Produk</label><br>
            @if ($produk->gambar)
                <img src="{{ asset('uploads/produk/' . $produk->gambar) }}" alt="Gambar Produk" width="120" class="mb-2">
            @endif
            <input type="file" name="gambar" class="form-control" accept="image/*">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
        </div>

        {{-- Berat --}}
        <div class="form-group">
            <label>Berat (gram)</label>
            <input type="number" name="berat" class="form-control"
                   value="{{ old('berat', $produk->berat) }}" step="0.01" min="0" required>
        </div>

        {{-- Status --}}
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="aktif" {{ old('status', $produk->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status', $produk->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection
