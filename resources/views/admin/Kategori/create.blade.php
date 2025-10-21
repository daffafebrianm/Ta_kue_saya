@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h2>Tambah Kategori</h2>
    <form action="{{ route('admin.kategori.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama kategori</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-group">
            <label>slug</label>
            <input type="text" name="slug" class="form-control">
        </div>
        <div class="form-group">
            <label>Satuan</label>
            <input type="text" name="deskripsi" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
