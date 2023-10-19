<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Registrar Empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('createcompany')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="firstName">Nombre:</label>
                        <input type="text" class="form-control" id="firstName" name="name" placeholder="Ingrese su nombre">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Descripción:</label>
                        <input type="text" class="form-control" id="lastName" name="description" placeholder="Ingrese descripción de la empresa">
                    </div>
                    <div class="form-group">
                        <label for="ruc">Ingrese Identificador de Empresa:</label>
                        <input type="text" class="form-control" id="ruc" name="ruc" placeholder="Ingrese Identificador de Empresa">
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