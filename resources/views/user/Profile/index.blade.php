@extends('user.layouts.main')

@section('content')

    <style>
        body {
            background-color: #f8f5f2;
            /* Latar belakang lembut */
        }

        .profile-container {
            max-width: 600px;
            padding: 0 15px;

            margin-left: auto;
            margin-right: auto;

        }


        /* Card form */
        .profile-card {
            background: #fff;
            border-radius: 12px;

            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.12);
        }

        h1.h4 {
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #5a3e36;
            text-align: center;
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #4a4a4a;
        }

        .form-control {
            font-size: 0.9rem;
            padding: 0.65rem 0.75rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: #d4a373;
            box-shadow: 0 0 0 0.2rem rgba(212, 163, 115, 0.25);
        }

        .text-muted {
            font-size: 0.85rem;
            color: #7a7a7a !important;
        }

        .alert {
            font-size: 0.875rem;
            border-radius: 8px;
        }

        .btn {
            font-size: 0.9rem;
            padding: 0.55rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-primary {
            background-color: #d4a373;
            border-color: #d4a373;
        }

        .btn-primary:hover {
            background-color: #c5905e;
            border-color: #c5905e;
            transform: translateY(-1px);
        }

        .btn-light {
            background-color: #f1f1f1;
            color: #333;
        }

        .btn-light:hover {
            background-color: #e2e2e2;
        }

        hr {
            border: 0;
            border-top: 1px solid #eee;
            margin: 1.5rem 0;
        }

        .d-flex.gap-2 {
            gap: 1rem;
        }

        @media (max-width: 576px) {
            .container {
                padding: 0 1rem;
            }

            .profile-card {
                padding: 1.5rem;
            }

            h1.h4 {
                font-size: 1.2rem;
            }

            .form-control,
            .btn {
                font-size: 0.85rem;
            }
        }
    </style>
    <div style="height: 100px;"></div>
    <div class="profile-container ">
        <form action="{{ route('Profile.update') }}" method="POST" class="profile-card">
            @csrf
            @method('PUT')

            <h1 class="h4">Profile Saya</h1>

            

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

            <div class="d-flex justify-content-between mt-3">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ url()->previous() }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>

@endsection
{{-- SweetAlert2 Notification --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ✅ Notifikasi sukses update profil
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1800, // alert otomatis hilang setelah 1.8 detik
                toast: true,
                position: 'top-end'
            });
        @endif

        // ✅ Notifikasi data terhapus (jika ada)
        @if (session('deleted'))
            Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                text: '{{ session('deleted') }}',
                showConfirmButton: false,
                timer: 1800,
                toast: true,
                position: 'top-end'
            });
        @endif

        // ✅ Notifikasi error (opsional)
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `
                    <ul style="text-align: left; padding-left: 1rem;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonColor: '#d33'
            });
        @endif
    });
</script>

