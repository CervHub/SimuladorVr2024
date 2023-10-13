@extends('SuperAdmin.main')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css" rel="stylesheet">

@endsection

@section('content')
<div class="row flex-grow">

    <div class="col-md-8 col-lg-8 grid-margin stretch-card">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="profile-header d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <img src="{{Auth::user()->photo}}" width="52px" alt="Profile Picture" class="profile-picture rounded-circle">
                    </div>
                </div>

                <div class="profile-form">
                    <h5 class="mb-3">Editar Perfil</h5>
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{route('updateperfil')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="firstName" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value="{{Auth::user()->name}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="{{Auth::user()->last_name}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jobTitle" class="form-label">Cargo</label>
                            <input type="text" class="form-control" id="jobTitle" name="jobTitle" value="{{$foundWorker->position}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="profilePicture" class="form-label">Foto de Perfil</label>
                            <input type="file" class="form-control-file" id="profilePicture" name="profilePicture">
                        </div>
                        <input type="hidden" name="id_user" value="{{Auth::user()->id}}">
                        <input type="hidden" name="id_worker" value="{{$foundWorker->id}}">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-lg-4 grid-margin stretch-card">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="card-title card-title-dash">Cambiar Contraseña</h4>
                            </div>
                        </div>
                        <form action="{{route('updatepassword')}}" method="POST">
                            @csrf
                            <div class="mt-3">
                                <div class="mb-3">
                                    <label for="oldPassword" class="form-label">Contraseña Antigua</label>
                                    <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">Nueva Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword" style="padding:0;">
                                            <i class="mdi mdi-eye-off" style="padding-left: 10px; padding-right:10px;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirmar Nueva Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                        <button type="button" class="btn btn-outline-secondary text-success" id="toggleConfirmPassword" style="padding:0;">
                                            <i class="mdi mdi-eye-off" style="padding-left: 10px; padding-right:10px;"></i>
                                        </button>
                                    </div>
                                </div>
                                <p id="passwordMessage" class="text-danger"></p>
                                <input type="hidden" name="id_user" value="{{Auth::user()->id}}">
                                <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')
<script>
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

    togglePassword.addEventListener('click', togglePasswordVisibility);
    toggleConfirmPassword.addEventListener('click', toggleConfirmPasswordVisibility);

    function togglePasswordVisibility() {
        newPassword.type = newPassword.type === 'password' ? 'text' : 'password';
    }

    function toggleConfirmPasswordVisibility() {
        confirmPassword.type = confirmPassword.type === 'password' ? 'text' : 'password';
    }

    newPassword.addEventListener('input', validatePasswords);
    confirmPassword.addEventListener('input', validatePasswords);

    function validatePasswords() {
        if (newPassword.value === confirmPassword.value) {
            passwordMessage.textContent = '';
        } else {
            passwordMessage.textContent = 'Las contraseñas no coinciden';
        }
    }
</script>
@endsection