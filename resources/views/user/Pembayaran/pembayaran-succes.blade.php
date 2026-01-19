@extends('user.layouts.main')

@section('title', 'Pesanan Berhasil')

@section('content')
    <div class="container py-5">
        <div class="mt-5 row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">

                <!-- Ikon sukses animatif -->
                <div class="success-icon mb-4">
                    <div class="icon-circle d-inline-flex align-items-center justify-content-center">
                        <i class="fas fa-check"></i>
                    </div>
                </div>

                <!-- Judul & Deskripsi -->
                <h1 class="fw-bold mb-3 success-title">Pesanan Berhasil!</h1>
                <p class="success-text mb-5">
                    Terima kasih telah melakukan pembayaran. Pesanan Anda sedang diproses dan akan segera dikirim.
                </p>

                <!-- Tombol CTA -->
                <div class="d-flex gap-3 mb-5 flex-wrap justify-content-center">
                    <a href="{{ route('Riwayat.index') }}"
                        class="btn btn-outline-accent btn-lg rounded-pill px-5 shadow-sm btn-animate">
                        Lihat Pesanan
                    </a>

                    <a href="{{ route('landing') }}" class="btn btn-accent btn-lg rounded-pill px-5 shadow btn-animate">
                        Lanjut Belanja
                    </a>
                </div>


                <!-- Ringkasan Pesanan Modern -->
                <div class="card shadow-sm rounded-5 border-0 p-4 summary-card">
                    <h5 class="mb-4">Ringkasan Pesanan</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Nomor Pesanan:</span>
                        <span class="fw-bold">{{ $order->order_code }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Pembayaran:</span>
                        <span class="fw-bold">Rp {{ number_format($order->totalharga, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Status Pengiriman:</span>
                        @php
                            $status = $order->shipping_status; // misal kolomnya 'shipping_status'
                            $badgeClass = match ($status) {
                                'diproses' => 'bg-warning text-dark',
                                'dikirim' => 'bg-primary text-white',
                                'selesai' => 'bg-success text-white',
                                default => 'bg-secondary text-white',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Confetti JS -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const duration = 2500;
            const animationEnd = Date.now() + duration;
            const defaults = {
                startVelocity: 35,
                spread: 360,
                ticks: 60,
                zIndex: 10,
                colors: ['#4a8a5d', '#71b17d', '#3f6f4d']
            };

            const interval = setInterval(function() {
                const timeLeft = animationEnd - Date.now();
                if (timeLeft <= 0) return clearInterval(interval);

                const particleCount = 60 * (timeLeft / duration);
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: {
                        x: Math.random(),
                        y: Math.random() - 0.2
                    }
                }));
            }, 200);
        });
    </script>

    <style>
/* ===============================
   WARNA & FONT
================================ */
:root {
    --accent-color: #4a8a5d;
    --text-color: #3a3a3a;
    --bg-gradient: linear-gradient(135deg, #f9f7f3 0%, #f0ece6 100%);
}

body {
    background: var(--bg-gradient);
    font-family: 'Poppins', sans-serif;
    overflow-x: hidden;
}

/* ===============================
   IKON SUKSES
================================ */
.icon-circle {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    background-color: var(--accent-color);
    font-size: 3.5rem;
    color: #fff;
    box-shadow: 0 15px 30px rgba(74, 138, 93, 0.3);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    animation: pulse 1.5s infinite;
    transition: transform 0.3s ease;
}

.icon-circle:hover {
    transform: scale(1.2);
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

/* ===============================
   ANIMASI MASUK HALAMAN
================================ */
.success-title,
.success-text,
.icon-circle,
.btn,
.summary-card {
    opacity: 0;
    animation: fadeInUp 0.8s ease forwards;
}

.success-title {
    animation-delay: 0.2s;
    font-size: 2.5rem;
    color: var(--accent-color);
    font-weight: 600;
}

.success-text {
    animation-delay: 0.4s;
    font-size: 1.15rem;
    color: var(--text-color);
}

.icon-circle {
    animation-delay: 0s;
}

.summary-card {
    animation-delay: 0.6s;
}

@keyframes fadeInUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* ===============================
   TOMBOL OUTLINE (LIHAT PESANAN)
================================ */
.btn-outline-accent {
    border: 2px solid var(--accent-color);
    color: var(--accent-color);
    background-color: transparent;
    font-size: 1.1rem;
    transition:
        transform 0.22s cubic-bezier(.4, 0, .2, 1),
        box-shadow 0.22s cubic-bezier(.4, 0, .2, 1),
        background-color 0.3s ease,
        color 0.3s ease;
    outline: none;
    box-shadow: none;
}

/* Hover naik lembut */
.btn-outline-accent:hover,
.btn-outline-accent:focus {
    background-color: var(--accent-color);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(74, 138, 93, 0.35);
}

/* Active ditekan */
.btn-outline-accent:active {
    transform: scale(0.96);
    box-shadow: 0 6px 16px rgba(74, 138, 93, 0.25);
}

/* ===============================
   TOMBOL AKSEN (LANJUT BELANJA)
================================ */
/* Kunci warna (anti biru bootstrap) */
.btn-accent,
.btn-accent:hover,
.btn-accent:focus,
.btn-accent:active {
    background-color: var(--accent-color) !important;
    color: #fff !important;
}

/* Animasi tombol utama */
.btn-accent {
    position: relative;
    overflow: hidden;
    font-size: 1.1rem;
    transition:
        transform 0.22s cubic-bezier(.4, 0, .2, 1),
        box-shadow 0.22s cubic-bezier(.4, 0, .2, 1);
    box-shadow: 0 8px 24px rgba(74, 138, 93, 0.35);
}

/* Hover floating */
.btn-accent:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 40px rgba(74, 138, 93, 0.55);
}

/* Active ditekan */
.btn-accent:active {
    transform: scale(0.96);
    box-shadow: 0 8px 18px rgba(74, 138, 93, 0.35);
}

/* ===============================
   CARD RINGKASAN
================================ */
.summary-card {
    background: #fff;
    border-radius: 1.5rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.summary-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
}

.summary-card h5 {
    color: var(--accent-color);
    font-weight: 600;
}

.summary-card span {
    color: var(--text-color);
}

/* ===============================
   BADGE
================================ */
.badge {
    padding: 0.5em 0.75em;
    font-size: 0.95rem;
    border-radius: 0.75rem;
}
</style>

@endsection
