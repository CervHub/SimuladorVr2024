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
        <li class="nav-item" id="departamento">
            <a class="nav-link" href="{{ route('departamentos') }}">
                <i class="mdi mdi-domain menu-icon"></i>
                <span class="menu-title">Gerencias</span>
            </a>
        </li>
        @php
            $userOrCompany = session('id_company');
        @endphp

        @if ($userOrCompany == 4)
            <li class="nav-item" id="steps">
                <a class="nav-link" href="{{ route('administrador.talleres.steps') }}">
                    <i class="mdi mdi-wrench menu-icon"></i>
                    <span class="menu-title">Talleres Steps</span>
                </a>
            </li>
        @endif
    </ul>
@endsection
