@extends('SuperAdmin.main')

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
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
                    <h4 class="card-title">Créditos por Empresa</h4>
                    <table id="myTable" class="display dataTable table table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">RUC</th>
                                <th class="text-center">Créditos</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                            <tr>
                                <td>{{$company->id}}</td>
                                <td>{{$company->name}}</td>
                                <td>{{$company->ruc}}</td>
                                <td>{{$company->creditos ?? '—'}}</td>
                                <td>
                                    @if($company->status == '0')
                                    <label class="badge badge-danger">No Activo</label>
                                    @else
                                    <label class="badge badge-primary">Activo</label>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-custom btn-warning text-white me-0" data-toggle="modal" data-target="#creditoModal"
                                        onclick="gestionarCredito({{$company->id}}, '{{ addslashes($company->name) }}', '{{ addslashes($company->creditos ?? '') }}')">
                                        <span class="icon icon-pencil"></span> Gestionar
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

<!-- Modal gestionar créditos -->
<div class="modal fade" id="creditoModal" tabindex="-1" role="dialog" aria-labelledby="creditoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="creditoModalLabel">Gestionar Créditos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadministrador.creditos.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Empresa:</label>
                        <input type="text" class="form-control" id="empresa_credito" disabled>
                    </div>
                    <div class="form-group">
                        <label for="creditos">Créditos:</label>
                        <input type="text" class="form-control" id="creditos" name="creditos" placeholder="Numérico o alfanumérico" maxlength="255">
                        <small class="form-text text-muted">Puede ser numérico o alfanumérico.</small>
                    </div>
                    <input type="hidden" name="id_company" id="id_company_credito" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        let table = $('#myTable').DataTable();
        let customSearchInput = $('#customSearchInput');
        let recordsPerPageSelect = $('#recordsPerPage');

        customSearchInput.on('keyup', function() {
            table.search(this.value).draw();
        });

        recordsPerPageSelect.on('change', function() {
            table.page.len(this.value).draw();
        });
    });
</script>
<script>
    const iconCreditos = document.querySelector('#creditos-superadmin');
    iconCreditos.classList.add('active');

    function gestionarCredito(id, nombre, creditos) {
        $('#id_company_credito').val(id);
        $('#empresa_credito').val(nombre);
        $('#creditos').val(creditos);
    }
</script>
@endsection
