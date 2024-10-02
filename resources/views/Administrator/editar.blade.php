<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Editar Entrenador </h5>
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
            <form action="{{ route('administrador.editarentrenador') }}" method="POST" id="form_entrenador"
                enctype="multipart/form-data" style="display: :none">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="firstName">Nombres:</label>
                        <input type="text" class="form-control" id="name_editar" name="name"
                            placeholder="Ingrese su nombre">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Apellidos:</label>
                        <input type="text" class="form-control" id="last_name_editar" name="last_name"
                            placeholder="Ingrese su apellido">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Cargo:</label>
                        <input type="text" class="form-control" id="position_editar" name="position"
                            placeholder="Ingrese su Cargo">
                    </div>
                    <div class="form-group">
                        <label for="ruc">DOI:</label>
                        <input type="text" class="form-control" id="doi_editar" name="doi"
                            placeholder="Ingrese su Documento de Indentidad" pattern="[0-9]*" inputmode="numeric"
                            disabled>
                        <small class="form-text text-muted small">*Solo números</small>
                    </div>
                    <div class="form-group">
                        <label for="area">Área(Opcional):</label>
                        <input type="text" class="form-control" id="department_editar" name="department"
                            placeholder="Ingrese el área del Entrenador">
                    </div>
                    <div class="form-group">
                        <label for="signature_image">Imagen de la Firma del Entrenador:</label>
                        <p>Las dimensiones de la imagen deben ser 700x400 y no más de 1MB</p>
                        <input type="file" class="form-control-file" name="signature" id="signature_edit">
                    </div>
                    <div class="d-flex justify-content-center">
                        <img id="preview" src="https://eltapin.com/images/sin_imagen.jpg"
                            alt="Previsualización de la firma" style="max-height: 200px;">
                    </div>
                    <input type="hidden" name="id_worker" id="id_worker_editar" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
