<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Registrar Trabajador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('matricula.crearuser') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="firstName">Nombre:</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Ingrese su nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Apellido:</label>
                                    <input type="text" class="form-control" name="last_name"
                                        placeholder="Ingrese su apellido" required>
                                </div>
                                <div class="form-group">
                                    <label for="position">Cargo:</label>
                                    <input type="text" class="form-control" name="position"
                                        placeholder="Ingrese su Cargo" required>
                                </div>
                                <div class="form-group">
                                    <label for="department">Gerencia: (Opcional)</label>
                                    <select class="form-control" id="department" name="department">
                                        <option value="">Seleccione un departamento</option>
                                        @foreach ($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}">{{ $departamento->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="areaDiv" style="display: none;">
                                    <label for="area">Departamento:</label>
                                    <select class="form-control" id="area" name="area">
                                        <!-- Las áreas se llenarán aquí con jQuery -->
                                    </select>
                                    <!-- Elemento de carga -->
                                    <div id="loading" style="display: none;">
                                        <p>Cargando Departamentos...</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee_code">Código de Trabajador (Opcional):</label>
                                    <input type="text" class="form-control" name="employee_code"
                                        placeholder="Ingrese el código del trabajador">
                                </div>
                                <div class="form-group">
                                    <label for="cellphone_number">Número de Celular (Opcional):</label>
                                    <input type="text" class="form-control" name="celular"
                                        placeholder="Ingrese el número de celular">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="doi">Documento de Identidad:</label>
                                    <input type="text" class="form-control" id="doi" name="doi"
                                        placeholder="Ingrese su Documento de Identidad" pattern="[0-9]*"
                                        inputmode="numeric" required>
                                </div>
                                <div class="form-group">
                                    <label for="license_number">Número de Licencia (Opcional):</label>
                                    <input type="text" class="form-control" id="license_number" name="license_number"
                                        placeholder="Ingrese el número de licencia">
                                </div>
                                <div class="form-group">
                                    <label for="license_category">Categoría de Brevet (Opcional):</label>
                                    <select class="form-control" id="license_category" name="license_category">
                                        <option value="">Seleccione una categoría</option>
                                        <option value="A-I">A-I</option>
                                        <option value="A-IIa">A-IIa</option>
                                        <option value="A-IIb">A-IIb</option>
                                        <option value="A-IIIa">A-IIIa</option>
                                        <option value="A-IIIb">A-IIIb</option>
                                        <option value="A-IIIc">A-IIIc</option>
                                        <option value="B-I">B-I</option>
                                        <option value="B-IIa">B-IIa</option>
                                        <option value="B-IIb">B-IIb</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Foto (Opcional):</label>
                                    <br>
                                    <button type="button" class="btn btn-primary mt-2" id="takePhotoBtn">Tomar
                                        Foto</button>
                                    <br>
                                    <div id="camera"
                                        style="display: none; text-align: center; margin-top: 10px; width: 320px; height: 240px;">
                                    </div>
                                    <canvas id="canvas"
                                        style="display: none; margin: 10px auto; border: 1px solid #ccc; width: 320px; height: 240px;"></canvas>
                                    <input type="hidden" id="photo_base64" name="photo_base64">
                                </div>

                            </div>
                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
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

            $('#takePhotoBtn').click(function() {
                $('#camera').show();
                $('#canvas').hide();
                Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });
                Webcam.attach('#camera');

                $(this).text('Capturar Foto').off('click').on('click', function() {
                    Webcam.snap(function(data_uri) {
                        $('#camera').hide();
                        $('#canvas').show();
                        var canvas = document.getElementById('canvas');
                        var context = canvas.getContext('2d');
                        var img = new Image();
                        img.onload = function() {
                            canvas.width = img.width;
                            canvas.height = img.height;
                            context.drawImage(img, 0, 0);
                        };
                        img.src = data_uri;
                        $('#photo_base64').val(data_uri);

                        // Cambiar el texto del botón y la funcionalidad para tomar de nuevo
                        $('#takePhotoBtn').text('Tomar de Nuevo').off('click').on('click',
                            function() {
                                $('#canvas').hide();
                                $('#camera').show();
                                Webcam.attach('#camera');
                                $(this).text('Capturar Foto').off('click').on('click',
                                    function() {
                                        Webcam.snap(function(data_uri) {
                                            $('#camera').hide();
                                            $('#canvas').show();
                                            var canvas = document
                                                .getElementById('canvas');
                                            var context = canvas.getContext(
                                                '2d');
                                            var img = new Image();
                                            img.onload = function() {
                                                canvas.width = img
                                                    .width;
                                                canvas.height = img
                                                    .height;
                                                context.drawImage(img,
                                                    0, 0);
                                            };
                                            img.src = data_uri;
                                            $('#photo_base64').val(
                                                data_uri);
                                        });
                                    });
                            });
                    });
                });
            });
        });
    </script>
@endsection
