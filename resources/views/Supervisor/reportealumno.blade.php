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
                            <a href="{{ route('entrenador.reporte') }}" class="btn btn-success text-white p-3"><i
                                    class="fas fa-book"></i> Reporte Por Inducción o Taller</a>
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

                <div class="d-flex align-items-center justify-content-between border-bottom">
                    <div class="form-group">
                        <label for="ruc">Documento de Identidad:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="doi" name="doi"
                                placeholder="Ingrese su Documento de Identidad" pattern="[0-9]*" inputmode="numeric">
                            <div class="input-group-append" style="padding-left: 10px;">
                                <button class="btn btn-primary btn-sm rounded-2" type="button" onclick="search()">
                                    <i class="icon-search"></i> <!-- Icono de búsqueda aquí -->
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted small">*Solo números</small>
                    </div>
                </div>

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
                        <h4 class="card-title">Inducciones - Grupos <span id="namename"></span></h4>
                        <table id="myTable" class="display dataTable table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Inducción</th>
                                    <th>Fecha - Inicio</th>
                                    <th>Fecha - Finalización</th>
                                    <th>N° Eval.</th>
                                    <th>N° Entren.</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

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
        function search() {
            var doi = $('#doi').val();
            console.log(doi);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: '{{ route('reportealumnodetail') }}', // Cambia esto a la URL correcta de tu servidor de ping
                type: 'POST',
                data: {
                    doi: doi // Agrega el ID a los datos que serán enviados
                },
                success: function(response) {
                    console.log(response);
                    var tbody = $('#myTable tbody');
                    // $('#namename').text(response.name + ' ' + response.last_name);
                    tbody.empty(); // Limpia cualquier fila existente en la tabla

                    // Recorre las inducciones en la respuesta y agrega filas a la tabla
                    response.inductions.forEach(function(induccion, index) {
                        var newRow = '<tr class="table-primary">' +
                            '<td>' + induccion.id_induction_workers + '</td>' +
                            '<td>' + induccion.name_taller + '</td>' +
                            '<td>' + induccion.date_start + '</td>' +
                            '<td>' + induccion.date_end + '</td>' +
                            '<td>' + induccion.num_report + '</td>' +
                            '<td>' + induccion.num_report_entenamiento + '</td>' +
                            '<td><button class="btn btn-custom btn-primary text-white me-0" data-bs-toggle="collapse" data-bs-target="#details' +
                            index + '">Ver Intentos</button></td>' +
                            '</tr>';

                        var detailsRow = '<tr>' +
                            '<td colspan="6">' +
                            '<div id="details' + index + '" class="collapse">' +
                            '<table class="display dataTable table table-stripep">' +
                            '<thead>' +
                            '<tr class="table-secondary">' +
                            '<th>Num Intento</th>' +
                            '<th>Fecha Inicio</th>' +
                            '<th>Fecha Fin</th>' +
                            '<th>Entrenamiento / Evaluación</th>' +
                            // '<th>Nota Obtenida</th>' +
                            '<th>Acciones</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>';

                        induccion.intentos.sort((a, b) => b.id - a.id).forEach(
                            function(item, index) {
                                detailsRow += '<tr>' +
                                    '<td>' + item.intento + '</td>' +
                                    '<td>' + item.date_start + '</td>' +
                                    '<td>' + item.date_end + '</td>' +
                                    '<td>' + item.modo + '</td>' +
                                    // '<td>' + item.note + '</td>' +
                                    '<td>' +
                                    '<a href="{{ url('view/pdf') }}/' + induccion
                                    .id_induction_workers + '/' + item.intento + '/' + item.modo +
                                    '" target="_blank" class="btn btn-custom btn-primary text-white me-0">' +
                                    '<span class="mdi mdi-file-download"> Descargar Reporte</span>' +
                                    '</a>' +
                                    '</td>' +
                                    '</tr>';
                            }
                        );

                        detailsRow += '</tbody></table></div></td></tr>';

                        tbody.append(newRow);
                        tbody.append(detailsRow);
                    });

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var tbody = $('#myTable tbody');
                    $('#namename').text('');
                    tbody.empty(); // Limpia cualquier fila existente en la tabla
                    console.log("Error en la conexión:", xhr.status, thrownError);
                }
            });
        }
    </script>
@endsection
