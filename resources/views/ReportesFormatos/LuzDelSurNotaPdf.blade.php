<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
    initial-scale=1.0">
    <style>
        :root {
            --main-color: #b6000b;
        }

        body {
            font-size: 0.8em;
            font-family: Calibri, Arial, sans-serif;
        }

        table,
        tr,
        td {
            border: 1px solid;
            border-collapse: collapse;
        }

        td {
            padding: 5px 5px;
        }

        .main__container {
            min-width: 100%;
            margin: 0 auto;
            padding: 1%;
            font-size: 1.2em;
        }

        .title {
            text-align: center;
        }

        .column__key {
            text-align: left;
            font-weight: 600;
        }

        .column__key--black {
            text-align: left;
        }

        .text-center {
            text-align: center;
            white-space: pre-line;

        }

        .text-rigth {
            text-align: right;
            white-space: pre-line;
        }

        .text-left {
            text-align: left;
            white-space: pre-line;
        }

        .text-small {
            font-size: xx-small;
        }

        .bold-center {
            font-weight: bold;
            text-align: center;
        }

        .text-light {
            font-weight: lighter
        }

        .text-small2 {
            font-size: x-small;
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
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
    </style>
</head>

<body>


    <table class="cabecera" style="width: 100%">
        <tbody>
            <tr class="even text-size">
                <td style="width: 20% !important;" rowspan="2" class="text-center"> <img src="{{ $logo }}"
                        width="64px" alt="Logo"></td>
                <td class="bold-center text-center" style="width: 80% !important; font-size: 14px;">FORMATO</td>
                <td style="width: 20% !important;" rowspan="2" class="text-left text-small">Código: DDC-FR-001
                    Revisión: 00
                    Aprobado: SSDH
                    Fecha: 08/01/2018
                </td>
            </tr>
            <tr class="odd text-size" style="width: 80% !important; font-size: 14px;">
                <td class="bold-center text-center">REGISTRO DE CAPACITACIÓN</td>
            </tr>
            <tr class="even text-size">
                <td colspan="2" rowspan="3" class="text-left text-small text-bold">RAZÓN SOCIAL: LUZ DEL SUR
                    S.A.A.
                    RUC: 20331898008
                    DIRECCIÓN: AV CANAVAL Y MOREYRA 380
                    ACTIVIDAD: DISTRIBUCIÓN DE ENERGÍA ELÉCTRICA
                </td>
                <td style="width: 20% !important; padding: 0;" class="text-center text-small text-bold">N° Registro:
                    25550
                </td>
            </tr>
            <tr>
                <td style=" padding: 0;" class="text-center text-small">N° de trabajadores:
                </td>
            </tr>
            <tr>
                <td style=" padding: 0;" class="text-center text-small text-bold"> 1
                </td>
            </tr>
        </tbody>
    </table>

    <section>
        <h3 class="text-center">
            REGISTRO DE CAPACITACIÓN
            Evento: {{ $induction->alias }}
            Sesión 1: Fecha : {{ \Carbon\Carbon::parse($induction->date_start)->format('d/m/Y') }}
            SALA DE CAPACITACION SAN JUAN
            Expositor : {{ $induction->worker->nombre }} {{ $induction->worker->apellido }}
        </h3>
    </section>

    <section>
        <h4 style="padding: 0; margin: 0;">
            Marcar con (X) según corresponda:
        </h4>
        <h4 class="text-light" style="padding: 0; margin-top: 15px; text-align:center;">
            1-Inducción( ) 2-Capacitación( X ) 3-Entrenamiento( ) 4-Jornada( ) 5-Simulacro de Emergencia( )
        </h4>
    </section>
    @php
        $fechaInicio = new DateTime($data->start_date);
        $fechaFin = new DateTime($data->end_date);
        $diferencia = $fechaInicio->diff($fechaFin);

        $duracionEnHoras = $diferencia->format('%H:%I:%S');
    @endphp

    <section id="usuario">
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td class="text-bold" style="width: 25%;">Documento de Identidad:</td>
                    <td style="width: 25%;">{{ $worker->user->doi }}</td>
                    <td rowspan="6" style="width: 50%; text-align: center; vertical-align: middle;">
                        <div style="padding-left: 20px;">
                            <dl class="dl-container bg-light mt-2 mb-2"
                                style="border-radius: 25px; text-align: center;">
                                @php
                                    $total = 0;
                                    foreach ($detail_induction_worker as $data) {
                                        $total += $data->identified == 1 ? 10 : 0;
                                    }
                                    $maxScore = 10 * count($detail_induction_worker);
                                    $notaPonderada = ($total / $maxScore) * $induction_worker->puntaje;
                                @endphp
                                <div class="dl-row">
                                    <dt class="dl-term fs-20 line-height-12"
                                        style="font-weight: bold; margin: 0; font-size:22px;">
                                        {{ number_format($notaPonderada, 0) }}/{{ $induction_worker->puntaje }}
                                    </dt>
                                </div>
                                <div class="dl-row">
                                    <dt class="dl-term fs-20 line-height-12"
                                        style="font-weight: bold; margin: 0; padding: 5px; font-size:17px;">
                                        @if ($notaPonderada > 75)
                                            <span style="color: green;">Aprobado</span>
                                        @else
                                            <span style="color: red;">Desaprobado</span>
                                        @endif
                                    </dt>
                                </div>
                            </dl>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-bold">Nombre:</td>
                    <td>{{ $worker->nombre}}</td>
                </tr>
                <tr>
                    <td class="text-bold">Apellidos:</td>
                    <td>{{ $worker->apellido }}</td>
                </tr>
                <tr>
                    <td class="text-bold">Fecha Inicio:</td>
                    <td>{{ date('d/m/Y H:i', strtotime($data->start_date)) }}</td>
                </tr>
                <tr>
                    <td class="text-bold">Duración(Min):</td>
                    <td>{{ $duracionEnHoras }}</td>
                </tr>
                <tr>
                    <td class="text-bold">Número de reporte:</td>
                    <td>{{$intento}}/{{ $intentos }}</td>
                </tr>
            </tbody>
        </table>
        <!-- Aquí puedes agregar más contenido dentro de la sección -->
    </section>

    <section id="detalles" style="padding-left: 5px;padding-right: 5px;">
        <h3 class="fs-15 title" style="padding:0;">Detalles de evaluación</h3>
        <table border="1" style="width: 100%">
            <thead>
                <tr>
                    <th class="text-small2" style="width: 5%">ITEM</th>
                    <th class="text-small2" style="width: 50%">DESCRIPCIÓN</th>
                    <th class="text-small2" style="width: 15%">DURACIÓN(MIN)</th>
                    <th class="text-small2" style="width: 15%">PUNTAJE</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($detail_induction_worker as $key => $data)
                    @php
                        $total += $data->identified == 1 ? 10 : 0;
                    @endphp
                    <tr style="height: 20px;">
                        <td style="text-align: center;">{{ $key + 1 }}</td>
                        <td style="text-align: left;">{{ $data->case }}</td>
                        <td style="text-align: center;">{{ $data->time }}</td>
                        <td style="text-align: center;">{{ $data->identified == 1 ? 10 : 0 }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right;">Total:</td>
                    <td style="text-align: center;">{{ $total }}</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>

        <br>
        {{-- <table class="no-border" style="width: 100%; border: 1px solid white; !important">
            <tr style="background-color: white;">
                <td style="vertical-align: top; width: 300px; border: none !important;">
                    <img src="{{ $imagen }}" width="300px" alt="">
                </td>
                <td style="padding: 10px; background-color: white;">
                    @php
                        $total_errores = round($detail_induction_worker->sum('num_errors'));
                    @endphp
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                        <tr>
                            <td class="text-bold" style="border: 1px solid black;">Total de Errores:</td>
                            <td style="border: 1px solid black;">{{ $total_errores }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold" style="border: 1px solid black;">Puntaje Inicial:</td>
                            <td style="border: 1px solid black;">{{ $induction_worker->puntaje }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold" style="border: 1px solid black;">Puntaje Final:</td>
                            <td style="border: 1px solid black;">
                                @if ($induction_worker->puntaje - $total_errores < 0)
                                    0
                                @else
                                    {{ $induction_worker->puntaje - $total_errores }}
                                @endif
                            </td>
                        </tr>
                        <!-- Agrega más filas de datos según sea necesario -->
                    </table>

                </td>
            </tr>
        </table> --}}


    </section>

</body>

</html>
