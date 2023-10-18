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
                        <a href="#" class="btn btn-primary text-white p-3 btn-sm" data-toggle="modal" data-target="#createModal"><i class="icon-plus"></i> Create New</a>
                    </div>
                </div>

                <div class="">

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
                    <h4 class="card-title">Servicios - Empresas</h4>
                    <table id="myTable" class="display dataTable table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Creado</th>
                                <th>N° de Trabajadores</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td>{{$service->id}}</td>
                                <td>{{$service->name}}</td>
                                <td>{{ strlen($service->description) > 25 ? substr($service->description, 0, 25) . '...' : $service->description }}</td>
                                <td>{{$service->status}}</td>
                                <td>{{$service->created_at}}</td>
                                <td>{{ count($service->workers) }}</td>
                                <td>
                                    <button class="btn btn-custom btn-warning text-white me-0" data-toggle="modal" data-target="#editModal" onclick="editar({{$service->id}})">
                                        <span class="icon icon-pencil"></span> Editar
                                    </button>
                                    <button class="btn btn-custom btn-success text-white me-0">
                                        <a href="{{ route('entrenador.matricula', ['id_service' => $service->id]) }}" class="text-white" style="text-decoration: none;">
                                            <span class="fas fa-info-circle"></span> Trabajadores
                                        </a>
                                    </button>

                                    <button class="btn btn-custom btn-danger text-white me-0" data-toggle="modal" data-target="#deleteModal" onclick="eliminar({{$service->id}})">
                                        <span class="icon icon-trash"></span> Eliminar
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

<!-- Modal crear -->
@include('Supervisor.create')
<!-- Modal Editar -->
@include('Supervisor.editar')
<!-- Modal Eliminar -->
@include('Supervisor.eliminar')


@endsection

@section('js')
<script>
    const iconSuperAdmin = document.querySelector('#servicio-supervisor');
    iconSuperAdmin.classList.add('active');
</script>


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
    });
</script>

<!-- Editar Entrenador -->
<script>
    function editar(id) {
        console.log(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $.ajax({
            url: '{{ route("entrenador.detalle") }}', // Cambia esto a la URL correcta de tu servidor de ping
            type: 'POST',
            data: {
                id: id // Agrega el ID a los datos que serán enviados
            },
            success: function(response) {
                console.log(response);
                $('#id_service_editar').val(response.id);
                $('#description_editar').val(response.description);
                $('#name_editar').val(response.name);
                $('#ruc_editar').val(response.ruc);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error en la conexión:", xhr.status, thrownError);
            }
        });
    }
</script>

<!-- Detalle Entrenador -->
<!-- Detalles de cada registro -->
<script>
    function details(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $.ajax({
            url: '{{ route("entrenador.detalle") }}', // Cambia esto a la URL correcta de tu servidor de ping
            type: 'POST',
            data: {
                id: id // Agrega el ID a los datos que serán enviados
            },
            success: function(response) {
                console.log(response);
                $('#id_detalle').text(response.id);
                $('#last_name_detalle').text(response.last_name);
                $('#name_detalle').text(response.name);
                $('#doi_detalle').text(response.doi);
                $('#password_detalle').text(response.worker.user.password_text);
                $('#codigo_detalle').text(response.worker.code_worker);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error en la conexión:", xhr.status, thrownError);
            }
        });
    }
</script>

<!-- Copiar Detalle de modal detalle -->
<script>
    // Función para copiar el contenido del modal al portapapeles
    document.getElementById('copyButton').addEventListener('click', function() {
        var modalContent = document.getElementById('modalContent');
        var range = document.createRange();
        range.selectNodeContents(modalContent);
        var selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand('copy');
        alert('Contenido copiado al portapapeles');
        selection.removeAllRanges();
    });
</script>
<!-- Eliminar Entrenador -->
<script>
    function eliminar(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $.ajax({
            url: '{{ route("entrenador.detalle") }}', // Cambia esto a la URL correcta de tu servidor de ping
            type: 'POST',
            data: {
                id: id // Agrega el ID a los datos que serán enviados
            },
            success: function(response) {
                console.log(response);
                $('#id_eliminar').text(response.id);
                $('#description_eliminar').text(response.description);
                $('#name_eliminar').text(response.name);
                $('#ruc_eliminar').text(response.ruc);
                $('#id_eliminar_submit').val(response.id);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error en la conexión:", xhr.status, thrownError);
            }
        });
    }
</script>
@endsection