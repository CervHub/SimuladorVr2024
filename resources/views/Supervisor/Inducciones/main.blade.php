@extends('Supervisor.main')

@section('css')
    <style>
        .table td {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .btn-custom {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
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
                            <a href="#" class="btn btn-primary text-white p-3" data-toggle="modal"
                                data-target="#createModal"><i class="icon-plus"></i> Crear Capacitación</a>
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
                        <h4 class="card-title">Capacitaciones - Grupos</h4>
                        <table id="myTable" class="display dataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Taller</th>
                                    <th>Fecha - Inicio</th>
                                    <th>Fecha - Finalización</th>
                                    <th>N° de Usuarios</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inductions as $induction)
                                    <tr>
                                        <td>{{ $induction->id }}</td>
                                        <td>{{ $induction->alias }}</td>
                                        <td>{{ \Carbon\Carbon::parse($induction->date_start)->format('d/m/Y') }}
                                            {{ $induction->time_start }}</td>
                                        <td>{{ \Carbon\Carbon::parse($induction->date_end)->format('d/m/Y') }}
                                            {{ $induction->time_end }}</td>
                                        <td>{{ $induction->workers->filter(function ($worker) {return $worker->status == 1;})->count() }}
                                        <td>
                                            @php
                                                $startDateTime = \Carbon\Carbon::parse(
                                                    $induction->date_start . ' ' . $induction->time_start,
                                                );
                                                $endDateTime = \Carbon\Carbon::parse(
                                                    $induction->date_end . ' ' . $induction->time_end,
                                                );
                                            @endphp
                                            @if (now()->lessThan($startDateTime) || now()->greaterThan($endDateTime))
                                                <label class="badge badge-danger">Inactivo</label>
                                            @else
                                                <label class="badge badge-primary">Activo</label>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-custom btn-warning text-white me-0"
                                                    data-toggle="modal" data-target="#editModal"
                                                    onclick="editar({{ $induction->id }})">
                                                    <span class="icon icon-pencil"></span> <!-- Icono de editar aquí -->
                                                </button>
                                                <a href="{{ route('entrenador.evaluacion', ['id_induction' => $induction->id]) }}"
                                                    class="btn btn-custom btn-primary text-white me-0">
                                                    <span class="mdi mdi-account-plus"></span>
                                                    <!-- Icono de matricular o inscribir aquí -->
                                                </a>
                                                <button class="btn btn-custom btn-danger text-white me-0"
                                                    data-toggle="modal" data-target="#eliminarModal"
                                                    onclick="eliminar({{ $induction->id }}, '{{ $induction->alias }}', {{ count($induction->workers) }})">
                                                    <span class="mdi mdi-delete-forever"></span>
                                                    <!-- Icono de eliminar aquí -->
                                                </button>

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


    <!-- Crear -->
    @include('Supervisor.Inducciones.create')
    <!-- Editar -->
    @include('Supervisor.Inducciones.edit')
    <!-- eliminar -->
    @include('Supervisor.Inducciones.eliminar')
@endsection

@section('js')
    <script>
        const iconSuperAdmin = document.querySelector('#taller-supervisor');
        iconSuperAdmin.classList.add('active');
    </script>
    <!-- Activar DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>



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

    <!-- Editar Modal -->
    <script>
        function editar(id) {
            $('#loading-overlay').show();
            $('#form-edit').hide();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: '{{ route('entrenador.search.induction') }}', // Cambia esto a la URL correcta de tu servidor de ping
                type: 'POST',
                data: {
                    id: id // Agrega el ID a los datos que serán enviados
                },
                success: function(response) {
                    console.log(response);
                    $('#curso').val(response.name);
                    $('#startDate').val(response.date_start);
                    $('#endDate').val(response.date_end);
                    $('#startTime').val(response.time_start);
                    $('#endTime').val(response.time_end);
                    $("#status").val(response.status);
                    $("#intentos").val(response.intentos);
                    $("#course").val(response.id_workshop);
                    $("#edit_id_induction").val(response.id);
                    $('#loading-overlay').hide();
                    $('#form-edit').show();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log("Error en la conexión:", xhr.status, thrownError);
                }
            });
        }
    </script>

    <!-- JavaScript para llamar la función eliminar y pasar los valores -->
    <script>
        function eliminar(id, alias, num) {
            // Asignamos los valores a los elementos del modal
            document.getElementById('id_eliminar').textContent = id;
            document.getElementById('alias_eliminar').textContent = alias;
            document.getElementById('num_eliminar').textContent = num;
            // Asignamos los valores a los campos ocultos
            document.getElementById('id_eliminar_submit').value = id;
            document.getElementById('alias_eliminar_submit').value = alias;
            document.getElementById('num_eliminar_submit').value = num;
            // Mostramos el modal
        }
    </script>
@endsection
