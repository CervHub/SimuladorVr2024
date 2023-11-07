@extends('SuperAdmin.main')

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>

</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
            <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                <div>
                    <div class="btn-wrapper">
                        <a href="#" class="btn btn-primary text-white p-3" data-toggle="modal" data-target="#createModal"><i class="icon-plus"></i> Crear Empresa</a>
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
                    <h4 class="card-title">Empresas</h4>
                    <table id="myTable" class="display dataTable table table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Descripcion</th>
                                <th class="text-center">RUC</th>
                                <th class="text-center">Nº de Talleres</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Creado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                            <tr>
                                <td>{{$company->id}}</td>
                                <td>{{$company->name}}</td>
                                <td>{{$company->description}}</td>
                                <td>{{$company->ruc}}</td>
                                <td>{{count($company->workshops)}}</td>
                                <td>
                                    @if($company->status == '0')
                                    <label class="badge badge-danger">No Activo</label>
                                    @else
                                    <label class="badge badge-primary">Activo</label>
                                    @endif
                                </td>
                                <td>{{$company->created_at}}</td>
                                <td>
                                    <button class="btn btn-custom btn-warning text-white me-0" data-toggle="modal" data-target="#editModal" onclick="editar({{$company->id}})">
                                        <span class="icon icon-pencil"></span> Editar
                                    </button>
                                    <button class="btn btn-custom btn-success text-white me-0" data-toggle="modal" data-target="#detalleModal" onclick="details({{$company->id}})">
                                        <span class="fas fa-info-circle"></span> Detalles
                                    </button>
                                    <a href="{{ route('superadministrador.taller', ['id_company' => $company->id]) }}">
                                        <button class="btn btn-custom btn-primary text-white me-0">
                                            <span class="mdi mdi-account-box-multiple "></span> Talleres
                                        </button>
                                    </a>
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

<!-- Modal para crear -->
@include('SuperAdmin.create')

<!-- Detalle Modal -->
@include('SuperAdmin.detalle')

<!-- Edit Modal -->
@include('SuperAdmin.editar')

<!-- Delete Modal -->
@include('SuperAdmin.eliminar')

@endsection

@section('js')

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

<script>
    const iconSuperAdmin = document.querySelector('#empresa-superadmin');
    iconSuperAdmin.classList.add('active');
</script>

<!-- Detalles de cada registro -->
<script>
    function details(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $.ajax({
            url: '{{ route("details") }}', // Cambia esto a la URL correcta de tu servidor de ping
            type: 'POST',
            data: {
                id: id // Agrega el ID a los datos que serán enviados
            },
            success: function(response) {
                console.log(response);
                $('#id_detalle').text(response.id);
                $('#descripcion_detalle').text(response.descripcion);
                $('#nombre_detalle').text(response.nombre);
                $('#ruc_detalle').text(response.ruc);
                $('#password_detalle').text(response.usuario.password_text);
                $('#codigo_detalle').text(response.trabajadores.code_worker);
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

<!-- Editar Modal -->
<!-- Detalles de cada registro -->
<script>
    function editar(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $.ajax({
            url: '{{ route("details") }}', // Cambia esto a la URL correcta de tu servidor de ping
            type: 'POST',
            data: {
                id: id // Agrega el ID a los datos que serán enviados
            },
            success: function(response) {
                console.log(response);
                $('#id_company_editar').val(response.id);
                $('#description_editar').val(response.descripcion);
                $('#name_editar').val(response.nombre);
                $('#ruc_editar').val(response.ruc);
                $('#status_editar').val(response.status);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error en la conexión:", xhr.status, thrownError);
            }
        });
    }
</script>

<!-- Eliminar Modal -->
<script>
    function eliminar(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $.ajax({
            url: '{{ route("details") }}', // Cambia esto a la URL correcta de tu servidor de ping
            type: 'POST',
            data: {
                id: id // Agrega el ID a los datos que serán enviados
            },
            success: function(response) {
                console.log(response);
                $('#id_eliminar').text(response.id);
                $('#descripcion_eliminar').text(response.descripcion);
                $('#nombre_eliminar').text(response.nombre);
                $('#ruc_eliminar').text(response.ruc);
                $('#id_eliminar_submit').val(response.id);
                $('#codigo_eliminar').text(response.trabajadores.code_worker);

            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error en la conexión:", xhr.status, thrownError);
            }
        });
    }
</script>
@endsection