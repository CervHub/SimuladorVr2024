<!DOCTYPE html>
<html>

<head>
    <title>Reporte</title>
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
    </style>
</head>

<body>
    <table class="header-table w-100">
        <tbody>
            <tr>
                <td class="w-20 text-left">
                    <img src="" alt="Logo" style="width: 100px; height: auto;">
                </td>
                <td class="w-60 text-center font-size-24 font-bold">
                    REPORTE DE EVALUACIÓN EN SIMULADOR
                </td>
                <td class="w-20"></td>
            </tr>
        </tbody>
    </table>



    <table class="w-100">
        <thead>
            <tr>
                <th colspan="3" class="text-center">DATOS DEL EVALUADO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="font-bold w-20">Nombres y Apellido:</th>
                <td class="w-30">{{ $data['worker']['nombres'] }}</td>
                <td class="w-40" rowspan="7" style="text-align: center; vertical-align: middle;">
                    <img src="{{ $data['worker']['photo'] }}" alt="Foto del trabajador" style="max-height: 150px;">
                </td>
            </tr>
            <tr>
                <th class="font-bold w-20">DNI:</th>
                <td class="w-30">{{ $data['worker']['doi'] }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">Licencia:</th>
                <td class="w-30">{{ $data['worker']['license'] }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">Categoría:</th>
                <td class="w-30">{{ $data['worker']['category'] }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">Hora Inicio:</th>
                <td class="w-30">{{ $data['json']['startDate'] }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">Hora Final:</th>
                <td class="w-30">{{ $data['json']['endDate'] }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">Tiempo de Evaluación:</th>
                <td class="w-30">-</td>
            </tr>
        </tbody>
    </table>

    <table class="w-100">
        <tbody>
            <tr>
                <th class="font-bold w-15">Puntaje Inicial:</th>
                <td class="w-30">100</td>
                <td class="w-15" rowspan="3" style="text-align: center; font-size: 1.5em;">
                    {{ $data['json']['note'] }}
                </td>
            </tr>
            <tr>
                <th class="font-bold w-15">Puntaje Final:</th>
                <td class="w-30">{{ $data['json']['note'] }}</td>
            </tr>
            <tr>
                <th class="font-bold w-15">Final:</th>
                <td class="w-30">
                    @if ($data['json']['note'] >= 80)
                        Aprobado
                    @else
                        No Aprobado
                    @endif
                </td>
            </tr>
        </tbody>
    </table>


    @php
        $worker = $data['worker'];
        $json = $data['json']; // Asumiendo que $data['json'] ya es un array
    @endphp

    @if ($json)
        <table class="w-100 no-margin-padding">
            <tr>
                <td class="no-border no-margin-left" style="width: 50%; vertical-align: top;">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">DATOS DEL EJERCICIO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($json['tables']['exercise'] as $item)
                                <tr>
                                    <th>{{ $item['name'] }}</th>
                                    <td>{{ $item['description'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td class="no-border no-margin-right" style="width: 50%; vertical-align: top;">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">DATOS DEL VEHÍCULO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($json['tables']['vehicleData'] as $item)
                                <tr>
                                    <th>{{ $item['name'] }}</th>
                                    <td>{{ $item['description'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <table class="w-100 no-margin-padding">
            <tr>
                <td class="no-border no-margin-left" style="width: 50%; vertical-align: top;">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th colspan="3" class="text-center">RESUMEN DEL EJERCICIO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>FACTOR/USO</th>
                                <th>Tiempo</th>
                                <th>Cantidad</th>
                            </tr>
                            @foreach ($json['tables']['summary'] as $item)
                                <tr>
                                    <th>{{ $item['name'] }}</th>
                                    <td>{{ $item['time'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td class="no-border no-margin-right" style="width: 50%; vertical-align: top;">
                    <table class="w-100">
                        <tbody>
                            @foreach ($json['tables']['extras'] as $item)
                                <tr>
                                    <th>{{ $item['name'] }}</th>
                                    <td>{{ $item['description'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <table class="w-100">
            <thead>
                <tr>
                    <th>Infracción</th>
                    <th>Puntaje</th>
                    <th>Repetición</th>
                    <th>Total Puntos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($json['tables']['infractions'] as $item)
                    <tr>
                        <th>{{ $item['name'] }}</th>
                        <td>{{ $item['score'] }}</td>
                        <td>{{ $item['repetition'] }}</td>
                        <td>{{ $item['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="w-100">
            <thead>
                <tr>
                    <th colspan="4" class="text-center">DETALLES DE LA EVALUACIÓN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Acción</th>
                    <th>Tiempo Ocurrido</th>
                    <th>Tipo de evento</th>
                    <th>Descripción</th>
                </tr>
                @foreach ($json['details'] as $item)
                    <tr>
                        <th>{{ $item['action'] }}</th>
                        <td>{{ $item['currentTime'] }}</td>
                        <td>{{ $item['eventType'] }}</td>
                        <td>{{ $item['description'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se encontró data</p>
    @endif

    <table class="w-100">
        <tbody class="no-border">

            <tr class="no-border">
                <td class="no-border text-center"></td>
                <td class="no-border text-center"></td>
            </tr>
            <tr class="no-border">
                <td class="no-border text-center">_________________________ <br>{{ $data['worker']['nombres'] }}</td>
                <td class="no-border text-center">_________________________ <br>{{ $header['instructor'] }}</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
