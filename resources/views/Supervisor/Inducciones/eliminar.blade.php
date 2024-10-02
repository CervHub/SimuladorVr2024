<!-- Modal -->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="eliminarModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('entrenador.induccion.eliminar') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarModal">Eliminar Simulación Programada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Contenido de los detalles de la compañía -->

                    <p><strong>ID:</strong> <span id="id_eliminar"></span></p>
                    <p><strong>Alias:</strong> <span id="alias_eliminar"></span></p>
                    <p><strong>Número de Trabajadores:</strong> <span id="num_eliminar"></span></p>

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id_eliminar_submit" name="id_induction" value="">
                    <!-- Agregamos campos ocultos para el alias y el número de trabajadores -->
                    <input type="hidden" id="alias_eliminar_submit" name="alias" value="">
                    <input type="hidden" id="num_eliminar_submit" name="num_trabajadores" value="">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>