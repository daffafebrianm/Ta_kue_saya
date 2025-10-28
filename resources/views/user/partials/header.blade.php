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
    <symbol id="chevron-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd"
            d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 1 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
    </symbol>
    <symbol id="chevron-right" viewBox="0 0 16 16">
        <path fill-rule="evenodd"
            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354z" />
    </symbol>
    <symbol id="cart-outline" viewBox="0 0 16 16">
        <path
            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
    </symbol>
    {{-- Tambahkan symbol lain jika diperlukan --}}
</svg>

{{-- Search popup (opsional) --}}
<div class="search-popup">
    <div class="search-popup-container">
        <form role="search" method="get" class="search-form" action="#">
            <input type="search" id="search-form" class="search-field" placeholder="Type and press enter"
                name="s" />
            <button type="submit" class="search-submit">
                <svg class="search">
                    <use xlink:href="#search"></use>
                </svg>
            </button>
        </form>
    </div>
</div>

<header id="header" class="site-header header-scrolled position-fixed text-black bg-light w-100">
    <nav id="header-nav" class="navbar navbar-expand-lg px-3 mb-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('user/assets/images/main-logo.png') }}" class="logo" alt="logo">
            </a>

            <button class="navbar-toggler d-flex d-lg-none order-3 p-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false"
                aria-label="Toggle navigation">
                <svg class="navbar-icon">
                    <use xlink:href="#navbar-icon"></use>
                </svg>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar">
                <div class="offcanvas-header px-4 pb-0">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('user/assets/images/main-logo.png') }}" class="logo" alt="logo">
                    </a>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    <ul id="navbar"
                        class="navbar-nav text-uppercase justify-content-end align-items-center flex-grow-1 pe-3">
                        <li class="nav-item"><a class="nav-link me-4 active" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link me-4" href="{{ url('/about_us') }}">About us</a></li>
                        {{-- agar selalu menuju section produk di home --}}
                        <li class="nav-item"><a class="nav-link me-4"
                                href="{{ url('/products') }}">Products</a></li>
                        <li class="nav-item"><a class="nav-link me-4" href="{{ url('/contact') }}">Contact</a></li>

                        @guest
                            <li class="nav-item"><a class="nav-link me-4" href="{{ route('login') }}">Login</a></li>
                            <li class="nav-item"><a class="nav-link me-4" href="{{ route('register') }}">Register</a></li>
                        @else
                            {{-- contoh: tampilkan nama singkat --}}
                            <li class="nav-item"><span
                                    class="nav-link me-4">{{ Str::limit(auth()->user()->name, 14) }}</span></li>
                        @endguest

                        <li class="nav-item">
                            <div class="user-items ps-5">
                                <ul class="d-flex justify-content-end list-unstyled">

                                    <li class="pe-3 dropdown">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <svg class="user">
                                                <use xlink:href="#user"></use>
                                            </svg>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Profile</a></li>
                                            <li><a class="dropdown-item" href="#">Settings</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="{{ route('keranjang.index') }}">
                                            <svg class="cart">
                                                <use xlink:href="#cart"></use>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
