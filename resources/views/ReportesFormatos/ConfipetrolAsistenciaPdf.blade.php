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
                        <img src="{{$logo}}" width="64px" alt="Logo">
                    </td>
                    <td nowrap colspan="4" style="padding-top: 0px; padding-bottom: 0px;">
                        <h3 class="title">REPORTE DE EVALUACIÓN</h3>
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
                        {{$induction->alias}}
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%">
                        <span class="column__key">
                            Instructor:
                        </span>
                    </td>
                    <td colspan="11">
                        {{$induction->worker->nombre}} {{$induction->worker->apellido}}
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%">
                        <span class="column__key">
                            Fecha de Inicio:
                        </span>
                    </td>
                    <td colspan="5">
                        {{$induction->date_start}} {{$induction->time_start}}
                    </td>
                    <td style="width: 20%">
                        <span class="column__key">
                            Fecha de Fin:
                        </span>
                    </td>
                    <td colspan="5">
                        {{$induction->date_end}} {{$induction->time_end}}
                    </td>
                </tr>
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
        <table style="width: 100%">
            <tbody>
                <tr style="background-color: #c9c9c9;">
                    <td class="text-center" style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; width: 5%;">
                        N°
                    </td>
                    <td class="text-center" style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; width: 20%;">
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
                    <td class="text-center" style="font-weight: bold;padding-top: 0px; padding-bottom: 0px; width: 5%;">
                        NOTA
                    </td>
                </tr>
                <?php $rowNumber = 1; ?>
                @foreach($induction_worker as $data)
                @if($id_service != 0)
                @if($data->worker->service->id == $id_service)
                <tr style="background-color: {{ $rowNumber % 2 == 0 ? '#c9c9c9' : '#ffffff' }}">
                    <td class="text-center">{{ $rowNumber }}</td>
                    <td class="column__key--black text-center">{{ $data->worker->user->doi }}</td>
                    <td class="column__key--black text-center">{{ $data->worker->nombre }} {{ $data->worker->apellido }}</td>
                    <td class="column__key--black text-center">{{ $data->worker->position }}</td>
                    <td class="text-center" style="width: 100px;">{{$data->worker->service->name}}</td>
                    <td class="text-center">-</td>
                </tr>
                <?php $rowNumber++; ?>
                @endif
                @else
                <tr style="background-color: {{ $rowNumber % 2 == 0 ? '#c9c9c9' : '#ffffff' }}">
                    <td class="text-center">{{ $rowNumber }}</td>
                    <td class="column__key--black text-center">{{ $data->worker->user->doi }}</td>
                    <td class="column__key--black text-center">{{ $data->worker->nombre }} {{ $data->worker->apellido }}</td>
                    <td class="column__key--black text-center">{{ $data->worker->position }}</td>
                    <td class="text-center" style="width: 100px;">{{$data->worker->service->name}}</td>
                    <td class="text-center">{{$data->notaConfipetrol()}}</td>
                </tr>
                <?php $rowNumber++; ?>
                @endif
                @endforeach
            </tbody>
        </table>

    </div>
</body>

</html>
