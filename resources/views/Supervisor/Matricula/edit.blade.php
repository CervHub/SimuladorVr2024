<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Editar Trabajador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Capa de superposición con icono de carga -->
            <div id="loading-overlay" style="display: none;">
                <div class="modal-body text-center">
                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                </div>
            </div>
            <form action="{{ route('matricula.edituser') }}" method="POST" id="form-edit"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="worker_id" id="worker_id_editar" value="">
                    <div class="form-group">
                        <label for="firstName">Nombre:</label>
                        <input type="text" class="form-control" name="name" id="name_editar"
                            placeholder="Ingrese su nombre">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Apellido:</label>
                        <input type="text" class="form-control" name="last_name" id="last_name_editar"
                            placeholder="Ingrese su apellido">
                    </div>
                    <div class="form-group">
                        <label for="position">Cargo:</label>
                        <input type="text" class="form-control" name="position" id="position_editar"
                            placeholder="Ingrese su cargo">
                    </div>
                    <div class="form-group">
                        <label for="employee_code">Código de Trabajador: (Opcional)</label>
                        <input type="text" class="form-control" name="employee_code" id="employee_code_editar"
                            placeholder="Ingrese el código del trabajador">
                    </div>
                    <div class="form-group">
                        <label for="cellphone_number">Número de Celular: (Opcional)</label>
                        <input type="text" class="form-control" name="celular" id="celular_editar"
                            placeholder="Ingrese el número de celular">
                    </div>
                    <div class="form-group">
                        <label for="dni">Documento de Identidad (Referencial):</label>
                        <input type="text" class="form-control" name="dni" id="dni_editar" readonly>
                    </div>
                    <div class="form-group">
                        <label for="license_number">Número de Licencia (Opcional):</label>
                        <input type="text" class="form-control" id="license_number_editar" name="license_number"
                            placeholder="Ingrese el número de licencia">
                    </div>
                    <div class="form-group">
                        <label for="license_category">Categoría de Brevet (Opcional):</label>
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
                    <div class="form-group">
                        <label for="photo">Foto (Opcional):</label>
                        <br>
                        <button type="button" class="btn btn-primary mt-2" id="takePhotoBtnEdit">Tomar Foto</button>
                        <br>
                        <div id="cameraEdit"
                            style="display: none; text-align: center; margin-top: 10px; width: 320px; height: 240px;">
                        </div>
                        <canvas id="canvasEdit"
                            style="display: none; margin: 10px auto; border: 1px solid #ccc; width: 320px; height: 240px;"></canvas>
                        <input type="hidden" id="photo_base64_editar" name="photo_base64">
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

