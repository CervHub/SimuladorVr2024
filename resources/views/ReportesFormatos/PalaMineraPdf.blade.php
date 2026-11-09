@php
    use App\Models\DetailInductionWorker;

    $notaFinal = DetailInductionWorker::palaMineraNota($payload);
    $notaColisiones = DetailInductionWorker::palaMineraNotaColisiones($payload);
    $notaCamiones = DetailInductionWorker::palaMineraNotaCamiones($payload);

    $sections = [
        'collisions' => ['COLISIONES', [
            'shovelTracks' => 'Orugas de la pala',
            'truck' => 'Camión',
            'bucketDoor' => 'Compuerta del balde',
        ]],
        'trucks' => ['CAMIONES', [
            'overloadedTrucks' => 'Camiones sobrecargados',
            'underloadedTrucks' => 'Camiones con carga insuficiente',
            'totalTrucks' => 'Total de camiones cargados',
        ]],
        'buckets' => ['CARGAS DE BALDE', [
            'averageLoad' => 'Carga promedio (valor enviado)',
            'successLoads' => 'Cargas exitosas',
            'failLoads' => 'Cargas fallidas',
            'totalLoads' => 'Total de cargas',
        ]],
        'times' => ['TIEMPOS', [
            'averageLoad' => 'Promedio por carga',
            'averageTruckLoad' => 'Promedio por camión',
            'Total' => 'Tiempo total',
        ]],
    ];
@endphp

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Pala minera</title>
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
        </style>
    </head>
    <body>
        <table class="header-table" style="table-layout:fixed;">
            <tr>
                <td style="width:25%;vertical-align:middle;">
                    <img style="width:100px;height:auto;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo/logo_negro.png'))) }}" alt="CERV">
                </td>
                <td class="text-center font-bold" style="width:50%;vertical-align:middle;font-size:16px;">
                    REPORTE DE EVALUACIÓN<br>PALA MINERA
                </td>
                <td class="text-center font-bold" style="width:25%;vertical-align:middle;">
                    FLAVISUR E.I.R.L.
                </td>
            </tr>
        </table>
        <table style="table-layout:fixed;">
            <tr>
                <td style="width:58%;vertical-align:top;border:none;padding:0 8px 0 0;">
                    <table>
                        <tr>
                            <th colspan="2">
                                DATOS DEL EVALUADO
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Nombres y apellidos
                            </th>
                            <td>
                                {{ $worker->nombre }} {{ $worker->apellido }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                DNI
                            </th>
                            <td>
                                {{ $worker->user->doi ?? '—' }}
                            </td>
                        </tr>
                        {{--
                        <tr>
                            <th>
                                Cargo
                            </th>
                            <td>
                                {{ $worker->position ?? '—' }}
                            </td>
                        </tr>
                        --}}
                        <tr>
                            <th>
                                Inducción
                            </th>
                            <td>
                                {{ $induction->alias }}
                            </td>
                        </tr>
                        {{--
                        <tr>
                            <th>
                                Modalidad / intento
                            </th>
                            <td>
                                {{ $modo }} / {{ $detail->report }}
                            </td>
                        </tr>
                        --}}
                        <tr>
                            <th>
                                Fecha del simulador
                            </th>
                            <td>
                                {{ $payload['date'] ?? '—' }}
                            </td>
                        </tr>
                        {{-- <tr><th>Código del simulador</th><td>{{ $payload['code'] ?? '—' }}</td></tr> --}}
                        <tr>
                            <th>
                                Nota final / 20
                            </th>
                            <td>
                                {{ $notaFinal }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width:42%;vertical-align:top;border:none;padding:0;">
                    <table>
                        <tr>
                            <th colspan="2">
                                CONDICIONES
                            </th>
                        </tr>
                        <tr>
                            <td>
                                Momento del día
                            </td>
                            <td>
                                {{ data_get($payload, 'condition.dayTime', '—') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Clima
                            </td>
                            <td>
                                {{ data_get($payload, 'condition.weather', '—') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Modo
                            </td>
                            <td>
                                Pantalla
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Modelo de pala
                            </td>
                            <td>
                                {{ data_get($payload, 'condition.shovelModel', '—') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        @foreach ($sections as $section => [$title, $fields])
            @php($hasObjective = in_array($section, ['collisions', 'trucks'], true))
            <table>
                <tr>
                    @if ($hasObjective)
                        <th>
                            {{ $title }}
                        </th>
                        <th style="text-align:right;">
                            Objetivo: {{ $section === 'collisions' ? '0 colisiones' : '5 camiones cargados' }}
                        </th>
                    @else
                        <th colspan="2">
                            {{ $title }}
                        </th>
                    @endif
                </tr>
                @if ($hasObjective)
                    <tr>
                        <th style="width:65%;">
                            Indicador
                        </th>
                        <th style="width:35%;">
                            Resultado
                        </th>
                    </tr>
                @endif
                @foreach ($fields as $key => $label)
                    <tr>
                        <td style="width:65%;">
                            {{ $label }}
                        </td>
                        <td>
                            {{ $section === 'condition' && $key === 'display' ? 'Pantalla' : data_get($payload, $section.'.'.$key, '—') }}
                        </td>
                    </tr>
                @endforeach
                @if ($section === 'collisions')
                    <tr>
                        <th>
                            Nota de colisiones / 20
                        </th>
                        <td>
                            {{ $notaColisiones }}
                        </td>
                    </tr>
                @endif
                @if ($section === 'trucks')
                    <tr>
                        <th>
                            Nota de camiones / 20
                        </th>
                        <td>
                            {{ $notaCamiones }}
                        </td>
                    </tr>
                @endif
            </table>
        @endforeach
        <table>
            <tr>
                <th colspan="2">OBSERVACIONES DE GIRO</th>
            </tr>
            <tr>
                <th style="width:65%;">Indicador</th>
                <th style="width:35%;">Resultado</th>
            </tr>
            <tr>
                <td>Giros de la pala</td>
                <td>{{ data_get($payload, 'rotations.shovel.cableContactTurns', 'No informado') }}</td>
            </tr>
            <tr>
                <td colspan="2">Se considera un giro cuando la pala gira más de 180° y llega a pisar su cable.</td>
            </tr>
        </table>
    </body>
</html>
