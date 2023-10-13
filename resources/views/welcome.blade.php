<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Cerv</title>
    <link rel="stylesheet" href="{{asset('template/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('template/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('template/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('template/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('template/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('template/css/vertical-layout-light/style.css')}}">
    <link rel="shortcut icon" href="{{asset('logo/logo-icon.svg')}}" />
    <style>
        .content-wrapper {
            background-image: url('{{asset('logo/fondo.jpg')}}');
            background-size: auto;
            background-repeat: no-repeat;
        }

        .auth .auth-form-light {
            background-color: rgba(255, 255, 255, 0.05);
            /* Fondo transparente al 50% */
            padding: 20px;
            /* Ajusta el espaciado según tus necesidades */
            border-radius: 10px;
            /* Ajusta el redondeo de los bordes según tus necesidades */
        }

        .form-group .form-control {
            border-radius: 10px;
        }

        .btn-custom {
            background-color: blue;
        }
        .alert {
            margin-top: 5px;
    border-radius: 25px;
    background-color: rgba(255, 0, 0, 0.5); /* Un rojo semi-transparente */
    /* Otra propiedad de estilo para las alertas */
    border: 0;
}

    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo text-center">
                                <img src="{{asset('logo/logo.png')}}" alt="logo">
                            </div>
                            <h4 class=" text-white">¡Hola! empecemos.</h4>
                            <h6 class="fw-light text-white">Inicia sesión para continuar.</h6>
                            @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                            @endif

                            @if (Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                            @endif

                            <form class="pt-3" method="POST" action="{{route('loginSubmit')}}">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label text-white">Codigo de trabajador:</label>
                                    <input type="text" name="code_worker" class="form-control form-control-lg rounded text-white" id="exampleInputEmail1" placeholder="Ingresa el código">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label text-white">Contraseña:</label>
                                    <input type="password" name="password" class="form-control form-control-lg rounded text-white" id="exampleInputPassword1" placeholder="Ingresa la contraseña">
                                </div>
                                <div class="mt-3 text-center">
                                    <button class="btn btn-block btn-primary btn-sm font-weight-medium auth-form-btn btn-custom" type="submit">Iniciar sesión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{asset('template/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('template/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('template/js/off-canvas.js')}}"></script>
    <script src="{{asset('template/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('template/js/template.js')}}"></script>
    <script src="{{asset('template/js/settings.js')}}"></script>
    <script src="{{asset('template/js/todolist.js')}}"></script>
    <!-- endinject -->
</body>

</html>