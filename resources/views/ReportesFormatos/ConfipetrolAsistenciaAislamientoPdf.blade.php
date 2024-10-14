<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reportes</title>
</head>

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
    }

    .text-rigth {
        text-align: right;
    }
</style>

<body style="box-sizing: border-box">
    <div class="main__container">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td class="text-center" style="padding-top: 0px; padding-bottom: 0px; width: 20%;">
                        <img src="{{ $logo_taller ?? '' }}" width="128px" alt="Logo">
                    </td>
                    <td nowrap colspan="4" style="padding-top: 0px; padding-bottom: 0px;">
                        <h3 class="title">REPORTE DE EVALUACIÓN </h3>
                    </td>
                    <td class="text-center" style="padding-top: 0px; padding-bottom: 0px; width: 20%;">
                        {{ \Carbon\Carbon::now('America/Lima')->format('Y-m-d H:i:s') }}
                    </td>

                </tr>
            </tbody>
        </table>
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td style="width: 20%">
                        <span class="column__key">
                            Simulador:
                        </span>
                    </td>
                    <td colspan="11">
                        {{ $induction->alias }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%">
                        <span class="column__key">
                            Instructor:
                        </span>
                    </td>
                    <td colspan="11">
                        {{ $induction->worker->nombre }} {{ $induction->worker->apellido }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%">
                        <span class="column__key">
                            Fecha de Inicio:
                        </span>
                    </td>
                    <td colspan="5">
                        {{ date('d-m-Y', strtotime($induction->date_start)) }}
                    </td>
                    <td style="width: 20%">
                        <span class="column__key">
                            Fecha de Fin:
                        </span>
                    </td>
                    <td colspan="5">
                        {{ date('d-m-Y', strtotime($induction->date_end)) }}
                    </td>
                </tr>
                @php
                    $fechaInicio =
                        $fecha_inicio != '0000-00-00' ? \Carbon\Carbon::parse($fecha_inicio)->startOfDay() : null;
                    $fechaFin = $fecha_fin != '0000-00-00' ? \Carbon\Carbon::parse($fecha_fin)->endOfDay() : null;
                @endphp

                @if ($fechaInicio && $fechaFin)
                    <tr>
                        <td colspan="12" class="text-center" style="background-color: #D6DBDF; color: #000000;">
                            <strong>Filtros</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%">
                            <span class="column__key">
                                Fecha de Inicio:
                            </span>
                        </td>
                        <td colspan="5">
                            {{ date('d-m-Y', strtotime($fechaInicio)) }}
                        </td>
                        <td style="width: 20%">
                            <span class="column__key">
                                Fecha de Fin:
                            </span>
                        </td>
                        <td colspan="5">
                            {{ date('d-m-Y', strtotime($fechaFin)) }}
                        </td>
                    </tr>
                @endif

                <!-- <tr>
                    <td style="width: 20%">
                        <span class="column__key">
                            Empresa:
                        </span>
                    </td>
                    <td colspan="5">
                        Empresa XYZ
                    </td>
                </tr>
                <tr>
                    <td style="border-left: white;border-bottom: white; border-right: white;" colspan="6">

                    </td>
                </tr> -->
            </tbody>
        </table>
        <table style="width: 100%; border: 1px solid black;">
            <thead>
                <tr>
                    <th colspan="12" class="text-center" style="background-color: #D6DBDF; color: #000000;">
                        <strong>Leyenda</strong>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="background-color: #FADBD8; color: #000000; width: 1%;">IT</td>
                    <td style="width: 12%;">Intento</td>
                    <td style="background-color: #D5F5E3; color: #000000; width: 1%;">EE</td>
                    <td style="width: 12%;">Errores Epp</td>
                    <td style="background-color: #D6EAF8; color: #000000; width: 1%;">EA</td>
                    <td style="width: 12%;">Errores Aislamiento</td>
                    <td style="background-color: #FCF3CF; color: #000000; width: 1%;">EB</td>
                    <td style="width: 12%;">Errores Bloqueo</td>
                    <td style="background-color: #E8DAEF; color: #000000; width: 2%;">ET</td>
                    <td style="width: 10%;">Errores Tarjeteo</td>
                    <td style="background-color: #FADBD8; color: #000000; width: 1%;"></td>
                    <td style="width: 12%;"></td>
                </tr>
            </tbody>
        </table>


        <table style="width: 100%">
            <tbody>
                <tr style="background-color: #c9c9c9;">
                    <td class="text-center"
                        style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; width: 3%;">
                        N°
                    </td>
                    <td class="text-center"
                        style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; width: 10%;">
                        CODIGO
                    </td>
                    <td class="text-center" style="font-weight: bold;">
                        NOMBRES Y APELLIDOS
                    </td>
                    <td class="text-center" style="font-weight: bold;">
                        CARGO
                    </td>
                    <td class="text-center" style="font-weight: bold;padding-top: 0px; padding-bottom: 0px; width: 5%;">
                        EMPRESA
                    </td>
                    <td class="text-center"
                        style="font-weight: bold;padding-top: 0px; padding-bottom: 0px; width: 10%;">
                        Fecha
                    </td>
                    <td class="text-center"
                        style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; width: 3%; background-color: #FADBD8; color: #000000;">
                        IT
                    </td>
                    <td class="text-center"
                        style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; width: 3%; background-color: #D5F5E3; color: #000000;">
                        EE
                    </td>
                    <td class="text-center"
                        style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; width: 3%; background-color: #D6EAF8; color: #000000;">
                        EA
                    </td>
                    <td class="text-center"
                        style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; width: 3%; background-color: #FCF3CF; color: #000000;">
                        EB
                    </td>
                    <td class="text-center"
                        style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; width: 3%; background-color: #E8DAEF; color: #000000;">
                        ET
                    </td>
                    <td class="text-center"
                        style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; width: 3%;">
                        NOTA
                    </td>
                </tr>


                @if (isset($induction_worker) && count($induction_worker) > 0)
                    @foreach ($induction_worker as $data)
                        @php
                            $num_reports = $data->num_report;
                        @endphp
                        @if ($id_service == 0 || $data->worker->service->id == $id_service)
                            @if ($num_reports > 0)
                                @for ($i = 1; $i <= $num_reports; $i++)
                                    @php
                                        $details = $data->notaConfipetrolMax($i);
                                        $start_date = \Carbon\Carbon::parse($details['start_date']);
                                    @endphp
                                    @if ($fechaInicio == null || $fechaFin == null || ($fechaInicio <= $start_date && $start_date <= $fechaFin))
                                        <tr
                                            style="background-color: {{ $loop->iteration % 2 == 0 ? '#c9c9c9' : '#ffffff' }}">
                                            @if ($i == 1)
                                                <td class="text-center" rowspan="{{ $num_reports }}">
                                                    {{ $loop->iteration }}</td>
                                                <td class="column__key--black text-center"
                                                    rowspan="{{ $num_reports }}">{{ $data->worker->user->doi }}</td>
                                                <td class="column__key--black text-center"
                                                    rowspan="{{ $num_reports }}">{{ $data->worker->nombre }}
                                                    {{ $data->worker->apellido }}</td>
                                                <td class="column__key--black text-center"
                                                    rowspan="{{ $num_reports }}">{{ $data->worker->position }}</td>
                                                <td class="text-center" style="width: 100px;"
                                                    rowspan="{{ $num_reports }}">{{ $data->worker->service->name }}
                                                </td>
                                            @endif
                                            <td class="text-center">
                                                {{ isset($details['start_date']) ? date('d-m-Y', strtotime($details['start_date'])) : '-' }}
                                            </td> <!-- Fecha -->
                                            <td class="text-center">{{ $i . '/' . $num_reports }}</td>
                                            <!-- Intento -->
                                            <td class="text-center">{{ $details['EPPs'] ?? '-' }}</td>
                                            <!-- Errores Epp -->
                                            <td class="text-center">{{ $details['Aislamiento'] ?? '-' }}</td>
                                            <!-- Errores Aislamiento -->
                                            <td class="text-center">{{ $details['Equipos de bloqueo'] ?? '-' }}</td>
                                            <!-- Errores Bloqueo -->
                                            <td class="text-center">{{ $details['Bloqueo y tarjeteo'] ?? '-' }}</td>
                                            <!-- Errores Tarjeteo -->
                                            <td class="text-center">{{ $details['maxNota'] ?? '-' }}</td>
                                        </tr>
                                    @endif
                                @endfor
                            @else
                                @if ($fechaInicio == null && $fechaFin == null)
                                    <tr
                                        style="background-color: {{ $loop->iteration % 2 == 0 ? '#c9c9c9' : '#ffffff' }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="column__key--black text-center">{{ $data->worker->user->doi }}</td>
                                        <td class="column__key--black text-center">{{ $data->worker->nombre }}
                                            {{ $data->worker->apellido }}</td>
                                        <td class="column__key--black text-center">{{ $data->worker->position }}</td>
                                        <td class="text-center" style="width: 100px;">
                                            {{ $data->worker->service->name }}</td>
                                        <td class="text-center">-</td> <!-- Fecha -->
                                        <td class="text-center">-</td> <!-- Intento -->
                                        <td class="text-center">-</td> <!-- Errores Epp -->
                                        <td class="text-center">-</td> <!-- Errores Aislamiento -->
                                        <td class="text-center">-</td> <!-- Errores Bloqueo -->
                                        <td class="text-center">-</td> <!-- Errores Tarjeteo -->
                                        <td class="text-center">-</td> <!-- Nota -->
                                    </tr>
                                @endif
                            @endif
                        @endif
                    @endforeach
                @else
                    <p>No hay datos disponibles.</p>
                @endif
            </tbody>
        </table>

    </div>
</body>

</html>
