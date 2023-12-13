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

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row header-color">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start" id="header-icon">
                <div class="me-3">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                        <span class="icon-menu"></span>
                    </button>
                </div>
                <div>
                    @php
                    $sidebarColor = Auth::user()->getWorkerById(session('id_worker'))->company->mobile;
                    $headerColor = Auth::user()->getWorkerById(session('id_worker'))->company->desktop;
                    $logo = Auth::user()->getWorkerById(session('id_worker'))->company->url_image_desktop;
                    if ($logo == null || $logo == 0) {
                    $logo = 'logo/logo.png';
                    }
                    @endphp
                    <a class="navbar-brand brand-logo" href="#">
                        <img src="{{ asset($logo) }}" alt="logo" />
                    </a>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top">
                <ul class="navbar-nav">
                    <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                        <h1 class="welcome-text fw-bold"> @yield('message-primary') </h1>
                        <h3 class="welcome-sub-text fw-bold"> @yield('message-secondary') </h3>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            @php
                            $foto = (Auth::user()->photo) ? Auth::user()->photo : 'default.jpg';
                            @endphp

                            <img class="img-xs rounded-circle" src="{{ asset($foto) }}" alt="Profile image">

                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                                <div class="dropdown-header text-center">
                                    <img class="img-xs rounded-circle" src="{{asset($foto)}}" alt="Profile image">
                                    <p class="mb-1 mt-3 font-weight-semibold">{{Auth::user()->name}}</p>
                                </div>
                                <a class="dropdown-item" href="{{route('perfil')}}"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Mi Perfil </a>
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
        <div class="container-fluid page-body-wrapper" style="background-color: blask !important;">
            <!-- partial:partials/_settings-panel.html -->

            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas " id="sidebar">
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
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                            Copyright © 2023. <a href="https://cerv.com.pe/">CERV</a>.
                        </span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <div class="theme-setting-wrapper ">
        <div id="settings-trigger"><i class="ti-settings"></i></div>
        <div id="theme-settings" class="settings-panel">
            <i class="settings-close ti-close"></i>
            <p class="settings-heading">SIDEBAR SKINS</p>
            <div class="sidebar-bg-options">
                <div class="img-ss rounded-circle bg-light border me-3 select" data-color="light"></div>
                <div class="img-ss rounded-circle bg-black border me-3" data-color="black"></div>
            </div>
            <p class="settings-heading mt-2">HEADER SKINS</p>
            <div class="color-tiles mx-0 px-4">
                <div class="img-ss rounded-circle bg-light border me-3 select" data-color="light"></div>
                <div class="img-ss rounded-circle bg-success border me-3" data-color="success"></div>
                <div class="img-ss rounded-circle bg-warning border me-3" data-color="warning"></div>
                <div class="img-ss rounded-circle bg-black border me-3" data-color="black"></div>
            </div>
        </div>
    </div> <!-- plugins:js -->
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
    @yield('jscontent')
    <!-- Agrega jQuery (asegúrate de que la ruta del archivo sea correcta) -->

    <script>
        var sidebar = @json($headerColor);
        var header = @json($sidebarColor);
        console.log("Color Sidebar:", sidebar);
        console.log("Color Header:", header);

        // Remover la clase "select" de todas las div en el sidebar
        if (sidebar && sidebar !== '') {
            $('.sidebar-bg-options .img-ss').removeClass('select');
            // Seleccionar el color en base a la variable sidebar
            $('.sidebar-bg-options .img-ss[data-color="' + sidebar + '"]').addClass('select');
        }

        // Remover la clase "select" de todas las div en el header
        if (header && header !== '') {
            $('.color-tiles .img-ss').removeClass('select');
            // Seleccionar el color en base a la variable header
            $('.color-tiles .img-ss[data-color="' + header + '"]').addClass('select');
        }


        function setearHeader(color) {
            switch (color) {
                case 'light':
                    $('.navbar').css('background-color', 'white');
                    $('.welcome-text').css('color', 'black');
                    $('.welcome-sub-text').css('color', 'black');
                    break;
                case 'black':
                    $('.navbar').css('background-color', 'black');
                    $('.welcome-text').css('color', 'white');
                    $('.welcome-sub-text').css('color', 'white');
                    break;
                    // Agrega más casos para otros colores si es necesario
                case 'success':
                    $('.navbar').css('background-color', '#4CAF50'); // Verde para "success"
                    $('.welcome-text').css('color', 'white'); // Texto verde para "success"
                    $('.welcome-sub-text').css('color', 'white');
                    break;
                case 'warning':
                    $('.navbar').css('background-color', '#FFC107'); // Amarillo para "warning"
                    $('.welcome-text').css('color', 'black'); // Texto amarillo para "warning"
                    $('.welcome-sub-text').css('color', 'black');
                    break;
                default:
                    $('.navbar').css('background-color', 'white');
                    $('.welcome-text').css('color', 'black');
                    $('.welcome-sub-text').css('color', 'black');
                    break;
            }
        }

        function setearSidebar(color) {
            switch (color) {
                case 'light':
                    $('#header-icon').css('background-color', 'white');
                    $('.icon-menu').css('color', 'black');
                    $('.sidebar').css('background-color', 'white');
                    $('.nav-link').css('color', 'black');
                    $('.menu-icon').each(function() {
                        if (!$(this).parent().parent().hasClass('active')) {
                            $(this).css('color', 'black');
                        }
                    });
                    $('.nav-item').hover(function() {
                        // Verificar si el elemento .nav-item no tiene la clase 'active'
                        if (!$(this).hasClass('active')) {
                            // Cambiar el color de los .menu-icon dentro de él a negro
                            $(this).find('.menu-icon').css('color', 'black');
                        }
                    }, function() {
                        // Cuando se quita el hover, restaurar el color a blanco si no está activo
                        if (!$(this).hasClass('active')) {
                            $(this).find('.menu-icon').css('color', 'black');
                        }
                    });
                    break;
                case 'black':
                    $('#header-icon').css('background-color', 'black');
                    $('.icon-menu').css('color', 'white');
                    $('.sidebar').css('background-color', 'black');
                    $('.nav-link').css('color', 'white');
                    $('.menu-icon').each(function() {
                        if (!$(this).parent().parent().hasClass('active')) {
                            $(this).css('color', 'white');
                        }
                    });
                    $('.nav-item').hover(function() {
                        // Verificar si el elemento .nav-item no tiene la clase 'active'
                        if (!$(this).hasClass('active')) {
                            // Cambiar el color de los .menu-icon dentro de él a negro
                            $(this).find('.menu-icon').css('color', 'black');
                        }
                    }, function() {
                        // Cuando se quita el hover, restaurar el color a blanco si no está activo
                        if (!$(this).hasClass('active')) {
                            $(this).find('.menu-icon').css('color', 'white');
                        }
                    });

                    break;
                default:

                    break;
            }
        }

        // Función para alternar la clase "select" en elementos de la barra lateral (sidebar)
        function toggleSelectSidebar() {
            var elementoSeleccionado = $('.sidebar-bg-options .img-ss.select');

            if (elementoSeleccionado.length > 0) {
                var selectedColor = elementoSeleccionado.data('color');
                console.log("Header", selectedColor);
                setearSidebar(selectedColor);
            }

            $('.sidebar-bg-options .img-ss').on('click', function() {
                $('.sidebar-bg-options .img-ss').removeClass('select');
                $(this).addClass('select');
                var selectedColor = $(this).data('color');
                console.log(selectedColor);
                setearSidebar(selectedColor);
                actualizarColorDesktop(selectedColor);
            });
        }

        // Función para alternar la clase "select" en elementos del encabezado (header)
        function toggleSelectHeader() {
            // Obtén el elemento que ya está seleccionado (tiene la clase "select")
            var elementoSeleccionado = $('.color-tiles .img-ss.select');

            // Verifica si hay un elemento seleccionado
            if (elementoSeleccionado.length > 0) {
                var selectedColor = elementoSeleccionado.data('color');
                console.log("Header", selectedColor);
                setearHeader(selectedColor);
            }

            $('.color-tiles .img-ss').on('click', function() {
                $('.color-tiles .img-ss').removeClass('select');
                $(this).addClass('select');
                var selectedColor = $(this).data('color');
                console.log("Header", selectedColor);
                setearHeader(selectedColor);
                actualizarColorMobile(selectedColor);
            });
        }

        // Ejecutar las funciones respectivas cuando el documento esté listo
        $(document).ready(function() {
            toggleSelectSidebar(); // Para la barra lateral (sidebar)
            toggleSelectHeader(); // Para el encabezado (header)
        });
    </script>
    <script>
        function actualizarColorMobile(color) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: '/administrador/updatecolormobile', // URL directa
                type: 'POST',
                data: {
                    color: color
                },
                success: function(response) {
                    console.log(response);
                    // Realiza aquí las acciones necesarias con la respuesta
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log("Error en la conexión:", xhr.status, thrownError);
                }
            });
        }
    </script>
    <script>
        function actualizarColorDesktop(color) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: '/administrador/updatecolordesktop', // URL directa
                type: 'POST',
                data: {
                    color: color
                },
                success: function(response) {
                    console.log(response);
                    // Realiza aquí las acciones necesarias con la respuesta
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log("Error en la conexión:", xhr.status, thrownError);
                }
            });
        }
    </script>
    <script>
        var rol = @json(Session('id_role'));
        $(document).ready(function() {
            if (rol == 3) {
                $("#settings-trigger").hide();
            }
        });
    </script>

</body>

</html>