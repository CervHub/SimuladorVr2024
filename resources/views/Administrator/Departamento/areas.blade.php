@extends('Administrator.main')

@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div>
                        <div class="btn-wrapper">
                            <a href="#" class="btn btn-primary text-white p-3" data-toggle="modal"
                                data-target="#createModal"><i class="icon-plus"></i> Crear área</a>
                        </div>
                    </div>
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif

                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div>
                        <div class="btn-wrapper">
                            <label for="recordsPerPage">Mostrar:</label>
                            <select id="recordsPerPage" class="me-3 form-control-custom p-1">
                                <option value="0">0</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 mb-3 ">
                        <label for="customSearchInput">Buscar:</label>
                        <input type="text" id="customSearchInput" class="form-control-custom p-1" placeholder="">

                    </div>
                </div>

                <div class="card rounded-0 mt-3">
                    <div class="card-body table-responsive">
                        <h4 class="card-title">Áreas</h4>
                        <table id="myTable" class="display dataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombres</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $area)
                                    <tr>
                                        <td>{{ $area->id }}</td>
                                        <td>{{ $area->name }}</td>
                                        <td>
                                            <button class="btn btn-custom btn-warning text-white me-0" data-toggle="modal"
                                                data-target="#editModal" onclick="editar({{ $area->id }})">
                                                <span class="icon icon-pencil"></span> Editar
                                            </button>
                                            {{-- <button class="btn btn-custom btn-danger text-white me-0" data-toggle="modal"
                                                data-target="#deleteModal" onclick="eliminar({{ $area->id }})">
                                                <span class="icon icon-trash"></span> Eliminar
                                            </button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Administrator.Departamento.creararea')
    @include('Administrator.Departamento.areaedit')
@endsection


@section('js')
    <script>
        const iconSuperAdmin = document.querySelector('#departamento');
        iconSuperAdmin.classList.add('active');

        function editar(id) {

            console.log(id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: '{{ route('administrador.areas.search') }}', // Cambia esto a la URL correcta de tu servidor de ping
                type: 'POST',
                data: {
                    id: id // Agrega el ID a los datos que serán enviados
                },
                success: function(response) {
                    console.log(response);
                    $('#name').val(response.name);
                    $('#id').val(response.id);
                    $('#createEdit').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log("Error en la conexión:", xhr.status, thrownError);
                }
            });
        }
    </script>
@endsection
