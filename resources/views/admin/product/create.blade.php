@extends('admin.layouts.main')
@section('content')
<div class="container">
    <h2>Tambah Produk</h2>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Kategori --}}
        <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nama Produk --}}
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>

        {{-- Deskripsi --}}
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Harga --}}
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" step="0.01" min="0" required>
        </div>

        {{-- Stok --}}
        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}" min="0" required>
        </div>

        {{-- Gambar --}}
        <div class="form-group">
            <label>Gambar Produk</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>

        {{-- Berat --}}
        <div class="form-group">
            <label>Berat (gram)</label>
            <input type="number" name="berat" class="form-control" value="{{ old('berat') }}" step="0.01" min="0" required>
        </div>

        {{-- Status --}}
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
    </form>
</div>
@endsection
