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
                                <th class="text-center">Originales</th>
                                <th class="text-center">Disponibles</th>
                                <th class="text-center">Consumidos</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                            @php
                                $originales = (int) ($company->creditos_originales ?? 0);
                                $disponibles = (int) ($company->creditos ?? 0);
                                $consumidos = max(0, $originales - $disponibles);
                            @endphp
                            <tr>
                                <td>{{$company->id}}</td>
                                <td>{{$company->name}}</td>
                                <td>{{$company->ruc}}</td>
                                <td>{{ $originales }}</td>
                                <td>{{ $disponibles }}</td>
                                <td>{{ $consumidos }}</td>
                                <td>
                                    @if($company->status == '0')
                                    <label class="badge badge-danger">No Activo</label>
                                    @else
                                    <label class="badge badge-primary">Activo</label>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-custom btn-warning text-white me-0" data-toggle="modal" data-target="#creditoModal"
                                        onclick="gestionarCredito({{$company->id}}, '{{ addslashes($company->name) }}', {{ $originales }}, {{ $disponibles }})">
                                        <span class="icon icon-pencil"></span> Gestionar
                                    </button>
                                    <button class="btn btn-custom btn-success text-white me-0" data-toggle="modal" data-target="#historialModal"
                                        onclick="verHistorial({{$company->id}})">
                                        <span class="fas fa-history"></span> Historial
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
                        <label for="creditos_originales">Créditos originales:</label>
                        <input type="number" class="form-control" id="creditos_originales" name="creditos_originales" min="0" step="1" required>
                        <small class="form-text text-muted">Total asignado / paquete de la empresa.</small>
                    </div>
                    <div class="form-group">
                        <label for="creditos">Créditos disponibles:</label>
                        <input type="number" class="form-control" id="creditos" name="creditos" min="0" step="1" required>
                        <small class="form-text text-muted">Saldo actual. No puede ser mayor a los originales.</small>
                    </div>
                    <div class="form-group">
                        <label for="observacion">Observación (opcional):</label>
                        <input type="text" class="form-control" id="observacion" name="observacion" maxlength="255" placeholder="Ej. Recarga mensual">
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

<!-- Modal historial -->
<div class="modal fade" id="historialModal" tabindex="-1" role="dialog" aria-labelledby="historialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historialModalLabel">Historial de créditos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-1"><strong>Empresa:</strong> <span id="historial_empresa"></span></p>
                <p class="mb-1"><strong>Originales:</strong> <span id="historial_originales"></span></p>
                <p class="mb-1"><strong>Disponibles:</strong> <span id="historial_saldo"></span></p>
                <p class="mb-3"><strong>Consumidos:</strong> <span id="historial_consumidos"></span></p>
                <div class="table-responsive">
                    <table class="table table-striped table-sm text-center">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Anterior</th>
                                <th>Nuevo</th>
                                <th>Diferencia</th>
                                <th>Tipo</th>
                                <th>Origen</th>
                                <th>Observación</th>
                            </tr>
                        </thead>
                        <tbody id="historial_body">
                            <tr><td colspan="7">Cargando...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
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

    function gestionarCredito(id, nombre, originales, disponibles) {
        $('#id_company_credito').val(id);
        $('#empresa_credito').val(nombre);
        $('#creditos_originales').val(originales);
        $('#creditos').val(disponibles);
        $('#observacion').val('');
    }

    function verHistorial(id) {
        $('#historial_body').html('<tr><td colspan="7">Cargando...</td></tr>');
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
        });
        $.ajax({
            url: '{{ route("superadministrador.creditos.historial") }}',
            type: 'POST',
            data: { id_company: id },
            success: function(response) {
                $('#historial_empresa').text(response.empresa);
                $('#historial_originales').text(response.creditos_originales);
                $('#historial_saldo').text(response.creditos);
                $('#historial_consumidos').text(response.consumidos);
                if (!response.historial || response.historial.length === 0) {
                    $('#historial_body').html('<tr><td colspan="7">Sin movimientos</td></tr>');
                    return;
                }
                let rows = '';
                response.historial.forEach(function(item) {
                    rows += '<tr>' +
                        '<td>' + (item.created_at || '') + '</td>' +
                        '<td>' + item.creditos_anteriores + '</td>' +
                        '<td>' + item.creditos_nuevos + '</td>' +
                        '<td>' + item.diferencia + '</td>' +
                        '<td>' + item.tipo + '</td>' +
                        '<td>' + (item.origen || '') + '</td>' +
                        '<td>' + (item.observacion || '') + '</td>' +
                        '</tr>';
                });
                $('#historial_body').html(rows);
            },
            error: function() {
                $('#historial_body').html('<tr><td colspan="7">Error al cargar historial</td></tr>');
            }
        });
    }
</script>
@endsection
