<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Inscribir Trabajador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('entrenador.inscribir')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="service">Servicio:</label>
                        <select class="form-control" id="service" name="service">
                            <option value="">Seleccionar Servicio</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ruc">Documento de Identidad:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="doi" name="doi" placeholder="Ingrese su Documento de Identidad" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm rounded-2" type="button" onclick="search()">
                                    <i class="icon-search"></i> <!-- Icono de búsqueda aquí -->
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted small">*Solo números</small> <br>
                        <small class="form-text text-warning small" id="mensaje_error"></small>
                    </div>
                    <div class="form-group">
                        <label for="firstName">Nombre:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese su nombre" disabled>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Apellido:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Ingrese su apellido" disabled>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Cargo:</label>
                        <input type="text" class="form-control" id="position" name="position" placeholder="Ingrese su apellido" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="{{$id_induction}}" name="id_induction">
                    <input type="hidden" value="" name="id_worker" id="id_worker">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Inscribir</button>
                </div>
            </form>
        </div>
    </div>
</div>