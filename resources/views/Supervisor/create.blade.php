<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Registrar Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('entrenador.crearservicio') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-3"><span class="text-danger">*</span> Campos obligatorios</p>
                    <div class="form-group">
                        <label for="create_service_name">Nombre: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="create_service_name" name="name"
                            placeholder="Ingrese nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="create_service_description">Descripción: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="create_service_description" name="description"
                            placeholder="Ingrese su descripción" required>
                    </div>
                    <div class="form-group mb-0">
                        <label for="create_service_ruc">Identificador de Empresa: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="create_service_ruc" name="ruc"
                            placeholder="Ingrese identificador de empresa" pattern="[0-9]*" inputmode="numeric" required>
                        <small class="form-text text-muted">Solo números</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_guardar_servicio" disabled>Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
