@extends('user.layouts.main')

@section('content')


    /* Styling untuk form */
    .container {
    max-width: 600px; /* Membatasi lebar form agar tidak terlalu lebar */
    }

    .h4 {
    font-size: 1.25rem; /* Ukuran judul lebih kecil */
    margin-bottom: 1rem; /* Mengurangi jarak bawah */
    }

    .form-label {
    font-size: 0.875rem; /* Ukuran label lebih kecil */
    }

    .form-control {
    font-size: 0.875rem; /* Ukuran input lebih kecil */
    padding: 0.75rem; /* Mengurangi padding pada input */
    }

    .mb-3 {
    margin-bottom: 1rem; /* Mengurangi jarak bawah antar elemen */
    }

    .text-muted {
    font-size: 0.875rem; /* Ukuran teks penjelasan lebih kecil */
    }

    .btn {
    font-size: 0.875rem; /* Ukuran tombol lebih kecil */
    padding: 0.5rem 1rem; /* Mengurangi padding tombol */
    }

    .alert {
    font-size: 0.875rem; /* Ukuran font alert lebih kecil */
    }

    .d-flex {
    gap: 1rem; /* Menyesuaikan jarak antar tombol */
    }

    .btn-light {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
    }

    hr {
    margin: 1rem 0;
    }

    <div class="container py-4">
        <h1 class="h4 mb-3">PROFIL</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali input Anda:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('Profile.update') }}" method="POST" class="card card-body">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Handphone</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                    class="form-control">
            </div>

            <hr>

            <p class="text-muted mb-2">Kosongkan password jika tidak ingin mengubah.</p>
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ url()->previous() }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
@endsection
