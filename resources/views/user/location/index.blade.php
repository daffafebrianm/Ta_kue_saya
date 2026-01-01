@extends('user.layouts.main')

@section('content')
    <!-- Hero Start -->
    <div class="container-fluid bg-primary hero-header py-4 mb-3"></div>
    <!-- Hero End -->

    <!-- Stores Start -->
    <div class="container-fluid py-5 mb-3" style="background-color:#fff9f0;" data-aos="fade-right">
        <div class="container">

            <div class="text-center mb-4">
                <h2 class="fw-bold"
                    style="color:#b78b6f; font-family: Georgia, 'Times New Roman', serif; font-style: italic;">
                    Our Stores
                </h2>
            </div>

            <div class="row g-0 shadow-sm rounded-4 overflow-hidden" style="min-height: 560px; background:#fff;">
                <!-- Sidebar (dihapus bagian pencarian) -->
                <div class="col-lg-4" style="background:#b78b6f;">
                    <div class="p-3 border-bottom" style="border-color: rgba(255,255,255,.15) !important;">
                    </div>

                    <div id="storeList" style="height: 500px; overflow:auto;"></div>
                </div>

                <!-- Map -->
                <div class="col-lg-8">
                    <div id="map" style="width:100%; height:560px;"></div>
                </div>
            </div>

        </div>
    </div>
    <!-- Stores End -->
@endsection

@section('footer')
    @include('user.partials.footer')
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        /* Styling item list */
        .store-item {
            padding: 16px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
            cursor: pointer;
            color: #fff;
        }

        .store-item h5 {
            margin: 0 0 6px;
            font-weight: 700;
        }

        .store-item .addr {
            font-size: 13px;
            opacity: .95;
            line-height: 1.35;
        }

        .store-item .hours {
            font-size: 12px;
            opacity: .85;
            margin-top: 6px;
        }

        .store-item.active {
            background: rgba(255, 255, 255, .16);
            outline: 2px solid rgba(255, 255, 255, .22);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        const storeListEl = document.getElementById('storeList');

        // Inisialisasi map dengan koordinat yang diinginkan (-1.495591, 102.112104)
        const map = L.map('map').setView([-1.495591, 102.112104], 12); // Koordinat baru

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const markersLayer = L.layerGroup().addTo(map);
        const markerById = new Map(); // storeId -> marker
        let stores = [];

        function escapeHtml(str) {
            return String(str ?? ' ')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", "&#039;");
        }

        function formatHours(open_at, close_at) {
            if (!open_at || !close_at) return '';
            // open_at bisa "09:00:00", kita ambil "09:00"
            const o = open_at.slice(0, 5);
            const c = close_at.slice(0, 5);
            return `Buka dari ${o} - ${c}`;
        }

        function setActive(id) {
            document.querySelectorAll('.store-item').forEach(el => el.classList.remove('active'));
            const active = document.querySelector(`.store-item[data-id="${id}"]`);
            if (active) {
                active.classList.add('active');
                active.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }
        }

        function renderList(data) {
            if (!data.length) {
                storeListEl.innerHTML = `<div class="p-4 text-white-50">Tidak ada store yang cocok.</div>`;
                return;
            }

            storeListEl.innerHTML = data.map(s => {
                const hours = formatHours(s.open_at, s.close_at);
                return `
                    <div class="store-item" data-id="${s.id}">
                        <h5>${escapeHtml(s.name)}</h5>
                        <div class="addr">${escapeHtml(s.address)}</div>
                        ${hours ? `<div class="hours">${escapeHtml(hours)}</div>` : ''}
                    </div>
                `;
            }).join('');

            // klik item -> fokus map + buka popup
            storeListEl.querySelectorAll('.store-item').forEach(item => {
                item.addEventListener('click', () => {
                    const id = Number(item.dataset.id);
                    const marker = markerById.get(id);
                    if (marker) {
                        setActive(id);
                        map.setView(marker.getLatLng(), 15, {
                            animate: true
                        });
                        marker.openPopup();
                    }
                });
            });
        }

        function renderMarkers(data) {
            markersLayer.clearLayers();
            markerById.clear();

            if (!data.length) return;

            const bounds = [];

            data.forEach(s => {
                const popupHtml = `
                    <div style="min-width:220px">
                        <div style="font-weight:700; color:#7b4b78; font-size:16px; margin-bottom:4px;">
                            ${escapeHtml(s.name)}
                        </div>
                        <div style="font-size:13px; color:#444;">
                            ${escapeHtml(s.address)}
                        </div>
                        <div style="font-size:12px; color:#666; margin-top:6px;">
                            Klik marker untuk info detail
                        </div>
                    </div>
                `;

                const marker = L.marker([s.lat, s.lng]).bindPopup(popupHtml);
                marker.on('click', () => setActive(s.id));

                marker.addTo(markersLayer);
                markerById.set(s.id, marker);
                bounds.push([s.lat, s.lng]);
            });

            // fit bounds (biar semua marker kelihatan)
            if (bounds.length === 1) {
                map.setView(bounds[0], 15);
            } else {
                map.fitBounds(bounds, {
                    padding: [30, 30]
                });
            }
        }

        // initial load
        loadStores('');
    </script>
@endpush
