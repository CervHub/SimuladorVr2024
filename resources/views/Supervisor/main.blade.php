@extends('base')

@section('message-primary')
    Bienvenido, <span class="welcome-text fw-bold">{{ Auth::user()->getWorkerById(session('id_worker'))->nombre }}
        {{ Auth::user()->getWorkerById(session('id_worker'))->apellido }}</span>
@endsection

@section('message-secondary')
    Panel - Entrenador
@endsection

@section('sidebar')
    <ul class="nav">
        <li class="nav-item" id="dashboard-supervisor">
            <a class="nav-link" href="{{ route('entrenador') }}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item" id="servicio-supervisor">
            <a class="nav-link" href="{{ route('entrenador.servicio') }}">
                <i class="mdi mdi-office-building menu-icon"></i>
                <span class="menu-title">Servicios</span>
            </a>
        </li>
        <li class="nav-item" id="taller-supervisor">
            <a class="nav-link" href="{{ route('entrenador.induccion') }}">
                <i class="mdi mdi-table-plus menu-icon"></i>
                <span class="menu-title">Talleres</span>
            </a>
        </li>

        <li class="nav-item" id="reporte-supervisor">
            <a class="nav-link" href="{{ route('entrenador.reporte') }}">
                <i class="mdi mdi-file-chart menu-icon"></i>
                <span class="menu-title">Reportes</span>
            </a>
        </li>
    </ul>
@endsection
