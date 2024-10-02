<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('eliminarCompany')}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleModalLabel">Detalles de la Compañía</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Contenido de los detalles de la compañía -->

                    <p><strong>ID:</strong> <span id="id_eliminar"></span></p>
                    <p><strong>Empresa:</strong> <span id="nombre_eliminar"></span></p>
                    <p><strong>Descripción:</strong> <span id="descripcion_eliminar"></span></p>
                    <p><strong>RUC:</strong> <span id="ruc_eliminar"></span></p>
                    <hr>
                    <p><strong>Codigo de Acceso:</strong> <span id="codigo_eliminar"></span></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id_eliminar_submit" name="id_company" value="">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </form>
    </div>
</div>