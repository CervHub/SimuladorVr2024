<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Reporte de pala minera</title>
<style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 2px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f4f4f4;
        }

        h5 {
            margin-top: 0;
            font-size: 16px;
            color: #333;
        }

        .header-table td {
            padding: 8px;
            border: none;
        }

        .header-table img {
            width: 50px;
            height: 50px;
        }

        .header-table .bold {
            font-weight: bold;
            color: #333;
        }

        .header-table .center {
            text-align: center;
        }

        .w-5 {
            width: 5%;
        }

        .w-10 {
            width: 10%;
        }

        .w-15 {
            width: 15%;
        }

        .w-20 {
            width: 20%;
        }

        .w-30 {
            width: 30%;
        }

        .w-40 {
            width: 40%;
        }

        .w-50 {
            width: 50%;
        }

        .w-60 {
            width: 60%;
        }

        .w-100 {
            width: 100%;
        }

        .text-left {
            text-align: left;
        }

        .text-light {
            font-weight: normal;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .font-size-24 {
            font-size: 24px;
        }

        .no-border {
            border: none;
        }

        .no-margin-padding {
            margin: 0;
            padding: 0;
        }

        .no-margin-left {
            margin-left: 0;
            padding-left: 0;
        }

        .no-margin-right {
            margin-right: 0;
            padding-right: 0;
        }

        .ml-2 {
            margin-left: 2px !important;
            padding-left: 2px !important;
        }
    
@page { margin: 28px 32px; }
.section { page-break-inside: avoid; }
.demo { text-align: center; font-size: 10px; color: #666; margin-bottom: 8px; }
</style></head>
<body>
@php
    $logo = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('logo/logo_negro.png')));
    $sinPhoto = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('logo/sin-photo.png')));
@endphp
<table class="header-table w-100">
    <tr>
        <td class="w-20"><img src="{{ $logo }}" alt="CERV" style="width:100px;height:auto;"></td>
        <td class="w-60 text-center font-bold" style="font-size:16px;">REPORTE DE EVALUACIÓN<br><span style="font-size:12px;">PALA MINERA</span></td>
        <td class="w-20 text-center font-bold">FLAVISUR E.I.R.L.</td>
    </tr>
</table>
@if ($isDemo ?? false)
<div class="demo">SIMULACIÓN - DATOS DE PRUEBA</div>
@endif
<table>
    <tr><th colspan="3" class="text-center">DATOS DEL EVALUADO</th></tr>
    <tr><th style="width:25%;">Nombres y apellidos:</th><td>{{ trim(($worker->nombre ?? '').' '.($worker->apellido ?? '')) }}</td><td rowspan="5" style="width:22%;text-align:center;"><img src="{{ $sinPhoto }}" style="width:85px;height:auto;" alt="Foto del trabajador"></td></tr>
    <tr><th>DNI:</th><td>{{ $worker->dni ?? $worker->user->doi ?? '—' }}</td></tr>
    <tr><th>Cargo:</th><td>{{ $worker->position ?? '—' }}</td></tr>
    <tr><th>Empresa:</th><td>Flavisur E.I.R.L.</td></tr>
    <tr><th>Inducción:</th><td>{{ $induction->alias }}</td></tr>
</table>
<table>
    <tr><th>Modalidad</th><td>{{ $modo }}</td><th>Intento</th><td>{{ $detail->report }}</td></tr>
    <tr><th>Fecha del simulador</th><td>{{ $payload['date'] ?? '—' }}</td><th>ID de evaluación</th><td>{{ $detail->id }}</td></tr>
    <tr><th>Código del simulador</th><td colspan="3">{{ $payload['code'] ?? '—' }}</td></tr>
    <tr><th>Nota</th><td colspan="3">{{ \App\Models\DetailInductionWorker::palaMineraNota($payload) }}</td></tr>
</table>
    @foreach ([
        'condition' => ['Condiciones', ['dayTime' => 'Momento del día', 'weather' => 'Clima', 'display' => 'Modalidad', 'shovelModel' => 'Modelo de pala']],
        'collisions' => ['Colisiones', ['shovelTracks' => 'Orugas de la pala', 'truck' => 'Camión', 'bucketDoor' => 'Compuerta del balde']],
        'buckets' => ['Cargas de balde', ['averageLoad' => 'Carga promedio (valor enviado)', 'successLoads' => 'Cargas exitosas', 'failLoads' => 'Cargas fallidas', 'totalLoads' => 'Total de cargas']],
        'trucks' => ['Camiones', ['overloadedTrucks' => 'Camiones sobrecargados', 'underloadedTrucks' => 'Camiones con carga insuficiente', 'totalTrucks' => 'Total de camiones']],
        'times' => ['Tiempos', ['averageLoad' => 'Promedio por carga', 'averageTruckLoad' => 'Promedio por camión', 'Total' => 'Tiempo total']]
    ] as $section => [$title, $fields])
        <table><tr><th colspan="2" class="text-center">{{ mb_strtoupper($title) }}</th></tr>
            @foreach ($fields as $key => $label)
                <tr><td>{{ $label }}</td><td>{{ data_get($payload, $section.'.'.$key, '—') }}</td></tr>
            @endforeach
        </table>
    @endforeach
<div style="font-size:10px;color:#666;">Resultados recibidos del simulador. Carga promedio: valor enviado, sin unidad definida.</div>
</body></html>
