{{-- resources/views/user/layouts/main.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title', 'Waroeng koe')</title>

    {{-- Core CSS --}}
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('user/assets/images/icon-kue.png') }}">
    <link rel="stylesheet" href="{{ asset('user/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/assets/style.css') }}">
    {{-- Swiper (dipakai oleh billboard/products jika halaman menggunakannya) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    {{-- Page-level styles --}}
    @stack('styles')
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-smooth-scroll="true" tabindex="0">

    {{-- ===== HEADER (ikon SVG + navbar) ===== --}}
    @include('user.partials.header')

    {{-- ===== SECTION OPSIONAL (hanya dirender bila halaman mengisinya) ===== --}}
    @hasSection('billboard')
        @yield('billboard')
    @endif

    @hasSection('products')
        @yield('products')
    @endif

    @hasSection('about_us')
        @yield('about_us')
    @endif
    {{-- ===== KONTEN UTAMA HALAMAN ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER OPSIONAL (biar fleksibel per halaman) ===== --}}
    @hasSection('footer')
        @yield('footer')
    @endif

    @hasSection('keranjang')
        @yield('keranjang')
    @endif
    @hasSection('checkout')
        @yield('checkout')
    @endif


    @hasSection('location')
        @yield('location')
    @endif

    {{-- ===== JS CORE ===== --}}
    <script src="{{ asset('user/assets/js/jquery-1.11.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('user/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('user/assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== Session flash notifications =====
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1800
        });
    @endif

    @if(session('deleted'))
        Swal.fire({
            icon: 'success',
            title: 'Terhapus!',
            text: '{{ session('deleted') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1800
        });
    @endif

    @if($errors->any())
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
    @stack('scripts')

</body>

</html>
