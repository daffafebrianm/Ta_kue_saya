@extends('user.layouts.main')

@section('content')
    <!-- Floating WhatsApp Button -->
    <a href="https://api.whatsapp.com/message/LSTUC4YSGLHVL1?autoload=1&app_absent=0&utm_source=ig" class="whatsapp-float"
        target="_blank" aria-label="Chat via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    <div class="container-fluid bg-primary hero-header py-4 mb-3"></div>

    <div class="container-fluid py-5 mb-3" style="background-color:#fff9f0;" data-aos="fade-right">
        <div class="container">

            <div class="text-center mb-5">
                <h2 class="fw-bold"
                    style="color:#b78b6f; font-family: Georgia, 'Times New Roman', serif; font-style: italic;">
                    Our Store
                </h2>
                <p class="text-muted">Kunjungi toko kami dan nikmati berbagai pilihan kue lezat setiap hari 🍰</p>
            </div>

            <div class="row g-0 shadow rounded-4 overflow-hidden bg-white">
                <!-- Info Toko -->
                <div class="col-lg-4 d-flex flex-column justify-content-center align-items-start p-4"
                    style="background:#e0c2a2; color:#fff;">
                    <h4 class="fw-bold mb-3" style="color:#fffaf5;">Waroeng Koe Ree Cake & Cookies</h4>

                    <p class="mb-2" style="font-size:15px; color:#fffaf5;">
                        📍 G447+F6R, Pasir Putih, Kec. Rimbo Tengah,<br>
                        Kabupaten Bungo, Jambi 37211
                    </p>
                    <p class="mb-2" style="font-size:14px; color:#fffaf5;">
                        🕒 Buka setiap hari: 08.00 – 21.00
                    </p>
                    <p class="mb-4" style="font-size:14px; color:#fffaf5;">
                        ☎️ Telepon: 0821-4567-8901
                    </p>

                    <a href="https://www.google.com/maps?q=-1.495591,102.112104" target="_blank"
                        class="btn rounded-pill fw-semibold shadow-sm"
                        style="background:#fff; color:#b78b6f; font-size:14px; padding:10px 20px; transition:0.3s;">
                        📍 Lihat di Google Maps
                    </a>
                </div>

                <!-- Map -->
                <div class="col-lg-8">
                    <div id="map" style="width:100%; height:560px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('user.partials.footer')
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        /* Warna latar belakang lembut */
        body {
            background-color: #fff9f0;
        }

        /* Map dengan bayangan */
        #map {
            border-left: 2px solid #f3e1cf;
            filter: saturate(1.2) contrast(1.05);
        }

        /* Tombol hover efek */
        .btn:hover {
            background: #b78b6f !important;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(183, 139, 111, 0.3);
            transform: translateY(-2px);
        }

        /* Responsif */
        @media (max-width: 768px) {
            .col-lg-4 {
                text-align: center;
                align-items: center !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-1.495591, 102.112104], 15);

        // Tema peta yang lebih lembut
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Marker dan popup
        const popupHtml = `
        <div style="min-width:230px;">
            <h6 style="font-weight:700; color:#b78b6f;">Waroeng Koe Ree Cake & Cookies</h6>
            <p style="font-size:13px; color:#444;">G447+F6R, Pasir Putih, Kec. Rimbo Tengah,<br>Kabupaten Bungo, Jambi 37211</p>
            <p style="font-size:12px; color:#666;">🕒 08.00 – 21.00</p>
            <a href="https://www.google.com/maps?q=-1.495591,102.112104" target="_blank"
               style="font-size:12px; color:#b78b6f; text-decoration:underline;">📍 Buka di Google Maps</a>
        </div>
    `;

        const marker = L.marker([-1.495591, 102.112104]).addTo(map).bindPopup(popupHtml).openPopup();
    </script>
@endpush
