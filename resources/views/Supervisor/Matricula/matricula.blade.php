@extends('Supervisor.main')

@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">

                    <div>
                        <div class="btn-wrapper">
                            <a href="#" class="btn btn-primary text-white p-3 btn-sm" data-toggle="modal"
                                data-target="#createModal">
                                <i class="icon-plus"></i> <!-- Icono de agregar aquí -->
                                Registrar Trabajador
                            </a>
                            <a href="{{ route('induction.formato.masivo') }}" class="btn btn-success text-white p-3 btn-sm">
                                <i class="mdi mdi-arrow-down-bold-circle-outline"></i> <!-- Icono de descarga aquí -->
                                Descargar Formato
                            </a>
                        </div>
                    </div>
                    <div class="">
                        <form action="{{ route('matricula.cargamasiva') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $id_service }}" name="id_service">
                            <input type="file" name="archivo_trabajadores" class="form-control-file btn btn-sm mt-2"
                                accept=".xlsx" required>
                            <button type="submit" class="btn btn-success btn-sm mt-2 "><i class="fas fa-upload"></i>
                                Importar trabajadores</button>
                        </form>
                    </div>
                </div>

                <!-- Agregar el campo de entrada de archivo y el botón de importación -->

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

                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div>
                        <div class="btn-wrapper">
                            <label for="recordsPerPage">Mostrar:</label>
                            <select id="recordsPerPage" class="me-3 form-control-custom p-1">
                                <option value="0">0</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 mb-3 ">
                        <label for="customSearchInput">Buscar:</label>
                        <input type="text" id="customSearchInput" class="form-control-custom p-1" placeholder="">

                    </div>
                </div>

                <div class="card rounded-0 mt-3">
                    <div class="card-body table-responsive">
                        <h4 class="card-title">Trabajadores - {{ $nombre_service }}</h4>
                        <table id="myTable" class="display dataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Codigo de Empleado</th>
                                    <!-- <th>Nombres y Apellidos</th> -->
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>DOI</th>
                                    <th>Cargo</th>
                                    <th>Creado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            @foreach ($workers as $worker)
                                <tr>
                                    <td>{{ $worker->id }}</td>
                                    <td>
                                        @if (session('id_company') == 3)
                                            {{ $worker->employee_code }}
                                        @else
                                            {{ $worker->code_worker }}
                                        @endif
                                    </td>
                                    <!-- <td>{{ $worker->user->name }}</td> -->
                                    <td>{{ $worker->nombre }}</td>
                                    <td>{{ $worker->apellido }}</td>
                                    <td>{{ $worker->user->doi }}</td>
                                    <td>{{ $worker->position }}</td>
                                    <td>{{ $worker->created_at }}</td>
                                    <td>
                                        <button class="btn btn-custom btn-primary text-white me-0" data-toggle="modal"
                                            data-target="#editModal" onclick="editar({{ $worker->id }})">
                                            <span class="mdi mdi-pencil">Editar</span> <!-- Icono de edición aquí -->
                                        </button>
                                        <button class="btn btn-custom btn-danger text-white me-0" data-toggle="modal"
                                            data-target="#eliminarModal" onclick="eliminar({{ $worker->id }})">
                                            <span class="mdi mdi-delete-forever">Eliminar</span>
                                            <!-- Icono de eliminar aquí -->
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Supervisor.Matricula.create')
    @include('Supervisor.Matricula.edit')
    @include('Supervisor.Matricula.delete')
@endsection

@section('jscontent')
    <!-- Activar DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        console.log("Estamos adentro");
        $(document).ready(function() {
            $('#miTabla').DataTable({
                searching: false,
                lengthChange: false,
                paging: true, // Activar la paginación
                info: false, // Desactivar información sobre registros
                ordering: false // Desactivar ordenamiento
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let table = $('#myTable').DataTable();

            // Obtén el input personalizado y el select para registros por página
            let customSearchInput = $('#customSearchInput');
            let recordsPerPageSelect = $('#recordsPerPage');

            // Aplica la búsqueda personalizada cuando el input cambie
            customSearchInput.on('keyup', function() {
                table.search(this.value).draw();
            });

            // Cambia el número de registros por página cuando el select cambie
            recordsPerPageSelect.on('change', function() {
                table.page.len(this.value).draw();
            });
        });
    </script>

    <script>
        function eliminar(id) {

            console.log("Id para Eliminar", id)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: '{{ route('entrenador.search.worker.doi') }}', // Cambia esto a la URL correcta de tu servidor de ping
                type: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    $('#name_eliminar').text(response.name);
                    $('#last_name_eliminar').text(response.last_name);
                    $('#worker_id_eliminar').val(response.id);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log("Error en la conexión:", xhr.status, thrownError);
                }
            });
        }
    </script>
    <script>
        function editar(id) {
            console.log("Holi");
            $('#loading-overlay').show();
            $('#form-edit').hide();
            console.log("Id para editar", id)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: '{{ route('entrenador.search.worker.doi') }}',
                type: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    $('#name_editar').val(response.name);
                    $('#last_name_editar').val(response.last_name);
                    $('#position_editar').val(response.position);
                    $('#dni_editar').val(response.dni);
                    $('#celular_editar').val(response.celular);
                    $('#worker_id_editar').val(response.id);
                    $('#employee_code_editar').val(response.employee_code);
                    $('#license_number_editar').val(response.license);
                    $('#license_category_editar').val(response.category);
                    if (response.photo) {
                        $('#canvasEdit').show();
                        var canvas = document.getElementById('canvasEdit');
                        var context = canvas.getContext('2d');
                        var image = new Image();
                        image.onload = function() {
                            context.drawImage(image, 0, 0, canvas.width, canvas.height);
                        };
                        image.src = response.photo;
                    }
                    $('#loading-overlay').hide();
                    $('#form-edit').show();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log("Error en la conexión:", xhr.status, thrownError);
                }
            });
        }

        $(document).ready(function() {
            $('#takePhotoBtnEdit').click(function() {
                $('#cameraEdit').show();
                $('#canvasEdit').hide();
                Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });
                Webcam.attach('#cameraEdit');

                $(this).text('Capturar Foto').off('click').on('click', function() {
                    Webcam.snap(function(data_uri) {
                        $('#cameraEdit').hide();
                        $('#canvasEdit').show();
                        var canvas = document.getElementById('canvasEdit');
                        var context = canvas.getContext('2d');
                        var img = new Image();
                        img.onload = function() {
                            canvas.width = img.width;
                            canvas.height = img.height;
                            context.drawImage(img, 0, 0);
                        };
                        img.src = data_uri;
                        $('#photo_base64_editar').val(data_uri);

                        // Cambiar el texto del botón y la funcionalidad para tomar de nuevo
                        $('#takePhotoBtnEdit').text('Tomar de Nuevo').off('click').on(
                            'click',
                            function() {
                                $('#canvasEdit').hide();
                                $('#cameraEdit').show();
                                Webcam.attach('#cameraEdit');
                                $(this).text('Capturar Foto').off('click').on('click',
                                    function() {
                                        Webcam.snap(function(data_uri) {
                                            $('#cameraEdit').hide();
                                            $('#canvasEdit').show();
                                            var canvas = document
                                                .getElementById(
                                                    'canvasEdit');
                                            var context = canvas.getContext(
                                                '2d');
                                            var img = new Image();
                                            img.onload = function() {
                                                canvas.width = img
                                                    .width;
                                                canvas.height = img
                                                    .height;
                                                context.drawImage(img,
                                                    0, 0);
                                            };
                                            img.src = data_uri;
                                            $('#photo_base64_editar').val(
                                                data_uri);
                                        });
                                    });
                            });
                    });
                });
            });
        });
    </script>
@endsection
