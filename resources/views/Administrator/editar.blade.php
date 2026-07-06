<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-entrenador position-relative">
            <div id="loading-overlay" class="modal-entrenador-loading" style="display: none;">
                <div class="text-center py-5">
                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                </div>
            </div>
            <form action="{{ route('administrador.editarentrenador') }}" method="POST" id="form_entrenador"
                enctype="multipart/form-data" style="display: none">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Entrenador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-entrenador-body">
                    <div class="form-group">
                        <label for="name_editar">Nombres: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name_editar" name="name"
                            placeholder="Ingrese su nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name_editar">Apellidos: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="last_name_editar" name="last_name"
                            placeholder="Ingrese su apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Cargo:</label>
                        <input type="text" class="form-control" id="position_editar" name="position"
                            placeholder="Ingrese su Cargo">
                    </div>
                    <div class="form-group">
                        <label for="doi_editar">Documento de Identidad: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="doi_editar" name="doi"
                            placeholder="Ingrese su Documento de Indentidad" pattern="[0-9]*" inputmode="numeric"
                            disabled required>
                        <small class="form-text text-muted small">*Solo números</small>
                    </div>
                    <div class="form-group">
                        <label for="area">Área(Opcional):</label>
                        <input type="text" class="form-control" id="department_editar" name="department"
                            placeholder="Ingrese el área del Entrenador">
                    </div>
                    <div class="form-group mb-0">
                        <label>Imagen de la Firma del Entrenador (Opcional)</label>
                        @include('Administrator.partials.signature-upload', [
                            'inputId' => 'signature_edit',
                            'zoneId' => 'signature_edit_zone',
                            'previewId' => 'preview',
                            'containerId' => 'preview_container',
                        ])
                    </div>
                    <input type="hidden" name="id_worker" id="id_worker_editar" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_guardar_edit" disabled>Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
