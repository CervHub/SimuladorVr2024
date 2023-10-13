@extends('base')

@section('message-primary')
Bienvenido, <span class="text-black fw-bold"></span>
@endsection

@section('message-secondary')
Panel - Administrador
@endsection

@section('sidebar')
<ul class="nav">
    <li class="nav-item" id="dashboard-administrador">
        <a class="nav-link" href="{{route('administrador')}}">
            <i class="mdi mdi-view-dashboard menu-icon"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>
    <li class="nav-item" id="entrenadores-administrador">
        <a class="nav-link" href="{{route('administrador.entrenador')}}">
            <i class="mdi mdi-office-building menu-icon"></i>
            <span class="menu-title">Entrenadores</span>
        </a>
    </li>
    <!-- <li class="nav-item" id="servicios-administrador" >
        <a class="nav-link" href="{{route('administrador.servicio')}}">
            <i class="mdi mdi-office-building menu-icon"></i>
            <span class="menu-title">Servicios</span>
        </a>
    </li> -->
    <!-- <li class="nav-item" id="servicios-administrador" >
        <a class="nav-link" href="#">
            <i class="mdi mdi-office-building menu-icon"></i>
            <span class="menu-title">Servicios</span>
        </a>
    </li>
    <li class="nav-item" id="reporte-administrador">
        <a class="nav-link" href="{{route('administrador.reporte')}}">
            <i class="mdi mdi-file-chart menu-icon"></i>
            <span class="menu-title">Reportes</span>
        </a>
    </li> -->
</ul>

@endsection