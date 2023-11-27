@extends('base')

@section('message-primary')
    Bienvenido, <span class="welcome-text fw-bold">{{ Auth::user()->name }}</span>
    <!-- Bienvenido, <span class="welcome-text fw-bold">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</span> -->
@endsection

@section('message-secondary')
    Panel - Administrador
@endsection

@section('sidebar')
    <ul class="nav">
        <li class="nav-item" id="dashboard-administrador">
            <a class="nav-link" href="{{ route('administrador') }}">
                <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item" id="entrenadores-administrador">
            <a class="nav-link" href="{{ route('administrador.entrenador') }}">
                <i class="mdi mdi-account-group-outline menu-icon"></i>
                <span class="menu-title">Entrenadores</span>
            </a>
        </li>
        <li class="nav-item" id="taller">
            <a class="nav-link" href="{{ route('administrador.talleres') }}">
                <i class="mdi mdi-notebook-outline menu-icon"></i>
                <span class="menu-title">Taller - Notas</span>
            </a>
        </li>

    </ul>
@endsection
