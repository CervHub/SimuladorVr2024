<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        body {
            margin: 0;
            /* Márgenes en milímetros */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid black;
        }

        .col-1 {
            width: 8.33%;
        }

        .col-2 {
            width: 16.66%;
        }

        .col-3 {
            width: 25%;
        }

        .col-4 {
            width: 33.33%;
        }

        .col-5 {
            width: 41.66%;
        }

        .col-6 {
            width: 50%;
        }

        .col-7 {
            width: 58.33%;
        }

        .col-8 {
            width: 66.66%;
        }

        .col-9 {
            width: 75%;
        }

        .col-10 {
            width: 83.33%;
        }

        .col-11 {
            width: 91.66%;
        }

        .col-12 {
            width: 100%;
        }

        .logo-container {
            position: relative;
            /* Asegura que las propiedades de posición funcionen */
            z-index: 9999;
            /* Coloca el div encima de todo */
            width: 60px;
            /* Ancho del contenedor */
            height: 50px;
            /* Altura del contenedor */
            padding-left: 5px;
            /* Espaciado a la izquierda */
        }




        #usuario {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .col-6 {
            width: 45%;
        }

        .align-left {
            text-align: left;
        }

        .align-top {
            text-align: top;
        }

        .border-0 {
            border: 0;
            border-color: red;
        }

        .text-white {
            color: white;
        }

        .title {
            padding-bottom: 30px;
        }

        .fs-20 {
            font-size: 20px;
        }

        .fs-10 {
            font-size: 10px;
        }

        .fs-12 {
            font-size: 12px;
        }

        .fs-14 {
            font-size: 14px;
        }

        .fs-13 {
            font-size: 13px;
        }

        .fs-15 {
            font-size: 15px;
        }

        .fs-18 {
            font-size: 18px;
        }

        .fs-20 {
            font-size: 20px;
        }

        .fs-30 {
            font-size: 30px;
        }

        .border-0 {
            border: 0;
        }

        .align-left {
            text-align: left;
        }

        .align-top {
            vertical-align: top;
        }

        .title {
            font-weight: bold;
        }

        .line-height-1 {
            line-height: 0.1;
        }

        .line-height-3 {
            line-height: 0.3;
        }

        .line-height-5 {
            line-height: 0.5;
        }

        .line-height-8 {
            line-height: 0.8;
        }

        .line-height-10 {
            line-height: 1;
        }

        .line-height-12 {
            line-height: 1.2;
        }

        .dl-container {
            display: table;
            width: 100%;
        }

        .dl-row {
            display: table-row;
        }

        .dl-term,
        .dl-definition {
            display: table-cell;
        }

        .text-light {
            font-weight: lighter;
        }

        .dl-term {
            width: 150px;
        }

        .no-border {
            border: none;
            border-color: white;
        }

        .no-border td,
        .no-border th,
        .no-border tr {
            border: none;
            padding: 5px;
            margin: 0;
        }

        .white-border td,
        .white-border th,
        .white-border tr {
            border-color: red;
        }

        dl {
            margin: 0;
            padding: 0;
        }

        .mt-3 {
            padding-top: 15px;
        }

        .mb-3 {
            padding-bottom: 15px;
        }

        .mt-2 {
            padding-top: 10px;
        }

        .mb-2 {
            padding-bottom: 10px;
        }

        .bg-light {
            background-color: whitesmoke;
        }

        hr {
            border: 0.1px solid black;
            margin-left: 5px;
            margin-right: 5px;
        }

        .dl-definition,
        .dl-term-secondary,
        .dl-term {
            padding-top: 3px;
        }

        .dl-term-secondary {
            font-weight: bold;
        }

        .banner {
            background-color: blue;
            width: 100%;
            height: 20px;
            position: absolute;
            left: 10%;
            border-radius: 10px 0px 0px 10px;
            /* Agrega una sombra negra */
        }

        .custom-table {
            border-collapse: collapse;
            margin: auto;
            text-align: left;
            /* Añadido para redondear los bordes */
            overflow: hidden;
            /* Añadido para asegurarse de que el borde redondeado se vea bien */
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid black;
            padding: 8px;
        }

        .reporte-columna-derecha {
            vertical-align: top;
            text-align: right;
            width: 42%;
        }

        .reporte-panel-derecho {
            width: 200px;
            margin-left: auto;
            text-align: center;
        }

        .reporte-panel-nota {
            border-radius: 25px;
            width: 200px;
            margin: 0;
            padding: 10px 8px;
            box-sizing: border-box;
        }

        .reporte-panel-foto {
            width: 200px;
            height: 168px;
            border-radius: 25px;
            display: block;
            margin: 0;
        }
    </style>
</head>

<body>
    <table class="no-border" style="width: 100%;">
        <tr style="padding:0; margin:0;">
            <td style="width: 100px; padding:0; vertical-align: middle;">
                <img src="{{ $logo }}" width="64px" alt="Logo">
            </td>
            <td style="padding:0; text-align: center; vertical-align: middle;">
                <p style="text-align: center; font-size:18px; font-weight: bold; margin: 0;">
                    REPORTE INDIVIDUAL DE EVALUACIÓN
                </p>
            </td>
            <td style="width: 100px; padding:0;"></td>
        </tr>
    </table>

    <hr>
    <section id="usuario">
        <table class="no-border" style="width: 100%;">
            <tr class="col-12">
                <td class="col-7 align-left align-top">
                    <dl class="dl-container ">
                        <div class="dl-row">
                            <dt class="dl-term title fs-15" style="padding:0; padding-bottom:15px;">Datos del usuario
                            </dt>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">DNI:</dt>
                            <dd class="dl-definition">{{ $worker->user->doi }}</dd>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Nombre:</dt>
                            <dd class="dl-definition">{{ $worker->user->name }}</dd>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Apellidos:</dt>
                            <dd class="dl-definition">{{ $worker->user->last_name }}</dd>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Fecha:</dt>
                            <dd class="dl-definition">{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</dd>
                        </div>
                    </dl>
                </td>
                <td class="col-5 align-top reporte-columna-derecha">
                    <div class="reporte-panel-derecho">
                        <dl class="dl-container bg-light mt-2 mb-2 reporte-panel-nota">
                            <div class="dl-row">
                                @php
                                    $notaPonderada = $extra['total_sum'];
                                @endphp
                                <dt class="dl-term fs-20 line-height-12" style="font-weight: bold;">
                                    {{ number_format($notaPonderada, 0) }}/20</dt>
                            </div>
                            <div class="dl-row">
                                <dt class="dl-term fs-20 line-height-12" style="font-weight: bold;">
                                    @if ($notaPonderada > 12)
                                        Aprobado
                                    @else
                                        Desaprobado
                                    @endif
                                </dt>
                            </div>
                            <div class="dl-row">
                                <dt class="dl-term fs-20 line-height-12" style="font-weight: bold;">
                                    {{ $extra['categoria'] }}
                                </dt>
                            </div>
                        </dl>
                    </div>
                </td>
            </tr>
        </table>

    </section>
    <br>
    <hr>
    <section id="evaluacion">
        <table class="no-border" style="width: 100%;">
            <tr class="col-12">
                <td class="col-7 align-left align-top">
                    <dl class="dl-container">
                        <div class="dl-row">
                            <dt class="dl-term title fs-15" style="padding:0; padding-bottom: 10px;">Datos de evaluación
                            </dt>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Escenario:</dt>
                            <dd class="dl-definition">{{ $induction->alias }}</dd>
                        </div>
                        <!-- <div class="dl-row">
                            <dt class="dl-term-secondary">Total de Casos:</dt>
                            <dd class="dl-definition">{{ $casosTotales }}</dd>
                        </div> -->
                        @php
                            $pasosEscenario = 8;
                            $aliasEscenario = $induction->alias ?? '';
                            $imagenGrafico = $imagen;
                            $pasosRealizadosMostrar = $casosBuenos;

                            if (stripos($aliasEscenario, 'Trabajos en Altura') !== false) {
                                $pasosEscenario = 7;
                            } elseif (stripos($aliasEscenario, 'Trabajos en Caliente') !== false) {
                                $pasosEscenario = 8;
                            }

                            if (stripos($aliasEscenario, 'Trabajos en Altura') !== false
                                || stripos($aliasEscenario, 'Trabajos en Caliente') !== false) {
                                $graficoEncontrados = min((int) $casosBuenos, $pasosEscenario);
                                $graficoNoEncontrados = $pasosEscenario - $graficoEncontrados;
                                $pasosRealizadosMostrar = $graficoEncontrados;
                                $imagenGrafico = "https://quickchart.io/chart?c={type:'doughnut', data:{datasets:[{data:[{$graficoEncontrados},{$graficoNoEncontrados}],backgroundColor:['rgb(32,164,81)','rgb(255,0,0)'],}],labels:['Encontrado', 'No encontrados'],},options:{title:{display:false},plugins: { datalabels: { color: 'white' } },},}";
                            }
                        @endphp
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Pasos:</dt>
                            <dd class="dl-definition">{{ $pasosEscenario }}</dd>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Pasos Realizados:</dt>
                            <dd class="dl-definition">{{ $pasosRealizadosMostrar }}</dd>
                        </div>

                        @php
                            $fechaInicio = new DateTime($data->start_date);
                            $fechaFin = new DateTime($data->end_date);
                            $diferencia = $fechaInicio->diff($fechaFin);

                            $duracionEnHoras = $diferencia->format('%I:%S');
                        @endphp

                        <div class="dl-row">
                            <dt class="dl-term-secondary">Fecha inicio:</dt>
                            <dd class="dl-definition">{{ $data->start_date }}</dd>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Fecha fin:</dt>
                            <dd class="dl-definition">{{ $data->end_date }}</dd>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Duración:</dt>
                            <dd class="dl-definition">{{ $duracionEnHoras }}</dd>
                        </div>
                    </dl>
                </td>
                <td class="col-5 align-top reporte-columna-derecha">
                    <div class="reporte-panel-derecho">
                        <img class="reporte-panel-foto" src="{{ $logo_taller }}" alt=""
                            width="200" height="168"
                            style="width: 200px; height: 168px; border-radius: 25px; display: block;">
                    </div>
                </td>
            </tr>
        </table>

    </section>
    <hr>
    <section id="detalles" style="padding-left: 5px;padding-right: 5px;">
        <p class="fs-15 title" style="padding:0;">Detalles de evaluación</p>
        <table class="custom-table">
            <tr>
                <th>Nombre del caso</th>
                <th>Identificado</th>
                {{-- <th>Nivel de riesgo</th>
                <th>Medida correcta</th> --}}
                <th>Tiempo</th>
            </tr>
            @php
                $totalTiempoSegundos = 0;
            @endphp
            @foreach ($detail_induction_worker as $key => $data)
                <tr style="height: 20px;"> <!-- Ajusta la altura según tus preferencias -->
                    <td style="text-align: left;">{{ $key + 1 }}. {{ $data->case }}</td>
                    <td>{{ $data->identified }}</td>
                    {{-- <td>{{ $data->risk_level }}</td>
                    <td>{{ $data->correct_measure }}</td> --}}
                    <td>
                        @php
                            $caseTime = trim((string) ($data->time ?? ''));
                            if ($caseTime === '' && ! empty($data->json)) {
                                $caseJson = json_decode($data->json, true);
                                if (is_array($caseJson) && isset($caseJson['time'])) {
                                    $caseTime = trim((string) $caseJson['time']);
                                }
                            }
                            if ($caseTime !== '') {
                                if (preg_match('/^(\d{1,2}):(\d{1,2})$/', $caseTime, $timeParts)) {
                                    $totalTiempoSegundos += ((int) $timeParts[1] * 60) + (int) $timeParts[2];
                                } elseif ($parsed = strtotime($caseTime)) {
                                    $totalTiempoSegundos += ((int) date('G', $parsed) * 3600)
                                        + ((int) date('i', $parsed) * 60)
                                        + (int) date('s', $parsed);
                                }
                            }
                            if ($caseTime === '') {
                                echo '-';
                            } elseif (preg_match('/^(\d{1,2}):(\d{1,2})$/', $caseTime, $timeParts)) {
                                echo sprintf('%02d:%02d', (int) $timeParts[1], (int) $timeParts[2]);
                            } else {
                                $parsed = strtotime($caseTime);
                                echo $parsed ? date('H:i', $parsed) : $caseTime;
                            }
                        @endphp
                    </td>
                </tr>
            @endforeach
            @php
                $totalSum = round($extra['identified_sum'] + $extra['risk_level_sum'] + $extra['correct_measure_sum']);
                $totalTiempoFormateado = $totalTiempoSegundos > 0
                    ? sprintf('%02d:%02d', intdiv($totalTiempoSegundos, 60), $totalTiempoSegundos % 60)
                    : '-';
            @endphp
            <tr>
                <th>TOTAL</th>
                <th>{{ $extra['identified_sum'] }}</th>
                {{-- <th>{{ $extra['risk_level_sum'] }}</th>
                <th>{{ $extra['correct_measure_sum'] }}</th> --}}
                <th>{{ $totalTiempoFormateado }}</th>
            </tr>
        </table>
        <br>
        <table class="no-border">
            <tr>
                <td style="vertical-align: top; width: 300px; border: none;">
                    <img src="{{ $imagenGrafico }}" width="300px" alt="">
                </td>
                <td>
                    <table style="border-collapse: collapse; border: 1px solid black;">
                        <tr style="border-collapse: collapse; border: 1px solid black;">
                            <td style="border-collapse: collapse; border: 1px solid black;">Nota de Referencia:</td>
                            <td style="border-collapse: collapse; border: 1px solid black;">
                                {{ number_format($data->note_reference, 0) }}</td>
                        </tr>
                        <tr style="border-collapse: collapse; border: 1px solid black;">
                            <td style="border-collapse: collapse; border: 1px solid black;"> Nota Obtenida:</td>
                            <td style="border-collapse: collapse; border: 1px solid black;">{{ $totalSum }}</td>
                        </tr>
                        <tr style="border-collapse: collapse; border: 1px solid black;">
                            <td style="border-collapse: collapse; border: 1px solid black;">Nota ponderada:</td>
                            <td style="border-collapse: collapse; border: 1px solid black;">
                                {{ $extra['total_sum'] }}/20</td>
                        </tr>
                        <!-- Agrega más filas de datos según sea necesario -->
                    </table>
                </td>
            </tr>
        </table>


    </section>

</body>

</html>
