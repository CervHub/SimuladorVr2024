<!DOCTYPE html><html lang="es"><head><meta charset="utf-8"><title>Pala minera</title><style>
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
    </style></head><body>
<table class="header-table"><tr>
<td style="width:20%;"><img style="width:100px;height:auto;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo/logo_negro.png'))) }}" alt="CERV"></td>
<td class="text-center font-bold" style="font-size:16px;">REPORTE DE EVALUACIÓN<br>PALA MINERA</td>
<td class="text-center font-bold">FLAVISUR E.I.R.L.</td></tr></table>
<table>
<tr><th colspan="2" class="text-center">DATOS DEL EVALUADO</th></tr>
<tr><th>Nombres y apellidos</th><td>{{ $worker->nombre }} {{ $worker->apellido }}</td></tr>
<tr><th>DNI</th><td>{{ $worker->user->doi ?? '—' }}</td></tr>
<tr><th>Cargo</th><td>{{ $worker->position ?? '—' }}</td></tr>
<tr><th>Inducción</th><td>{{ $induction->alias }}</td></tr>
<tr><th>Modalidad / intento</th><td>{{ $modo }} / {{ $detail->report }}</td></tr>
<tr><th>Fecha del simulador</th><td>{{ $payload['date'] ?? '—' }}</td></tr>
<tr><th>Código del simulador</th><td>{{ $payload['code'] ?? '—' }}</td></tr>
<tr><th>Nota</th><td>{{ \App\Models\DetailInductionWorker::palaMineraNota($payload) }}</td></tr>
</table>
@foreach ([
'condition' => ['CONDICIONES', ['dayTime'=>'Momento del día','weather'=>'Clima','display'=>'Modalidad','shovelModel'=>'Modelo de pala']],
'collisions' => ['COLISIONES', ['shovelTracks'=>'Orugas de la pala','truck'=>'Camión','bucketDoor'=>'Compuerta del balde']],
'buckets' => ['CARGAS DE BALDE', ['averageLoad'=>'Carga promedio (valor enviado)','successLoads'=>'Cargas exitosas','failLoads'=>'Cargas fallidas','totalLoads'=>'Total de cargas']],
'trucks' => ['CAMIONES', ['overloadedTrucks'=>'Camiones sobrecargados','underloadedTrucks'=>'Camiones con carga insuficiente','totalTrucks'=>'Total de camiones']],
'times' => ['TIEMPOS', ['averageLoad'=>'Promedio por carga','averageTruckLoad'=>'Promedio por camión','Total'=>'Tiempo total']]
] as $section => [$title, $fields])
<table><tr><th colspan="2" class="text-center">{{ $title }}</th></tr>
@foreach ($fields as $key => $label)
<tr><td style="width:65%;">{{ $label }}</td><td>{{ data_get($payload, $section.'.'.$key, '—') }}</td></tr>
@endforeach
</table>
@endforeach
</body></html>
