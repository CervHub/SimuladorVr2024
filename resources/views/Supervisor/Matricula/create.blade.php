<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Registrar Trabajador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('matricula.crearuser') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="firstName">Nombre:</label>
                        <input type="text" class="form-control" name="name" placeholder="Ingrese su nombre">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Apellido:</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Ingrese su apellido">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Cargo:</label>
                        <input type="text" class="form-control" name="position" placeholder="Ingrese su Cargo">
                    </div>
                    <div class="form-group">
                        <label for="department">Departamento o Área: (Opcional)</label>
                        <select class="form-control" id="department" name="department">
                            <option value="">Seleccione un departamento</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="areaDiv" style="display: none;">
                        <label for="area">Área:</label>
                        <select class="form-control" id="area" name="area">
                            <!-- Las áreas se llenarán aquí con jQuery -->
                        </select>

                        <!-- Elemento de carga -->
                        <div id="loading" style="display: none;">
                            <p>Cargando áreas...</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="employee_code">Código de Trabajador:</label>
                        <input type="text" class="form-control" name="employee_code"
                            placeholder="Ingrese el código del trabajador">
                    </div>
                    <div class="form-group">
                        <label for="ruc">Documento de Identidad:</label>
                        <input type="text" class="form-control" id="doi" name="doi"
                            placeholder="Ingrese su Documento de Identidad" pattern="[0-9]*" inputmode="numeric">
                        {{-- <small class="form-text text-muted small">*Solo números</small> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="{{ $id_service }}" name="id_service">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#department').change(function() {
                var departmentId = $(this).val();
                $('#area').empty();
                if (departmentId) {
                    // Mostrar el elemento de carga
                    $('#loading').show();

                    $.ajax({
                        url: '/getAreas/' + departmentId,
                        type: 'GET',
                        success: function(data) {
                            $('#area').empty();
                            $('#area').append('<option value="">Seleccione una área</option>');
                            $.each(data, function(key, value) {
                                $('#area').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                            $('#areaDiv').show();

                            // Ocultar el elemento de carga
                            $('#loading').hide();
                        }
                    });
                } else {
                    $('#area').empty();
                    $('#areaDiv').hide();
                }
            });
        });
    </script>
@endsection
