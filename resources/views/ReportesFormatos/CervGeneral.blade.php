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
            padding: 5px;
            text-align: left;
            font-size: 13px;
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
                    REPORTE DE EVALUACIÓN
                </td>
                <td class="w-20"></td>
            </tr>
        </tbody>
    </table>

    <table class="w-100">
        <tbody>
            <tr>
                <th class="font-bold w-20">Nombre del Taller:</th>
                <td colspan="3">{{ $header['taller'] ?? '-' }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">Nombre del Instructor:</th>
                <td>{{ $header['instructor'] ?? '-' }}</td>
                <th class="font-bold w-20">DNI:</th>
                <td>{{ $header['instructor_doi'] ?? '-' }}</td>
            </tr>
            <tr>
                <th class="font-bold w-20">Fecha Inicio:</th>
                <td>{{ $header['date_start'] ?? '0000-00-00' }}</td>
                <th class="font-bold w-20">Fecha Fin:</th>
                <td>{{ $header['date_end'] ?? '0000-00-00' }}</td>
            </tr>
        </tbody>
    </table>

    <h5>Acciones</h5>
    <table class="w-100">
        <thead>
            <tr>
                <th class="w-5">Nº</th>
                <th class="text-left w-10">DNI</th>
                <th class="text-center w-10">LICENCIA</th>
                <th class="text-center w-30">NOMBRES Y APELLIDOS</th>
                <th class="text-center w-5">INTENTO</th>
                <th class="text-center w-15">F. INICIO</th>
                <th class="text-center w-15">F. FIN</th>
                <th class="text-center">NOTA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($newNoteJson as $item)
                @php
                    $start_dates = [];
                    $end_dates = [];
                    $notes = [];
                    $attempts = [];

                    foreach ($item as $i) {
                        $start_dates[] = $i['start_date'];
                        $end_dates[] = $i['end_date'];
                        $notes[] = $i['note'];
                        $attempts[] = $i['attempt']; // Assuming 'attempt' is the key for the attempt data
                    }
                @endphp
                <td class="w-5">Nº</td>
                <td class="text-left w-10">DNI</td>
                <td class="text-center w-10">LICENCIA</td>
                <td class="text-center w-30">NOMBRES Y APELLIDOS</td>
                <td class="text-center">{!! implode('<br>', $attempts) !!}</td>
                <td class="text-center w-15">{!! implode('<br>', $start_dates) !!}</td>
                <td class="text-center w-15">{!! implode('<br>', $end_dates) !!}</td>
                <td class="text-center">{!! implode('<br>', $notes) !!}</td>
            @endforeach
        </tbody>
    </table>
</body>

</html>
