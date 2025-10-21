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
                                    <h4 class="text-center mb-4">Sign up your account</h4>

                                    {{-- Laravel Register Form --}}
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        {{-- Nama --}}
                                        <div class="form-group">
                                            <label><strong>Nama Lengkap</strong></label>
                                            <input type="text"
                                                   class="form-control @error('nama') is-invalid @enderror"
                                                   name="nama"
                                                   value="{{ old('nama') }}"
                                                   placeholder="Nama lengkap" required>
                                            @error('nama')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Username --}}
                                        <div class="form-group">
                                            <label><strong>Username</strong></label>
                                            <input type="text"
                                                   class="form-control @error('username') is-invalid @enderror"
                                                   name="username"
                                                   value="{{ old('username') }}"
                                                   placeholder="username" required>
                                            @error('username')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Email --}}
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   name="email"
                                                   value="{{ old('email') }}"
                                                   placeholder="hello@example.com" required>
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Password --}}
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password"
                                                   placeholder="Password" required>
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Konfirmasi Password --}}
                                        <div class="form-group">
                                            <label><strong>Konfirmasi Password</strong></label>
                                            <input type="password"
                                                   class="form-control"
                                                   name="password_confirmation"
                                                   placeholder="Ulangi Password" required>
                                        </div>

                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                                        </div>
                                    </form>

                                    <div class="new-account mt-3">
                                        <p>Already have an account?
                                            <a class="text-primary" href="{{ route('login') }}">Sign in</a>
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
</body>
@endsection
