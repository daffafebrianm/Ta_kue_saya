@extends('auth.main')

@section('content')

    <style>
        /* ===== Layout utama ===== */
        .authincation.h-100 {
            min-height: 100vh;
        }

        .bg-border {
            position: relative;
            min-height: 100vh;
            background: #FFF6EA;
            overflow: hidden;
        }

        /* Ornamen di bagian atas dan bawah */
        .bg-border::before,
        .bg-border::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            height: 160px;
            /* tinggi area ornamen */
            background-image: url('{{ asset('images/bg-login1.jpg') }}');
            background-repeat: repeat-x;
            /* diulang ke kanan */
            background-size: auto 160px;
            /* biar proporsional, tidak pecah */
            background-position: center;
            pointer-events: none;
            opacity: 0.95;
        }

        /* Atas */
        .bg-border::before {
            top: 0;
        }

        /* Bawah (dibalik agar simetris) */
        .bg-border::after {
            bottom: 0;
            transform: scaleY(-1);
        }

        /* pastikan card berada di atas background */
        .register-card {
            position: relative;
            width: 100%;
            max-width: 560px;
            background: #FFF6EA;
            border-radius: 14px;
            box-shadow: 0 14px 32px rgba(0, 0, 0, .08);
            padding: 36px 40px;
            margin: 100px auto;
            /* beri jarak dari atas dan bawah */
            overflow: hidden;
            z-index: 1;
        }

        /* Background kecil di dalam card sisi kiri & kanan */
        .register-card::before,
        .register-card::after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            width: 80px;
            background-repeat: repeat-y;
            background-size: 80px auto;
            background-position: center;
            opacity: 0.35;
            pointer-events: none;
        }

        .register-card::before {
            left: 0;
        }

        .register-card::after {
            right: 0;
            transform: scaleX(-1);
        }

        /* ===== Form ===== */
        .register-title {
            text-transform: uppercase;
            letter-spacing: 0.15em;
            font-weight: 700;
            text-align: center;
            color: #1A2A33;
            margin-bottom: 24px;
        }

        .form-control {
            height: 48px;
            border-radius: 10px;
            border: 1px solid #E6E6E6;
            background: #fff;
            padding: 0 16px;
        }

        .form-control:focus {
            border-color: #CBB7F2;
            box-shadow: 0 0 0 3px rgba(111, 60, 195, .12);
        }

        ::placeholder {
            color: #9FA6B2;
        }

        .btn-register {
            width: 100%;
            height: 50px;
            border-radius: 10px;
            background: #d8ae73;
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border: 0;
        }

        .btn-register:hover {
            background: #d8ae73;
        }

        .new-account {
            text-align: center;
            margin-top: 18px;
            color: #6b7280;
        }

        .new-account a {
            color: #d8ae73;
            font-weight: 700;
            text-decoration: none;
        }

        .new-account a:hover {
            text-decoration: underline;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <body class="h-100">
        <div class="authincation h-100 bg-border">
            <div class="container-fluid h-100">
                <div class="row justify-content-center h-100 align-items-center">
                    <div class="col-md-6">
                        <div class="register-card">
                            <h4 class="register-title">Sign Up</h4>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $e)
                                            <li>{{ $e }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group mb-3">
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Lengkap"
                                        value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror" placeholder="Username"
                                        value="{{ old('username') }}" required>
                                    @error('username')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input type="number" name="phone_number"
                                        class="form-control @error('phone_number') is-invalid @enderror"
                                        placeholder="Nomor Telepon" value="{{ old('phone_number') }}" required>
                                    @error('phone_number')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3 position-relative">
                                    <input type="password" name="password"
                                        class="form-control pe-5 @error('password') is-invalid @enderror" id="password"
                                        placeholder="Password" required>
                                    <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y pe-3"
                                        style="cursor: pointer;" onclick="togglePassword('password', this)"></i>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-4 position-relative">
                                    <input type="password" name="password_confirmation" class="form-control pe-5"
                                        id="password_confirmation" placeholder="Ulangi Password" required>
                                    <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y pe-3"
                                        style="cursor: pointer;"
                                        onclick="togglePassword('password_confirmation', this)"></i>
                                </div>

                                <button type="submit" class="btn-register">Sign me up</button>
                            </form>

                            <div class="new-account">
                                <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script>
        function togglePassword(id, icon) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }
    </script>

@endsection
