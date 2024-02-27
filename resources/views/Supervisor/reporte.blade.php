@extends('Supervisor.main')

@section('css')
    <style>
        .table th,
        .table td {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .table th {
            padding-bottom: 15px !important;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div>
                        <div class="btn-wrapper">
                            <a href="{{ route('reporte.alumno') }}" class="btn btn-primary text-white p-3"><i
                                    class="icon-people"></i> Reporte Por Alumno</a>
                        </div>
                    </div>
                </div>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha de inicio:</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_fin">Fecha de fin:</label>
                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_fin">Empresa:</label>
                                    <select name="id_service" class="form-control" id="service">
                                        <option value="0">Todos</option>
                                        @foreach ($services as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <h4 class="card-title">Induccion - Grupo</h4>
                        <table id="myTable" class="display dataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Inducción</th>
                                    <th>Fecha - Inicio</th>
                                    <th>Fecha - Finalización</th>
                                    <th>N° de Evaluados</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inductions as $induction)
                                    <tr>
                                        <td>{{ $induction->id }}</td>
                                        <td>{{ $induction->alias }}</td>
                                        <td>{{ $induction->date_start }} {{ $induction->time_start }}</td>
                                        <td>{{ $induction->date_end }} {{ $induction->time_end }}</td>
                                        <td>{{ count($induction->workers) }}</td>
                                        <td>
                                            @if ($induction->status == '0')
                                                <label class="badge badge-danger">No Activo</label>
                                            @else
                                                <label class="badge badge-primary">Activo</label>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="#" class="btn btn-custom btn-info text-white me-0"
                                                    onclick="modificarEnlace(this, '{{ route('descargar_asistencia_pdf', ['id_induction' => $induction->id, 'fecha_inicio' => '0000-00-00', 'fecha_fin' => '0000-00-00', 'id_service' => 0]) }}')">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                <a href="#" class="btn btn-custom btn-success  text-white me-0"
                                                    onclick="modificarEnlace(this, '{{ route('descargar_asistencia_excel', ['id_induction' => $induction->id, 'fecha_inicio' => '0000-00-00', 'fecha_fin' => '0000-00-00', 'id_service' => 0]) }}')">
                                                    <i class="fas fa-file-excel"></i>
                                                </a>
                                                @if(session('id_company') == 2)
                                                    <a href="{{ route('descargar_asistencia_zip', ['id_induction' => $induction->id]) }}"
                                                       class="btn btn-custom btn-warning text-white me-0">
                                                       <i class="fas fa-file-archive"></i>
                                                    </a>
                                                @endif
                                            </div>
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
@endsection

@section('js')
    <script>
        const iconSuperAdmin = document.querySelector('#reporte-supervisor');
        iconSuperAdmin.classList.add('active');
    </script>

    <script>
        // Función para modificar el enlace y realizar la redirección
        function modificarEnlace(enlace, ruta) {
            // Obtener las fechas de los campos de entrada
            var fechaInicio = document.getElementById('fecha_inicio').value;
            var fechaFin = document.getElementById('fecha_fin').value;
            var id_service = document.getElementById('service').value;

            // Reemplazar "/0" por el nuevo id_service en la ruta
            ruta = ruta.replace(/\/0$/, '/' + id_service);

            // Verificar si ambos campos de fecha están llenos
            if (fechaInicio !== '' && fechaFin !== '') {
                // Reemplazar las dos últimas fechas por las fechas de los campos de entrada en la ruta
                ruta = ruta.replace(/\/\d{4}-\d{2}-\d{2}\/\d{4}-\d{2}-\d{2}$/, '/' + fechaInicio + '/' + fechaFin);
            }

            // Agregar "/" al final de la URL
            ruta = ruta + '/';

            // Abrir el enlace en una nueva ventana o pestaña (_blank)
            window.open(ruta, '_blank');

            // Evitar que el enlace se siga al hacer clic
            return false;
        }
    </script>
@endsection
