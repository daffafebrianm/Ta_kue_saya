@extends('admin.layouts.main')
@section('content')

<div class="container">
    <h1>Edit Kategori</h1>

    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $kategori->slug) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>

@endsection
