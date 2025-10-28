@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h2>Edit User</h2>

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

    {{-- form edit user --}}
    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control"
                   value="{{ old('nama', $user->nama) }}" required>
        </div>

        {{-- Username --}}
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control"
                   value="{{ old('username', $user->username) }}" required>
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $user->email) }}" required>
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
        </div>

        {{-- Role --}}
        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </div>

        {{-- Nomor HP --}}
        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" name="phone_number" class="form-control"
                   value="{{ old('phone_number', $user->phone_number) }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection
