<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Focus - Bootstrap Admin Dashboard </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="{{ asset('admin/assets/vendor/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/chartist/css/chartist.min.css') }}"rel="stylesheet ">
    <link href="{{ asset('admin/assets/css/style.css') }}"rel="stylesheet" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


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
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('admin/assets/images/logo.png')}}" >
                <img class="logo-compact" src="{{ asset('admin/assets/images/logo-text.png')}}">
                <img class="brand-title" src="{{ asset('admin/assets/images/logo-text.png')}}">
            </a>

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
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">Quixkit</a> 2019</p>
                <p>Distributed by <a href="https://themewagon.com/" target="_blank">Themewagon</a></p>
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
    <script src="{{ asset('admin/assets/vendor/global/global.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/quixnav-init.js')}}"></script>
    <script src="{{ asset('admin/assets/js/custom.min.js')}}"></script>

    <script src="{{ asset('admin/assets/vendor/chartist/js/chartist.min.js')}}"></script>

    <script src="{{ asset('admin/assets/vendor/moment/moment.min.js')}}"></script>
    <script src="{{ asset('admin/assets/vendor/pg-calendar/js/pignose.calendar.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script src="{{ asset('admin/assets/js/dashboard/dashboard-2.js')}}"></script>
    <!-- Circle progress -->

</body>

</html>
