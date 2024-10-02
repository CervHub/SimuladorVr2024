@extends('Administrator.main')

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
                            <a href="#" class="btn btn-primary text-white p-3" data-toggle="modal"
                                data-target="#createModal"><i class="icon-plus"></i> Crear Entrenador</a>
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
                        <h4 class="card-title">Entrenadores</h4>
                        <table id="myTable" class="display dataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>DOI</th>
                                    <th>Cargo</th>
                                    <th>Estado</th>
                                    <th>Creado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workers as $worker)
                                    <tr>
                                        <td>{{ $worker->id }}</td>
                                        <td>{{ $worker->nombre }}</td>
                                        <td>{{ $worker->apellido }}</td>
                                        <td>{{ $worker->user->doi }}</td>
                                        <td>{{ $worker->position }}</td>
                                        <td>
                                            @if ($worker->status == '0')
                                                <label class="badge badge-danger">No Activo</label>
                                            @else
                                                <label class="badge badge-primary">Activo</label>
                                            @endif
                                        </td>
                                        <td>{{ $worker->created_at }}</td>
                                        <td>
                                            <button class="btn btn-custom btn-warning text-white me-0" data-toggle="modal"
                                                data-target="#editModal" onclick="editar({{ $worker->id }})">
                                                <span class="icon icon-pencil"></span> Editar
                                            </button>
                                            <button class="btn btn-custom btn-success text-white me-0" data-toggle="modal"
                                                data-target="#detalleModal" onclick="details({{ $worker->id }})">
                                                <span class="fas fa-info-circle"></span> Detalles
                                            </button>
                                            <button class="btn btn-custom btn-danger text-white me-0" data-toggle="modal"
                                                data-target="#deleteModal" onclick="eliminar({{ $worker->id }})">
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
    @include('Administrator.create')
    <!-- Modal Editar -->
    @include('Administrator.editar')
    <!-- Modal Eliminar -->
    @include('Administrator.eliminar')
    <!-- Modal Detalle -->
    @include('Administrator.detalle')
@endsection

@section('js')
    <script>
        const iconSuperAdmin = document.querySelector('#entrenadores-administrador');
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

    {{-- para la imagen de crear y editar --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var signatureInput = document.getElementById('signature_edit');
            var previewImage = document.getElementById('preview');

            if (signatureInput && previewImage) {
                signatureInput.addEventListener('change', function(e) {
                    console.log("Cambiando");
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var signatureInput = document.getElementById('signature');
            var previewImage = document.getElementById('preview_create');

            if (signatureInput && previewImage) {
                signatureInput.addEventListener('change', function(e) {
                    console.log("Cambiando");
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
                });
            }
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
        var url = "{{ asset('') }}";
        console.log(url);

        function editar(id) {

            $('#loading-overlay').show();
            $('#form_entrenador').hide();
            console.log(id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: '{{ route('administrador.detalle') }}', // Cambia esto a la URL correcta de tu servidor de ping
                type: 'POST',
                data: {
                    id: id // Agrega el ID a los datos que serán enviados
                },
                success: function(response) {
                    console.log(response);
                    $('#id_worker_editar').val(response.id);
                    $('#last_name_editar').val(response.last_name);
                    $('#position_editar').val(response.worker.position);
                    $('#name_editar').val(response.name);
                    $('#doi_editar').val(response.doi);
                    $('#department_editar').val(response.worker.department);
                    $('#preview').attr('src', url + response.worker.user.signature);
                    $('#loading-overlay').hide();
                    $('#form_entrenador').show();
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
            $('#loading-overlay').show();
            $('#modalContent').hide();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: '{{ route('administrador.detalle') }}', // Cambia esto a la URL correcta de tu servidor de ping
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
                    $('#loading-overlay').hide();
                    $('#modalContent').show();
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
                url: '{{ route('administrador.detalle') }}', // Cambia esto a la URL correcta de tu servidor de ping
                type: 'POST',
                data: {
                    id: id // Agrega el ID a los datos que serán enviados
                },
                success: function(response) {
                    console.log(response);
                    $('#id_eliminar').text(response.id);
                    $('#last_name_eliminar').text(response.last_name);
                    $('#name_eliminar').text(response.name);
                    $('#doi_eliminar').text(response.doi);
                    $('#codigo_eliminar').text(response.worker.code_worker);
                    $('#id_eliminar_submit').val(response.id);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log("Error en la conexión:", xhr.status, thrownError);
                }
            });
        }
    </script>
@endsection
