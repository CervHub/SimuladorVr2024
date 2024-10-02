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

            <!-- Capa de superposición con icono de carga -->
            <div id="loading-overlay" style="display: none;">
                <div class="modal-body text-center">
                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                </div>
            </div>
            <form action="{{route('superadministrador.editar.taller.company')}}" method="POST" id="form-edit">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Taller:</label>
                        <!-- <select class="form-control js-example-basic-single" id="workshop_editar" name="id_workshop">
                            @foreach($workshops as $workshop)
                            <option value="{{$workshop->id}}">{{$workshop->name}}</option>
                            @endforeach
                        </select> -->
                        <input type="text" class="form-control" id="workshop_editar" name="id_workshop" readonly>
                    </div>
                    <div class="form-group">
                        <label for="firstName">Nombre:</label>
                        <input type="text" class="form-control" id="alias_editar" name="alias" placeholder="Ingrese su nombre">
                    </div>
                    <div class="form-group">
                        <label for="status_editar">Estado:</label>
                        <select class="form-control" id="status_editar" name="status">
                            <option value="0">No activo</option>
                            <option value="1">Activo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_workshop_company" id="id_workshop_company" value="">
                    <input type="hidden" name="id_company" value="{{$company->id}}">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>