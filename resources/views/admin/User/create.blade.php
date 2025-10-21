@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h2>Tambah User</h2>

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

    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf

        {{-- Nama --}}
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>

        {{-- Username --}}
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        {{-- Role --}}
        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </div>

        {{-- Nomor HP --}}
        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection
