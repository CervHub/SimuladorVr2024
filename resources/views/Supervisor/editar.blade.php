<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Editar Servicio </h5>
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
            <form action="{{route('entrenador.editarservicio')}}" method="POST" id="form-edit">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-3"><span class="text-danger">*</span> Campos obligatorios</p>
                    <div class="form-group">
                        <label for="name_editar">Nombre: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name_editar" name="name"
                            placeholder="Ingrese nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="description_editar">Descripción: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="description_editar" name="description"
                            placeholder="Ingrese su descripción" required>
                    </div>
                    <div class="form-group mb-0">
                        <label for="ruc_editar">Identificador de Empresa: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ruc_editar" name="ruc"
                            placeholder="Ingrese su RUC" pattern="[0-9]*" inputmode="numeric" disabled>
                    </div>
                    <input type="hidden" name="id_service" id="id_service_editar" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_guardar_servicio_edit" disabled>Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>