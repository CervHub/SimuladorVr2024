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
            <form action="{{route('administrador.editarentrenador')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="firstName">Nombres:</label>
                        <input type="text" class="form-control" id="name_editar" name="name" placeholder="Ingrese su nombre">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Apellidos:</label>
                        <input type="text" class="form-control" id="last_name_editar" name="last_name" placeholder="Ingrese su apellido">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Cargo:</label>
                        <input type="text" class="form-control" id="position_editar" name="position" placeholder="Ingrese su Cargo">
                    </div>
                    <div class="form-group">
                        <label for="ruc">DOI:</label>
                        <input type="text" class="form-control" id="doi_editar" name="doi" placeholder="Ingrese su Documento de Indentidad" pattern="[0-9]*" inputmode="numeric" disabled>
                        <small class="form-text text-muted small">*Solo números</small>
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