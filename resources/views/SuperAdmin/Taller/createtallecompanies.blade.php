<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Asignar Taller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('superadministrador.createtallercompanies')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Taller:</label>
                        <select class="form-control js-example-basic-single" name="id_workshop">
                            @foreach($workshops as $workshop)
                            <option value="{{$workshop->id}}">{{$workshop->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alias:</label>
                        <input type="text" class="form-control" name="alias" placeholder="Ingrese su Alias" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_company" value="{{$company->id}}">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>