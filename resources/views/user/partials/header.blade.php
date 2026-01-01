{{-- Sprite icon biar bisa dipakai di seluruh halaman --}}
<svg xmlns="http://www.w3.org/2000/svg" style="display:none;">
    <symbol id="search" viewBox="0 0 32 32">
        <path fill="currentColor"
            d="M19 3C13.488 3 9 7.488 9 13c0 2.395.84 4.59 2.25 6.313L3.281 27.28l1.439 1.44l7.968-7.969A9.922 9.922 0 0 0 19 23c5.512 0 10-4.488 10-10S24.512 3 19 3zm0 2c4.43 0 8 3.57 8 8s-3.57 8-8 8s-8-3.57-8-8s3.57-8 8-8z" />
    </symbol>
    <symbol id="user" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
    </symbol>
    <symbol id="cart" viewBox="0 0 16 16">
        <path
            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
    </symbol>
</svg>

<header id="header" class="site-header header-scrolled position-fixed text-white w-100 shadow-sm"
    style="background-color: #d4b78e;">
    <nav id="header-nav" class="navbar navbar-expand-lg px-3 mb-3">
        <div class="container">
            {{-- Logo di kiri --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('user/assets/images/logo-kue2.jpg') }}" alt="logo" class="brand-logo">
            </a>



            {{-- Tombol toggle untuk mobile --}}
            <button class="navbar-toggler d-flex d-lg-none order-3 p-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false"
                aria-label="Toggle navigation">
                <svg class="navbar-icon" width="24" height="24">
                    <use xlink:href="#navbar-icon"></use>
                </svg>
            </button>

            {{-- Offcanvas menu --}}
            <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar">
                <div class="offcanvas-header px-4 pb-0">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('user/assets/images/logo-kue2.jpg') }}" alt="logo" class="brand-logo">
                    </a>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>

                <div class="offcanvas-body d-flex align-items-center justify-content-between w-100 ">

                    {{-- Menu Tengah --}}
                    <ul id="navbar"
                        class="navbar-nav text-uppercase justify-content-center align-items-center flex-grow-1 pe-3">
                        <li class="nav-item"><a class="nav-link me-4 active" href="/"
                                style="color:white;">Home</a></li>
                        <li class="nav-item"><a class="nav-link me-4" href="{{ url('/about_us') }}"
                                style="color:white;">About Us</a></li>
                        <li class="nav-item"><a class="nav-link me-4" href="{{ url('/products') }}"
                                style="color:white;">Products</a></li>
                        <li class="nav-item"><a class="nav-link me-4" href="{{ url('/location') }}"
                                style="color:white;">Location</a></li>
                    </ul>

                    {{-- Bagian kanan (User & Cart) --}}
                    <div class="user-items ps-3">
                        <ul class="d-flex justify-content-end align-items-center list-unstyled mb-0" style="gap: 15px;">
                            @auth
                                <li class="dropdown">
                                    <a href="#"
                                        class="dropdown-toggle d-flex align-items-center gap-2 text-decoration-none"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg class="user" width="20" height="20" style="color:white;">
                                            <use xlink:href="#user"></use>
                                        </svg>
                                        <span>{{ Auth::user()->username ?? (Auth::user()->nama ?? Auth::user()->email) }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="/Profile" style="color:black;">Profile</a></li>
                                        <li><a class="dropdown-item" href="/Riwayat-Pesanan" style="color:black;">Riwayat
                                                Pesanan</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="/logout" style="color:black;">Logout</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="{{ route('keranjang.index') }}" class="text-decoration-none">
                                        <svg class="cart" width="24" height="24"
                                            style="cursor:pointer; color:white;">
                                            <use xlink:href="#cart"></use>
                                        </svg>
                                    </a>
                                </li>
                            @endauth

                            @guest
                                <li>
                                    <a href="{{ route('login') }}" class="text-decoration-none d-flex align-items-center">
                                        <svg class="user" width="20" height="20" style="color:white;">
                                            <use xlink:href="#user"></use>
                                        </svg>
                                    </a>
                                </li>
                            @endguest
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </nav>
</header>
<style>
    .brand-logo {
        height: 70px;
        width: auto;
        display: block;
        object-fit: contain;
    }

    /* kalau header kamu fixed, pastikan logo gak ketiban */
    .site-header .navbar-brand {
        padding: 0;
        margin-right: 16px;
    }
</style>
