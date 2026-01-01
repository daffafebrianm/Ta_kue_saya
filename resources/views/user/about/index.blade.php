@extends('user.layouts.main')
@section('content')
    <!-- Hero Start -->
    <div class="container-fluid bg-primary hero-header py-4 mb-5">
    </div>

    <!-- Feature Start -->

    <!-- Feature End -->

    <section class="about-section py-3 mb-4" style="background-color: #fff9f0;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Teks -->
                <div class="col-md-6 mb-4 mb-md-0">
                    <h2 class="fw-bold mb-4">Tentang Waroeng koe ree cake & cookies</h2>
                    <p class="text-muted">
                        Pada tahun 2022, Waroeng Koe Ree Cake & Cookies memulai perjalanannya sebagai usaha kuliner rumahan
                        yang didirikan oleh Leni di Muara Bungo, Indonesia. Berlokasi di Jl. H. Al Sudin Pal 2, Bangko Lamo,
                        Pasir Putih, usaha ini lahir dari keinginan untuk menghadirkan aneka kue dan cookies dengan cita
                        rasa berkualitas yang dapat dinikmati oleh berbagai kalangan masyarakat.
                    </p>
                    <p class="text-muted">
                        Sejak awal berdiri, Waroeng Koe Ree Cake & Cookies berkomitmen untuk menggunakan bahan-bahan pilihan
                        yang segar dan berkualitas dalam setiap proses pembuatannya. Leni memastikan bahwa setiap produk
                        yang dihasilkan tidak hanya memiliki rasa yang lezat, tetapi juga dibuat dengan penuh ketelitian dan
                        kebersihan.
                    </p>
                    <p class="text-muted">
                        Melalui konsistensi dalam menjaga kualitas rasa dan pelayanan, Waroeng Koe Ree Cake & Cookies
                        perlahan mendapatkan kepercayaan pelanggan. Hal inilah yang menjadikan usaha ini terus berkembang
                        dan dikenal sebagai salah satu penyedia kue dan cookies yang mengutamakan kualitas serta kepuasan
                        pelanggan di wilayah Muara Bungo dan sekitarnya.
                    </p>
                </div>

                <!-- Gambar -->
                <div class="col-md-6 text-center">
                    <img src="{{ asset('user/assets/images/lokasi2.png') }}" alt="waroeng koe"
                        class="img-fluid rounded-4 shadow-lg" style="width: 20 cm; height: auto;">

                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid py-5 mb-3" style="background-color: #fff9f0;" data-aos="fade-right">
        <div class="container text-center">
            <!-- Feature Items -->
            <div class="row g-4 justify-content-center mb-3">
                <!-- Pet Health -->
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card p-4 h-100 text-center shadow-sm border-0 rounded-4 bg-white">
                        <div class="icon-wrapper mb-3">
                            <img src="{{ asset('user/assets/images/logo-1.png') }}" alt="Pet Health" class="img-fluid"
                                style="max-width: 80px;">
                        </div>
                        <h5 class="fw-bold text-dark">Bahan Fresh</h5>
                        <p class="text-muted mb-0">
                            Bahan-bahan segar untuk rasa autentik setiap hari.
                        </p>
                    </div>
                </div>

                <!-- Grooming -->
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card p-4 h-100 text-center shadow-sm border-0 rounded-4 bg-white">
                        <div class="icon-wrapper mb-3">
                            <img src="{{ asset('user/assets/images/logo-2.png') }}" alt="Grooming" class="img-fluid"
                                style="max-width: 80px;">
                        </div>
                        <h5 class="fw-bold text-dark">Pengalaman</h5>
                        <p class="text-muted mb-0">
                            Outlet yang menarik dan menakjubkan
                        </p>
                    </div>
                </div>

                <!-- Pet Hotel -->
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card p-4 h-100 text-center shadow-sm border-0 rounded-4 bg-white">
                        <div class="icon-wrapper mb-3">
                            <img src="{{ asset('user/assets/images/logo-3.png') }}" alt="Pet Hotel" class="img-fluid"
                                style="max-width: 80px;">
                        </div>
                        <h5 class="fw-bold text-dark">Lezat</h5>
                        <p class="text-muted mb-0">
                            Kelezatan tiada tara, setiap gigitan memikat
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .about-section {
            padding: 80px 0;
            background: #fff9f0;
        }

        .about-img-wrap {
            max-width: 520px;
            /* batas ukuran biar gak kegedean */
            margin-left: auto;
            /* dorong ke kanan biar rapi */
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 18px 40px rgba(16, 24, 40, .12);
        }

        .about-image {
            width: 100%;
            height: 340px;
            /* tinggi konsisten */
            object-fit: cover;
            display: block;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .about-img-wrap {
                max-width: 460px;
                margin: 0 auto;
                /* center kalau layar mengecil */
            }

            .about-image {
                height: 300px;
            }
        }

        @media (max-width: 576px) {
            .about-img-wrap {
                max-width: 100%;
            }

            .about-image {
                height: 220px;
            }
        }
    </style>
@endsection
@section('footer')
    @include('user.partials.footer')
@endsection
