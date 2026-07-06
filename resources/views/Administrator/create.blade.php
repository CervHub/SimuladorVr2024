<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-entrenador">
            <form action="{{ route('administrador.crearentrenador') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Registrar Entrenador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-entrenador-body">
                    <div class="form-group">
                        <label for="create_name">Nombres: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="create_name" name="name"
                            placeholder="Ingrese su nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="create_last_name">Apellidos: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="create_last_name" name="last_name"
                            placeholder="Ingrese su apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="create_doi">Documento de Identidad: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="create_doi" name="doi"
                            placeholder="Ingrese su Documento de Identidad" required>
                    </div>
                    <div class="form-group">
                        <label for="create_position">Cargo (Opcional):</label>
                        <input type="text" class="form-control" id="create_position" name="position"
                            placeholder="Ingrese cargo del Entrenador">
                    </div>
                    <div class="form-group">
                        <label for="area">Área (Opcional):</label>
                        <input type="text" class="form-control" name="department"
                            placeholder="Ingrese el área del Entrenador">
                    </div>
                    <div class="form-group mb-0">
                        <label>Imagen de la Firma del Entrenador (Opcional)</label>
                        @include('Administrator.partials.signature-upload', [
                            'inputId' => 'signature',
                            'zoneId' => 'signature_create_zone',
                            'previewId' => 'preview_create',
                            'containerId' => 'preview_create_container',
                        ])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_guardar_create" disabled>Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
