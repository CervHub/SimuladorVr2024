<!-- Modal -->
<div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleModalLabel">Detalles de la Compañía</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Contenido de los detalles de la compañía -->

                <p><strong>ID:</strong> <span id="id_detalle"></span></p>
                <p><strong>Nombres:</strong> <span id="name_detalle"></span></p>
                <p><strong>Apellidos:</strong> <span id="last_name_detalle"></span></p>
                <p><strong>DOI:</strong> <span id="doi_detalle"></span></p>
                <hr>
                <p><strong>Codigo de Acceso:</strong> <span id="codigo_detalle"></span></p>
                <p><strong>Contraseña:</strong> <span id="password_detalle"></span></p>

            </div>
            <div class="modal-footer">
                <button id="copyButton" class="btn btn-primary">Copiar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>