<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Crear Taller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadministrador.create.taller') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" class="form-control" name="name" placeholder="Ingrese su nombre">
                    </div>
                    <div class="form-group">
                        <label>Descripción:</label>
                        <input type="text" class="form-control" name="description" placeholder="Ingrese Descripción">
                    </div>
                    <div class="form-group">
                        <label>Subir Imagen:</label>
                        <input type="file" class="form-control-file" name="image" accept="image/*">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>