{{-- resources/views/user/layouts/main.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Waroeng koe')</title>

    {{-- Core CSS --}}
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

    {{-- ===== KONTEN UTAMA HALAMAN ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER OPSIONAL (biar fleksibel per halaman) ===== --}}
    @hasSection('footer')
        @yield('footer')
    @endif

    {{-- ===== JS CORE ===== --}}
    <script src="{{ asset('user/assets/js/jquery-1.11.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('user/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('user/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('user/assets/js/script.js') }}"></script>

    {{-- Page-level scripts --}}
    @stack('scripts')
    {{-- Toast container --}}
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
        <div id="cartToast" class="toast align-items-center text-bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="cartToastBody">
                    Produk berhasil ditambahkan ke keranjang
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const forms = document.querySelectorAll('.add-to-cart-form');
            const toastEl = document.getElementById('cartToast');
            const toastBody = document.getElementById('cartToastBody');
            const CartToast = toastEl ? new bootstrap.Toast(toastEl, {
                delay: 1800
            }) : null;

            forms.forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    // kirim AJAX
                    try {
                        const res = await fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': this.querySelector('input[name=_token]')
                                    .value,
                                'Accept': 'application/json'
                            },
                            body: new FormData(this)
                        });

                        if (!res.ok) throw new Error('Request failed');
                        const data = await res.json();

                        if (data && data.ok) {
                            if (CartToast) {
                                toastBody.textContent = this.dataset.success || data.message ||
                                    'Ditambahkan ke keranjang';
                                CartToast.show();
                            }
                        } else {
                            throw new Error('Bad response');
                        }
                    } catch (err) {
                        // fallback: kalau AJAX gagal, submit normal (redirect)
                        this.submit();
                    }
                }, {
                    once: false
                });
            });
        })();
    </script>
</body>

</html>
