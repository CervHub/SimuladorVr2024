@extends('SuperAdmin.main')

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .sidebar-dark .sidebar .nav .nav-item.active>.nav-link:before {
        content: '';
        width: 2px;
        height: 100%;
        background: transparent;
        left: 0;
        top: 0;
        position: absolute;
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
                        <a href="#" class="btn btn-success text-white p-3" data-toggle="modal" data-target="#createModal"><i class="icon-plus"></i> Agregar Taller</a>
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
                    <h4 class="card-title">Empresa - {{$company->name}}</h4>
                    <table id="myTable" class="display dataTable table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Taller</th>
                                <th>Alias</th>
                                <th>Estado</th>
                                <th>Creado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workshopcompanies as $workshop)
                            <tr>
                                <td>{{$workshop->id}}</td>
                                <td>{{$workshop->workshop->name}}</td>
                                <td>{{$workshop->alias}}</td>
                                <td>
                                    @if($workshop->status == '0')
                                    <label class="badge badge-danger">No Activo</label>
                                    @else
                                    <label class="badge badge-primary">Activo</label>
                                    @endif
                                </td>
                                <td>{{$workshop->created_at}}</td>
                                <td>
                                    <button class="btn btn-custom btn-warning text-white me-0" data-toggle="modal" data-target="#editModal" onclick="editar({{$workshop->id}})">
                                        <span class="icon icon-pencil"></span> Editar
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


<!-- modal Create -->
@include('SuperAdmin.Taller.createtallecompanies')

<!-- Modal editar -->
@include('SuperAdmin.Taller.edittallercompany')

@endsection

@section('js')

<!-- uso de datatables -->
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


<!-- Modal Editar -->
<!-- Editar Modal -->
<!-- Detalles de cada registro -->
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
            url: '{{ route("detailstalleres2") }}', // Cambia esto a la URL correcta de tu servidor de ping
            type: 'POST',
            data: {
                id: id // Agrega el ID a los datos que serán enviados
            },
            success: function(response) {

                console.log(response);
                $('#id_workshop_company').val(response.id);
                $('#alias_editar').val(response.alias);
                $('#status_editar').val(response.status);
                $('#id_workshop_editar').val(response.id_workshop);
                $('#workshop_editar').val(response.nombre);

                $('#loading-overlay').hide();
                $('#form-edit').show();

            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error en la conexión:", xhr.status, thrownError);
            }
        });
    }
</script>

@endsection