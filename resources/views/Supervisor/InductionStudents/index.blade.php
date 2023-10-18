@extends('Supervisor.main')

@section('css')

<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
            <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                <div>
                    <div class="btn-wrapper">
                        <a href="#" class="btn btn-primary text-white p-3 btn-sm" data-toggle="modal" data-target="#createModal">
                            <i class="icon-plus"></i> <!-- Icono de agregar aquí -->
                            Create New
                        </a>
                        <a href="{{route('induction.formato')}}" class="btn btn-success text-white p-3 btn-sm">
                            <i class="mdi mdi-arrow-down-bold-circle-outline"></i> <!-- Icono de descarga aquí -->
                            Descargar Formato
                        </a>
                    </div>
                </div>

                <div class="">
                    <form action="{{route('induction.cargamasiva')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$id_induction}}" name="id_induction" id="id_induction">
                        <input type="file" name="archivo_trabajadores" class="form-control-file btn btn-sm mt-2" accept=".xlsx" required>
                        <button type="submit" class="btn btn-success btn-sm mt-2 "><i class="fas fa-upload"></i> Importar trabajadores</button>
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
                    <h4 class="card-title">Empresas</h4>
                    <table id="myTable" class="display dataTable table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombres y Apellidos</th>
                                <th>DOI</th>
                                <th>Cargo</th>
                                <th>Creado</th>
                                <th>Accciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inductionworkers as $inductionworker)
                            <tr>
                                <td>{{$inductionworker->id}}</td>
                                <td>{{$inductionworker->worker->user->name}}</td>
                                <td>{{$inductionworker->worker->user->doi}}</td>
                                <td>{{$inductionworker->worker->position}}</td>
                                <td>{{$inductionworker->created_at}}</td>
                                <td>
                                    <button class="btn btn-custom btn-danger text-white me-0" data-toggle="modal" data-target="#eliminarModal" onclick="eliminar({{strval($inductionworker->worker->user->doi)}},{{$inductionworker->id}})">
                                        <span class="mdi mdi-delete-forever">Eliminar</span> <!-- Icono de eliminar aquí -->
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

@include('Supervisor.InductionStudents.create')
@include('Supervisor.InductionStudents.delete')

@endsection

@section('js')

<!-- Activar DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
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
        table.page.len(5).draw();

    });
</script>


<!-- Buscar Estudiante -->
<script>
    function search(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        console.log($('#doi').val());
        console.log($('#id_induction').val());

        $.ajax({
            url: '{{ route("entrenador.search.worker.service") }}', // Cambia esto a la URL correcta de tu servidor de ping
            type: 'POST',
            data: {
                doi: $('#doi').val(),
                id_induction: $('#id_induction').val(),
                id_service: $('#service').val(),
            },
            success: function(response) {
                console.log(response);
                $('#name').val(response.name);
                $('#last_name').val(response.last_name);
                $('#position').val(response.position);
                $('#id_worker').val(response.id);
                if (response == 'Error') {
                    $('#mensaje_error').text("Consulta Sin datos.");
                }else{
                    $('#mensaje_error').text("");
                }
                console.log("Aqui");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error en la conexión:", xhr.status, thrownError);
            }
        });
    }
</script>

<!-- Eliminar Estudiante -->
<script>
    function eliminar(doi, id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        console.log(doi);
        console.log(id);
        console.log($('#id_induction').val());

        $.ajax({
            url: '{{ route("entrenador.search.workerdoi") }}', // Cambia esto a la URL correcta de tu servidor de ping
            type: 'POST',
            data: {
                id: id,
                id_induction: $('#id_induction').val(),
            },
            success: function(response) {
                console.log(response);
                $('#name_eliminar').text(response.name);
                $('#last_name_eliminar').text(response.last_name);
                $('#id_eliminar_submit').val(id);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error en la conexión:", xhr.status, thrownError);
            }
        });
    }
</script>
@endsection