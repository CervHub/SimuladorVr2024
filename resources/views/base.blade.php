<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> @yield('title') </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('template/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('template/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('template/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('template/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('template/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('template/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('template/js/select.dataTables.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('template/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('logo/logo-icon.svg')}}" />
    @yield('css')
    @yield('js-begin')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="sidebar-dark">
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar bg-black default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row ">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start bg-black">
                <div class="me-3">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                        <span class="icon-menu text-white"></span>
                    </button>
                </div>
                <div>
                    <a class="navbar-brand brand-logo" href="index.html">
                        <img src="{{asset('logo/logo.png')}}" alt="logo" />
                    </a>

                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top bg-black">
                <ul class="navbar-nav">
                    <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                        <h1 class="welcome-text"> @yield('message-primary') </h1>
                        <h3 class="welcome-sub-text"> @yield('message-secondary') </h3>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="img-xs rounded-circle" src="{{asset('template/images/faces/face8.jpg')}}" alt="Profile image"> </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <div class="dropdown-header text-center">
                                <img class="img-md rounded-circle" src="{{asset('template/images/faces/face8.jpg')}}" alt="Profile image">
                                <p class="mb-1 mt-3 font-weight-semibold">{{Auth::user()->name}}</p>
                            </div>
                            <a class="dropdown-item" href="{{route('perfil')}}" ><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Mi Perfil </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Cerrar sesión
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->

            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas bg-black" id="sidebar">
                @yield('sidebar')
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block"></span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2023. CERV.</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{asset('template/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('template/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('template/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('template/vendors/progressbar.js/progressbar.min.js')}}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('template/js/off-canvas.js')}}"></script>
    <script src="{{asset('template/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('template/js/template.js')}}"></script>
    <script src="{{asset('template/js/settings.js')}}"></script>
    <script src="{{asset('template/js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{asset('template/js/dashboard.js')}}"></script>
    <script src="{{asset('template/js/Chart.roundedBarCharts.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- End custom js for this page-->
    @yield('js')
</body>

</html>