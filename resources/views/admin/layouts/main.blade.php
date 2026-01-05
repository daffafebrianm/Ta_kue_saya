<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Waroeng Kue</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('user/assets/images/icon-kue.png') }}">
    <link href="{{ asset('admin/assets/vendor/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/chartist/css/chartist.min.css') }}"rel="stylesheet ">
    <link href="{{ asset('admin/assets/css/style.css') }}"rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">




</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        @include('admin.layouts.navbar')
        @include('admin.layouts.sidebar')

        <div class="content-body">
            <div class="container-fluid">
                @yield('content')

            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
<div class="footer">
    <div class="copyright text-center">
        <p class="mb-1">
            © {{ date('Y') }} <span class="fw-semibold">Waroeng Koe Ree Cake & Cookies</span>. All rights reserved.
        </p>
        <p class="mb-0 text-muted" style="font-size: 0.9rem;">
            Designed & Developed by <span class="fw-semibold">Daffa Febrian Mukthar</span>
        </p>
    </div>
</div>


        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('admin/assets/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom.min.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/chartist/js/chartist.min.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/pg-calendar/js/pignose.calendar.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- BEFORE </body>: Choices JS -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script src="{{ asset('admin/assets/js/dashboard/dashboard-2.js') }}"></script>
    <!-- Circle progress -->

</body>

</html>
