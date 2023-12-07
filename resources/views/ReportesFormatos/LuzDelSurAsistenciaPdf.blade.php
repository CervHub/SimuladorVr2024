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
</style>

<body style="box-sizing: border-box">

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
                <td style=" padding: 0;" class="text-center text-small text-bold">{{$result->count()}}
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
            Expositor : {{$induction->worker->user->name}} {{$induction->worker->user->last_name}}
        </h3>
    </section>

    <section>
        <h4 style="padding: 0; margin: 0;">
            Marcar con (X) según corresponda:
        </h4>
        <h4 class="text-light" style="padding: 0; margin-top: 15px; text-align:center;">
            1-Inducción( ) 2-Capacitación( X ) 3-Entrenamiento(  ) 4-Jornada( ) 5-Simulacro de Emergencia( )
        </h4>
    </section>

    <table border="1" style="width: 100%">
        <thead>
            <tr>
                <th class="text-small2" style="width: 5%">ITEM</th>
                <th class="text-small2" style="width: 10%">FICHA</th>
                <th class="text-small2" style="width: 15%">NOMBRES</th>
                <th class="text-small2" style="width: 15%">APELLIDOS</th>
                <th class="text-small2" style="width: 10%">DNI</th>
                <th class="text-small2" style="width: 15%">ÁREA</th>
                <th class="text-small2" style="width: 10%">NOTA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($result as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$item->employee_code}}</td>
                    <td>{{$item->nombre}}</td>
                    <td>{{$item->apellido}}</td>
                    <td>{{$item->doi}}</td>
                    <td>{{$item->department}}</td>
                    <td>-</td>
                </tr>
            @endforeach
            <!-- Add more rows as needed -->
        </tbody>
    </table>

    <br>
    <table border="1" style="width: 100%;">
        <tbody>
            <tr>
                <td rowspan="2"
                    style="width: 50%; text-align: left; vertical-align: top; text-decoration: underline;"
                    class="text-small2">
                    Observaciones:
                </td>
                <td style="width: 50%; height: 20px; text-align: left; vertical-align: bottom;" class="text-small2">
                    Capacitador: {{$induction->worker->nombre}} {{$induction->worker->apellido}}</td>
            </tr>
            <tr>
                <td style="height: 80px; text-align: left; vertical-align: bottom; position: relative;" class="text-small2">
                    <img src="{{ $signature }}" alt="" style="max-height: 95%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: -1;">
                    Firma:_________________________________________________
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>
