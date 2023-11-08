<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Editar Inducción </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('entrenador.update.induction')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="course">Taller:</label>
                        <select class="form-control" id="course" name="course" disabled>
                            @foreach($workshops as $workshop)
                            <option value="{{$workshop->id}}">{{$workshop->alias}}</option>
                            @endforeach
                            <!-- Agrega más opciones de cursos según sea necesario -->
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="startDate">Fecha de inicio:</label>
                            <input type="date" class="form-control" id="startDate" name="start_date">
                        </div>
                        <div class="col-md-6">
                            <label for="startTime">Hora de inicio:</label>
                            <input type="time" class="form-control" id="startTime" name="start_time">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="endDate">Fecha de término:</label>
                            <input type="date" class="form-control" id="endDate" name="end_date">
                        </div>
                        <div class="col-md-6">
                            <label for="endTime">Hora de término:</label>
                            <input type="time" class="form-control" id="endTime" name="end_time">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="status">Intentos:</label>
                            <input type="number" id="intentos" class="form-control" name="intentos">
                        </div>
                        <div class="col-md-6">
                            <label for="status">Estado:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_induction" id="edit_id_induction">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>