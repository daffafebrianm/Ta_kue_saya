@extends('admin.layouts.main')
@section('content')
<div class="container">
    <h2>Tambah Order</h2>

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

    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        {{-- Pilih User --}}
        <div class="form-group mb-3">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->nama }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Pilih Produk --}}
        <div class="form-group mb-3">
            <label>Produk</label>
            @foreach ($produks as $produk)
                <div class="d-flex align-items-center mb-2">
                    <input type="checkbox" name="produk_id[]" value="{{ $produk->id }}"
                           {{ (is_array(old('produk_id')) && in_array($produk->id, old('produk_id'))) ? 'checked' : '' }}>
                    <span class="ms-2">{{ $produk->nama }} (Rp {{ number_format($produk->harga,0,',','.') }})</span>
                    <input type="number" name="jumlah[]" class="form-control ms-3" placeholder="Jumlah" min="1"
                           value="{{ old('jumlah.'.$loop->index, 1) }}" style="width: 100px;">
                </div>
            @endforeach
        </div>

        {{-- Catatan --}}
        <div class="form-group mb-3">
            <label>Catatan</label>
            <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="btn btn-success mt-3">Simpan Order</button>
    </form>
</div>
@endsection
