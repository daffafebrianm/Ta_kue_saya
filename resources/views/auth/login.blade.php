@extends('auth.main')

@section('content')

<style>
    .input-group {
        width: 100%; /* Membuat input group menggunakan seluruh lebar */
    }

    .input-group .form-control {
        border-right: 0; /* Menghilangkan border kanan pada input */
    }



    .input-group .form-control,
    .input-group .btn {
        height: calc(2.25rem + 2px); /* Menyelaraskan tinggi input dan tombol */
    }

    .input-group .fa-eye,
    .input-group .fa-eye-slash {
        font-size: 1.25rem; /* Ukuran ikon yang sesuai */
    }
</style>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign in to your account</h4>

                                    {{-- ALERT ERROR GLOBAL --}}
                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    @error('login')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                    {{-- Form Login --}}
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label><strong>Email/Username</strong></label>
                                            <input type="text"
                                                class="form-control @error('login') is-invalid @enderror" name="login"
                                                value="{{ old('login') }}" required autofocus>
                                            @error('login')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <div class="input-group">
                                                <input type="password" id="password" name="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    required autocomplete="current-password">

                                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                                </button>
                                            </div>

                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign me in</button>
                                        </div>
                                    </form>

                                    <div class="new-account mt-3">
                                        <p>Don't have an account?
                                            <a class="text-primary" href="{{ route('register') }}">Sign up</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pwd = document.getElementById('password');
            const btn = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            if (btn && pwd && eyeIcon) {
                btn.addEventListener('click', function() {
                    const isHidden = pwd.type === 'password';
                    pwd.type = isHidden ? 'text' : 'password';
                    // Mengubah ikon sesuai dengan status password
                    eyeIcon.classList.toggle('fa-eye-slash', !isHidden); // Ganti ke mata terbalik jika password terlihat
                    eyeIcon.classList.toggle('fa-eye', isHidden); // Kembali ke mata terbuka jika password tersembunyi
                });
            }
        });
    </script>
</body>

@endsection
