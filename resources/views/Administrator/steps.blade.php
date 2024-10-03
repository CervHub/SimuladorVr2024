@extends('Administrator.main')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .card-header {
            background: transparent;
        }

        .step-info {
            width: 80%;
        }

        .step-duration {
            width: 20%;
        }

        .card {
            height: 100%;
        }

        .card-body {
            font-weight: 300;
            /* Thinner font weight */
        }

        .swal2-icon {
            margin-top: 20px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row">
            @foreach ($steps as $workshop)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h4 class="card-title mt-3">{{ $workshop['name'] }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @foreach ($workshop['steps'] as $subStep)
                                    <div
                                        class="list-group-item step-item d-flex justify-content-between align-items-center">
                                        <div class="step-info">
                                            <p class="mb-1">{{ $subStep['name'] }}</p>
                                        </div>
                                        <div class="step-duration">
                                            <input class="duration form-control text-center" type="number"
                                                value="{{ $subStep['duration'] }}" data-id="{{ $subStep['id'] }}"
                                                data-original="{{ $subStep['duration'] }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-3">
            <div class="col-sm-12">
                <button class="btn btn-primary float-end" id="updateButton">Actualizar</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const iconSuperAdmin = document.querySelector('#steps');
        iconSuperAdmin.classList.add('active');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var steps = {!! json_encode($steps) !!};
        console.log('Steps: ', steps);

        let changedSteps = [];

        document.querySelectorAll('.duration').forEach(input => {
            input.addEventListener('change', function() {
                const stepId = this.dataset.id;
                const newDuration = this.value;
                const originalDuration = this.dataset.original;

                const stepIndex = changedSteps.findIndex(step => step.id == stepId);
                if (newDuration != originalDuration) {
                    if (stepIndex > -1) {
                        changedSteps[stepIndex].duration = newDuration;
                    } else {
                        changedSteps.push({
                            id: stepId,
                            duration: newDuration
                        });
                    }
                } else {
                    if (stepIndex > -1) {
                        changedSteps.splice(stepIndex, 1);
                    }
                }
            });
        });

        $('#updateButton').on('click', function() {
            if (changedSteps.length > 0) {
                Swal.fire({
                    title: 'Actualizando...',
                    text: 'Por favor, espere.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '{{ route('administrador.talleres.updatesteps') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        steps: changedSteps
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Pasos actualizados',
                            text: 'Los pasos han sido actualizados correctamente.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });

                        // Update the original values to the new values
                        changedSteps.forEach(step => {
                            const input = document.querySelector(`.duration[data-id='${step.id}']`);
                            input.dataset.original = step.duration;
                        });

                        changedSteps = [];
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al actualizar los pasos.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'Sin cambios',
                    text: 'No hay cambios para actualizar.',
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
@endsection
