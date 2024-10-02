@extends('Administrator.main')

@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        div:where(.swal2-container) div:where(.swal2-popup) {
            padding: 1.25em !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="card rounded-0 mt-3">
                    <div class="card-body table-responsive">
                        <h4 class="card-title">Talleres Asignados</h4>
                        <table id="myTable" class="display dataTable table table-striped">
                            <thead style="background-color: #4CAF50; color: white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Alias</th>
                                    <th>Ponderado</th>
                                    <th>Nota Mínima</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $rowNumber = 1;
                                @endphp
                                @foreach ($workshop_companies as $company)
                                    <tr id="row_{{ $company->id }}" style="background-color: #f2f2f2;">
                                        <td>{{ $rowNumber++ }}</td>
                                        <td>{{ $company->alias }}</td>
                                        <td><input class="pondered_note form-control-custom p-1 text-center" type="number"
                                            value="{{ intval($company->pondered_note) ?? 0 }}"></td>
                                        <td><input class="minimum_passing_note form-control-custom p-1 text-center"
                                            type="number" value="{{ intval($company->minimum_passing_note) ?? 0 }}"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <button class="btn btn-primary float-end text-white"
                                    onclick="updateValues()">Actualizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const iconSuperAdmin = document.querySelector('#taller');
        iconSuperAdmin.classList.add('active');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function updateValues() {
            let rows = document.getElementsByTagName('tr');
            let values = [];

            for (let i = 0; i < rows.length; i++) {
                if (rows[i].id.startsWith('row_')) {
                    let id = rows[i].id.split('_')[1];
                    let ponderedNote = rows[i].getElementsByClassName('pondered_note')[0].value;
                    let minimumPassingNote = rows[i].getElementsByClassName('minimum_passing_note')[0].value;
                    values.push({
                        id: id,
                        pondered_note: ponderedNote,
                        minimum_passing_note: minimumPassingNote
                    });
                }
            }

            // Aquí puedes enviar los valores al servidor para su actualización
            console.log(values);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: '{{ route('administrador.talleres.update') }}', // Cambia esto a la URL correcta de tu servidor de ping
                type: 'POST',
                data: {
                    values: values // Agrega los valores a los datos que serán enviados
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire(
                        '¡Buen trabajo!',
                        'Los datos se han actualizado correctamente',
                        'success'
                    )
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log("Error en la conexión:", xhr.status, thrownError);
                }
            });
        }
    </script>
@endsection
