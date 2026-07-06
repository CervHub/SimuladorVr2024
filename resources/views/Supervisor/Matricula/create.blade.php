<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-entrenador">
            <form action="{{ route('matricula.crearuser') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Registrar Trabajador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-entrenador-body">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="create_name">Nombre:</label>
                                <input type="text" class="form-control" id="create_name" name="name"
                                    placeholder="Ingrese su nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="create_last_name">Apellido:</label>
                                <input type="text" class="form-control" id="create_last_name" name="last_name"
                                    placeholder="Ingrese su apellido" required>
                            </div>
                            <div class="form-group">
                                <label for="create_position">Cargo:</label>
                                <input type="text" class="form-control" id="create_position" name="position"
                                    placeholder="Ingrese su Cargo" required>
                            </div>
                            <div class="form-group">
                                <label for="department">Gerencia (Opcional):</label>
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
                                </select>
                                <div id="loading" class="area-loading" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> Cargando departamentos...
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="employee_code">Código de Trabajador (Opcional):</label>
                                <input type="text" class="form-control" id="employee_code" name="employee_code"
                                    placeholder="Ingrese el código del trabajador">
                            </div>
                            <div class="form-group">
                                <label for="cellphone_number">Número de Celular (Opcional):</label>
                                <input type="text" class="form-control" id="cellphone_number" name="celular"
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
                            <div class="form-group mb-0">
                                <label>Foto (Opcional)</label>
                                @include('Administrator.partials.photo-capture', [
                                    'hiddenInputId' => 'photo_base64',
                                ])
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
