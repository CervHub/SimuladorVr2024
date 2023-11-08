<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Crear Capacitación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('entrenador.crearinduction')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="course">Teller:</label>
                        <input type="hidden" value="" name="alias" id="alias">
                        <select class="form-control" name="course" id="course">
                            @foreach($workshops as $workshop)
                            <option value="{{$workshop->id_workshop}}">{{$workshop->alias}}</option>
                            @endforeach
                            <!-- Agrega más opciones de cursos según sea necesario -->
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="startDate">Fecha de inicio:</label>
                            <input type="date" class="form-control" name="start_date">
                        </div>
                        <div class="col-md-6">
                            <label for="startTime">Hora de inicio:</label>
                            <input type="time" class="form-control" name="start_time">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="endDate">Fecha de término:</label>
                            <input type="date" class="form-control" name="end_date">
                        </div>
                        <div class="col-md-6">
                            <label for="endTime">Hora de término:</label>
                            <input type="time" class="form-control" name="end_time">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="status">Intentos:</label>
                            <input type="number" class="form-control" name="intentos">
                        </div>
                        <div class="col-md-6">
                            <label for="status">Estado:</label>
                            <select class="form-control" name="status">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

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
<script>
    // Espera a que se cargue la página
    document.addEventListener("DOMContentLoaded", function() {
        // Obtiene el elemento select y el campo oculto
        const selectCurso = document.getElementById("course");
        const inputAlias = document.getElementById("alias");

        // Obtiene el alias del primer elemento de la lista desplegable
        const aliasPredeterminado = selectCurso.options[0].text;
        inputAlias.value = aliasPredeterminado; // Establece el alias por defecto

        // Agrega un evento para detectar cambios en el elemento select
        selectCurso.addEventListener("change", function() {
            // Obtiene el alias del curso seleccionado
            const aliasSeleccionado = selectCurso.options[selectCurso.selectedIndex].text;
            inputAlias.value = aliasSeleccionado; // Actualiza el alias
        });
    });
</script>