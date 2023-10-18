<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Editar Taller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('superadministrador.editar.taller')}}" method="POST" enctype="multipart/form-data">
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
                        <label for="status_editar">Estado:</label>
                        <select class="form-control" id="status_editar" name="status">
                            <option value="0">No activo</option>
                            <option value="1">Activo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Subir Imagen (Relación de aspecto 16:9, máximo 1MB):</label><br>
                        <input type="file" class="form-control-file" name="image" accept="image/*" id="imageInputEdit">
                    </div>
                    <div class="form-group text-center">
                        <img src="" alt="Preview" id="imagePreviewEdit" class="mt-3 text-center" style="border-radius:25px; max-width: 100%; max-height: 200px;">
                    </div>
                    <input type="hidden" name="id_workshop" id="id_workshop_editar" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript para mostrar la vista previa de la imagen seleccionada
    document.getElementById('imageInputEdit').addEventListener('change', function(e) {
        var imagePreview = document.getElementById('imagePreviewEdit');
        imagePreview.src = URL.createObjectURL(e.target.files[0]);
    });
</script>