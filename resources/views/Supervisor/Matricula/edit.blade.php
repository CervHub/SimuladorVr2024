<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-entrenador position-relative">
            <div id="loading-overlay" class="modal-entrenador-loading" style="display: none;">
                <div class="text-center py-5">
                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                </div>
            </div>
            <form action="{{ route('matricula.edituser') }}" method="POST" id="form-edit"
                enctype="multipart/form-data" style="display: none;">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Trabajador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-entrenador-body">
                    <input type="hidden" name="worker_id" id="worker_id_editar" value="">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="name_editar">Nombre:</label>
                                <input type="text" class="form-control" name="name" id="name_editar"
                                    placeholder="Ingrese su nombre">
                            </div>
                            <div class="form-group">
                                <label for="last_name_editar">Apellido:</label>
                                <input type="text" class="form-control" name="last_name" id="last_name_editar"
                                    placeholder="Ingrese su apellido">
                            </div>
                            <div class="form-group">
                                <label for="position_editar">Cargo:</label>
                                <input type="text" class="form-control" name="position" id="position_editar"
                                    placeholder="Ingrese su cargo">
                            </div>
                            <div class="form-group">
                                <label for="employee_code_editar">Código de Trabajador (Opcional):</label>
                                <input type="text" class="form-control" name="employee_code" id="employee_code_editar"
                                    placeholder="Ingrese el código del trabajador">
                            </div>
                            <div class="form-group">
                                <label for="celular_editar">Número de Celular (Opcional):</label>
                                <input type="text" class="form-control" name="celular" id="celular_editar"
                                    placeholder="Ingrese el número de celular">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="dni_editar">Documento de Identidad (Referencial):</label>
                                <input type="text" class="form-control" name="dni" id="dni_editar" readonly>
                            </div>
                            <div class="form-group">
                                <label for="license_number_editar">Número de Licencia (Opcional):</label>
                                <input type="text" class="form-control" id="license_number_editar" name="license_number"
                                    placeholder="Ingrese el número de licencia">
                            </div>
                            <div class="form-group">
                                <label for="license_category_editar">Categoría de Brevet (Opcional):</label>
                                <select class="form-control" id="license_category_editar" name="license_category">
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
                                    'hiddenInputId' => 'photo_base64_editar',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
