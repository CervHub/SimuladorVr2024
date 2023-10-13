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
            <form action="{{route('entrenador.editarservicio')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="firstName">Nombre:</label>
                        <input type="text" class="form-control" id="name_editar" name="name" placeholder="Ingrese su nombre">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Descripcion:</label>
                        <input type="text" class="form-control" id="description_editar" name="description" placeholder="Ingrese su apellido">
                    </div>
                    <div class="form-group">
                        <label for="ruc">RUC:</label>
                        <input type="text" class="form-control" id="ruc_editar" name="ruc" placeholder="Ingrese su RUC" pattern="[0-9]*" inputmode="numeric" disabled>
                        <small class="form-text text-muted small">*Solo números</small>
                    </div>
                    <input type="hidden" name="id_service" id="id_service_editar" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>