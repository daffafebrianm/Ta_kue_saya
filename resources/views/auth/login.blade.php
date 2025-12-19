@extends('auth.main')

@section('content')
    <style>
        /* ----- Layout & Card ----- */
        .authincation.h-100 {
            min-height: 100vh;
        }

        .login-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 40px);
            padding: 24px;
        }

        .login-card {
            width: 100%;
            max-width: 520px;
            background: #FFF6EA;
            /* krem lembut seperti contoh */
            border-radius: 14px;
            box-shadow: 0 14px 32px rgba(0, 0, 0, .08);
            padding: 36px 40px;
        }




        .bg-border {
            position: relative;
            min-height: 100vh;
            background: #FFF6EA;
            overflow: hidden;
        }

        .bg-border::before,
        .bg-border::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            height: 160px;
            background-image: url('{{ asset('images/bg-login1.jpg') }}');
            background-repeat: repeat-x;
            background-size: auto 160px;
            pointer-events: none;
        }

        .bg-border::before {
            top: 0;
        }

        .bg-border::after {
            bottom: 0;
            transform: scaleY(-1);
        }


        /* ----- Heading ----- */
        .login-title {
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            text-align: center;
            color: #1A2A33;
            margin-bottom: 26px;
            font-size: 24px;
        }

        /* ----- Form ----- */
        .form-control {
            height: 48px;
            border-radius: 10px;
            border: 1px solid #E6E6E6;
            background: #fff;
            box-shadow: none;
            padding-left: 16px;
            padding-right: 16px;
        }

        .form-control:focus {
            border-color: #CBB7F2;
            outline: 0;
            box-shadow: 0 0 0 3px rgba(111, 60, 195, .12);
        }

        ::placeholder {
            color: #9FA6B2;
        }

        /* group untuk tombol eye */
        .input-group {
            width: 100%;
        }

        .input-group .form-control {
            border-right: 0;
        }

        .input-group .btn {
            height: 48px;
            border: 1px solid #E6E6E6;
            border-left: 0;
            background: #fff;
            color: #6b7280;
            border-radius: 0 10px 10px 0;
        }

        .input-group .fa-eye,
        .input-group .fa-eye-slash {
            font-size: 1.1rem;
        }

        /* ----- Button ----- */
        .btn-login {
            display: block;
            width: 100%;
            height: 50px;
            background: #d8ae73;
            border: 0;
            border-radius: 10px;
            color: #fff;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .btn-login:hover,
        .btn-login:focus {
            background: #e6a242;
            color: #fff;
        }

        /* ----- Footer link ----- */
        .new-account {
            text-align: center;
            margin-top: 18px;
            color: #6b7280;
        }

        .new-account a {
            color: #e6a242;
            font-weight: 700;
            text-decoration: none;
        }

        .new-account a:hover {
            text-decoration: underline;
        }

        /* kecilkan label agar tak mengganggu (aksesibilitas tetap ada) */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
    </style>

    <div class="authincation h-100 bg-border">
        <div class="authincation h-100 bg-login">
            <div class="container-fluid h-100">
                <div class="login-wrap">
                    <div class="login-card">
                        <h2 class="login-title">Sign In</h2>

                        {{-- ALERTS --}}
                        @if (session('success'))
                            <div class="alert alert-success mb-3">{{ session('success') }}</div>
                        @endif
                        @error('login')
                            <div class="alert alert-danger mb-3">{{ $message }}</div>
                        @enderror

                        {{-- FORM LOGIN --}}
                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf

                            <div class="form-group mb-3">
                                <label class="sr-only" for="login">Email/Username</label>
                                <input id="login" type="text" name="login"
                                    class="form-control @error('login') is-invalid @enderror" value="{{ old('login') }}"
                                    placeholder="Email" required autofocus>
                                @error('login')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="sr-only" for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                        required autocomplete="current-password">
                                    <button type="button" class="btn" id="togglePassword"
                                        aria-label="Toggle password visibility">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn-login">Login</button>
                        </form>

                        <div class="new-account">
                            <p>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Toggle password --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pwd = document.getElementById('password');
            const btn = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            if (btn && pwd && eyeIcon) {
                btn.addEventListener('click', function() {
                    const isHidden = pwd.type === 'password';
                    pwd.type = isHidden ? 'text' : 'password';
                    eyeIcon.classList.toggle('fa-eye-slash', isHidden);
                    eyeIcon.classList.toggle('fa-eye', !isHidden);
                });
            }
        });
    </script>
@endsection
