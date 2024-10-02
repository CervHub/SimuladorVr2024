@extends('base')

@section('message-primary')
Bienvenido, <span class="welcome-text fw-bold">{{Auth::user()->name}} {{Auth::user()->last_name}}</span>
@endsection

@section('message-secondary')
Panel - Super Administrador
@endsection

@section('sidebar')
<ul class="nav">
    <li class="nav-item" id="dashboard-superadmin">
        <a class="nav-link" href="{{route('superadministrador')}}">
            <i class="mdi mdi-view-dashboard menu-icon"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>
    <li class="nav-item" id="empresa-superadmin">
        <a class="nav-link" href="{{route('superadministrador.empresa')}}">
            <i class="mdi mdi-office-building menu-icon"></i>
            <span class="menu-title">Empresas</span>
        </a>
    </li>
    <li class="nav-item" id="taller-superadmin">
        <a class="nav-link" href="{{route('superadministrador.taller.dashboard')}}">
            <i class="mdi mdi-account-box-multiple menu-icon"></i>
            <span class="menu-title">Talleres</span>
        </a>
    </li>
    <li class="nav-item" id="reporte-superadmin">
        <a class="nav-link" href="{{route('superadministrador.reporte')}}">
            <i class="mdi mdi-file-chart menu-icon"></i>
            <span class="menu-title">Reportes</span>
        </a>
    </li>
</ul>

@endsection