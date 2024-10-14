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
                    <img src="{{ $logo }}" alt="Logo" style="width: 100px; height: auto;">
                </td>
                <td class="w-60 text-center font-bold" style="font-size: 16px;">
                    REPORTE DE EVALUACIÓN
                </td>
                <td class="w-20"></td>
            </tr>
        </tbody>
    </table>


    <!-- Tabla de Datos del Evaluado -->
    <table class="w-100">
        <thead>
            <tr>
                <th colspan="2" class="text-center">DATOS DEL EVALUADO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="font-bold w-20">Nombres y Apellido:</th>
                <td class="w-80">{{ $data['worker']['nombres'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">DNI:</th>
                <td class="w-80">{{ $data['worker']['doi'] ?? 'N/A' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Tabla de Datos de la Evaluación -->
    <table class="w-100">
        <thead>
            <tr>
                <th colspan="2" class="text-center">DATOS DE LA EVALUACIÓN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="font-bold w-20">Taller:</th>
                <td class="w-80">{{ $header['taller'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">Hora Inicio:</th>
                <td class="w-80">{{ $data['json']['startDate'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">Hora Final:</th>
                <td class="w-80">{{ $data['json']['endDate'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">Tiempo de Evaluación:</th>
                <td class="w-80">
                    @php
                        function secondsToTime($seconds)
                        {
                            $seconds = str_replace(',', '.', $seconds);

                            if (!is_numeric($seconds)) {
                                return '00:00:00';
                            }

                            $seconds = floatval($seconds);

                            $hours = floor($seconds / 3600);
                            $minutes = floor(($seconds % 3600) / 60);
                            $seconds = $seconds % 60;
                            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                        }
                    @endphp

                    {{ isset($data['json']['time']) ? secondsToTime($data['json']['time']) : '00:00:00' }}
                </td>
            </tr>
        </tbody>
    </table>

    @php
        $worker = $data['worker'] ?? [];
        $json = $data['json'] ?? []; // Asumiendo que $data['json'] ya es un array
    @endphp

    @if ($json)
        <table class="w-100">
            <thead>
                <tr>
                    <th colspan="3" class="text-center">DETALLES DE LA EVALUACIÓN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Acción</th>
                    <th>Conteo de Errores</th>
                    <th>Puntuación de Errores por Tarea</th>
                </tr>
                @foreach ($json['details'] ?? [] as $item)
                    <tr>
                        <th>{{ $item['action'] ?? 'N/A' }}</th>
                        <td>{{ $item['errorCount'] ?? 'N/A' }}</td>
                        <td>{{ $item['errorScoreByTask'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se encontró data</p>
    @endif

    <table class="w-100">
        <tbody>
            <tr>
                <th class="font-bold w-20">Puntaje Inicial:</th>
                <td>{{ $data['json']['result']['initialScore'] ?? '-' }}</td>
                <td class="w-15" rowspan="3" style="text-align: center; font-size: 1.5em;">
                    {{ $data['json']['result']['finalScore'] ?? '-' }}
                </td>
            </tr>
            <tr>
                <th class="font-bold w-20">Puntaje Errores:</th>
                <td>{{ $data['json']['result']['errorScore'] ?? '-' }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">Puntaje Final:</th>
                <td>
                    @if (($data['json']['result']['finalScore'] ?? 0) >= 80)
                        Aprobado
                    @else
                        No Aprobado
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    {{-- <table class="w-100" style="margin-top: 150px;">
        <tbody class="no-border">
            <tr class="no-border">
                <td class="no-border text-center"></td>
                <td class="no-border text-center">
                </td>
            </tr>
            <tr class="no-border">
                <td class="no-border text-center">_________________________
                    <br>{{ $data['worker']['nombres'] ?? 'N/A' }}
                </td>

                <td class="no-border text-center">_________________________

                    <br>{{ $header['instructor'] ?? 'N/A' }}
                </td>
            </tr>
        </tbody>
    </table> --}}
</body>

</html>
