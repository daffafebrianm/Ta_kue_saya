@extends('auth.main')

@section('content')

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
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        id="togglePassword">
                                                        Lihat
                                                    </button>
                                                </div>

                                                @error('password')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                            <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                                <div class="form-group">
                                                    <div class="form-check ml-2">
                                                        <input class="form-check-input" type="checkbox" name="remember"
                                                            id="remember">
                                                        <label class="form-check-label" for="remember">Remember me</label>
                                                    </div>
                                                </div>
                                                @if (Route::has('password.request'))
                                                    <div class="form-group">
                                                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                                                    </div>
                                                @endif
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

                if (btn && pwd) {
                    btn.addEventListener('click', function() {
                        const isHidden = pwd.type === 'password';
                        pwd.type = isHidden ? 'text' : 'password';
                        btn.textContent = isHidden ? 'Sembunyikan' : 'Lihat';
                    });
                }
            });
        </script>

    </body>
@endsection
