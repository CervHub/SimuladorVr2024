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
            <form action="{{route('matricula.edituser')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="worker_id" id="worker_id_editar" value="">
                    <div class="form-group">
                        <label for="firstName">Nombre:</label>
                        <input type="text" class="form-control" name="name" id="name_editar" placeholder="Ingrese su nombre">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Apellido:</label>
                        <input type="text" class="form-control" name="last_name" id="last_name_editar" placeholder="Ingrese su apellido">
                    </div>
                    <div class="form-group">
                        <label for="position">Cargo:</label>
                        <input type="text" class="form-control" name="position" id="position_editar" placeholder="Ingrese su cargo">
                    </div>
                    <div class="form-group">
                        <label for="dni">Documento de Identidad (Referencial):</label>
                        <input type="text" class="form-control" name="dni" id="dni_editar" readonly>
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