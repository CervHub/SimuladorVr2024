<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Registrar Entrenador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('administrador.crearentrenador')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="firstName">Nombres:</label>
                        <input type="text" class="form-control" name="name" placeholder="Ingrese su nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Apellidos:</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Ingrese su apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="ruc">Documento de Identidad:</label>
                        <input type="text" class="form-control" name="doi" placeholder="Ingrese su Documento de Identidad" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Cargo:</label>
                        <input type="text" class="form-control" name="position" placeholder="Ingrese cargo del Entrenador" required>
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