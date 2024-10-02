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
                        <label>Subir Imagen (Relación de aspecto 16:9, máximo 1MB):</label><br>
                        <input type="file" class="form-control-file" name="image" accept="image/*" id="imageInput">
                    </div>
                    <div class="form-group text-center">
                        <img src="{{asset('sin-imagen.jpg')}}" alt="Preview" id="imagePreview" class="mt-3 text-center" style="border-radius:25px; max-width: 100%; max-height: 200px;">
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

<script>
    // JavaScript para mostrar la vista previa de la imagen seleccionada
    document.getElementById('imageInput').addEventListener('change', function(e) {
        var imagePreview = document.getElementById('imagePreview');
        imagePreview.src = URL.createObjectURL(e.target.files[0]);
    });
</script>