@extends('user.layouts.main')

@section('content')

<!-- Hero -->
<div class="container-fluid bg-primary hero-header py-4 mb-5"></div>

<!-- Floating WhatsApp -->
<a href="https://api.whatsapp.com/message/LSTUC4YSGLHVL1?autoload=1&app_absent=0&utm_source=ig"
   class="whatsapp-float" target="_blank" aria-label="Chat via WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- ABOUT SECTION -->
<section class="about-modern">
    <div class="container-fluid p-0">

        <!-- ROW 1 : TENTANG KAMI -->
        <div class="row g-0 align-items-center">
            <div class="col-md-6 about-image">
                <img src="{{ asset('user/assets/images/lokasi2.png') }}"
                     alt="Waroeng Koe Ree Cake & Cookies">
            </div>

            <div class="col-md-6 about-content">
                <h2>Tentang Waroeng Koe Ree</h2>
                <span class="about-subtitle">Bakery rumahan sejak 2022</span>

                <p>
                    Waroeng Koe Ree Cake & Cookies didirikan pada tahun 2022 di Muara Bungo
                    sebagai usaha bakery rumahan yang berfokus pada pembuatan roti, kue,
                    dan cookies dengan cita rasa berkualitas.
                </p>

                <p>
                    Kami berkomitmen menggunakan bahan-bahan pilihan serta menerapkan proses
                    pembuatan yang higienis dan teliti, sehingga setiap produk yang dihasilkan
                    memiliki rasa yang konsisten, lezat, dan aman untuk dikonsumsi.
                </p>
            </div>
        </div>

        <!-- ROW 2 : MAKNA LOGO -->
        <div class="row g-0 align-items-center flex-md-row-reverse">
            <div class="col-md-6 logo-wrap">
                <img src="{{ asset('user/assets/images/icon-kue.png') }}"
                     alt="Logo Waroeng Koe Ree">
            </div>

            <div class="col-md-6 about-content">
                <h2>Makna Logo</h2>
                <span class="about-subtitle">Identitas & Filosofi Brand</span>

                <p>
                    Logo Waroeng Koe Ree Cake & Cookies menampilkan ilustrasi kue sebagai
                    simbol utama yang merepresentasikan fokus usaha pada produk roti dan
                    kue berkualitas yang dibuat dengan penuh perhatian terhadap rasa
                    dan tampilan.
                </p>

                <p>
                    Bentuk lingkaran pada logo melambangkan kehangatan, kebersamaan,
                    serta konsistensi, sejalan dengan nilai usaha rumahan yang
                    mengedepankan kedekatan dan kepercayaan pelanggan.
                </p>

                <p>
                    Dominasi warna cokelat dan krem mencerminkan kesan alami,
                    kelezatan, dan kepercayaan, sekaligus menggambarkan penggunaan
                    bahan-bahan pilihan dalam setiap proses pembuatan produk.
                </p>
            </div>
        </div>

    </div>
</section>

<!-- STYLE -->
<style>
.about-modern {
    background: #ffffff;
}

/* IMAGE SECTION */
.about-image {
    background: linear-gradient(135deg, #f7f7f7, #ffffff);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
}

.about-image img {
    width: 100%;
    max-height: 420px;
    object-fit: contain;
    border-radius: 18px;
}

/* CONTENT */
.about-content {
    padding: 90px 80px;
}

.about-content h2 {
    font-size: 34px;
    font-weight: 700;
    margin-bottom: 6px;
    color: #2b2b2b;
}

.about-subtitle {
    display: inline-block;
    font-size: 14px;
    color: #9a6b4f;
    margin-bottom: 26px;
    letter-spacing: .5px;
}

.about-content p {
    font-size: 15px;
    line-height: 1.9;
    color: #555;
    margin-bottom: 18px;
}

/* LOGO SECTION */
.logo-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 420px;
    background: radial-gradient(circle at top, #fff9f0, #f3e4d6);
    padding: 40px;
}

.logo-wrap img {
    max-width: 260px;
    width: 100%;
    background: #ffffff;
    padding: 20px;
    border-radius: 50%;
    box-shadow: 0 20px 40px rgba(0,0,0,.08);
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .about-content {
        padding: 60px 40px;
    }
}

@media (max-width: 768px) {
    .about-content {
        padding: 40px 24px;
        text-align: center;
    }

    .about-image {
        padding: 24px;
    }

    .logo-wrap {
        min-height: 260px;
        padding: 24px;
    }

    .logo-wrap img {
        max-width: 200px;
    }
}
</style>

@endsection

@section('footer')
    @include('user.partials.footer')
@endsection
