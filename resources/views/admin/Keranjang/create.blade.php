@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h2>Tambah Keranjang</h2>

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

    <form action="{{ route('admin.keranjang.store') }}" method="POST">
        @csrf

        {{-- Pilih User --}}
        <div class="form-group">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Pilih Produk --}}
        <div class="form-group">
            <label>Produk</label>
            <select name="produk_id" class="form-control" required>
                <option value="">-- Pilih Produk --</option>
                @foreach ($produks as $produk)
                    <option value="{{ $produk->id }}" {{ old('produk_id') == $produk->id ? 'selected' : '' }}>
                        {{ $produk->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Jumlah --}}
        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', 1) }}" min="1" required>
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
    </form>
</div>
@endsection
