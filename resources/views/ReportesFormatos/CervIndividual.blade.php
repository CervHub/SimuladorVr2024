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
    </style>
</head>

<body>
    <table class="header-table" style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr>
                <td style="width: 20%; text-align: left;">
                    <img src="" alt="Logo" style="width: 100px; height: auto;">
                </td>
                <td style="width: 60%; text-align: center; font-size: 24px; font-weight: bold;">
                    REPORTE POR PARTICIPANTE
                </td>
                <td style="width: 20%;"></td>
            </tr>
        </tbody>
    </table>

    <table>
        <tbody>
            <tr>
                <th class="bold">Nombre del Taller:</th>
                <td colspan="3">Nombre del Taller</td>
            </tr>
            <tr>
                <th class="bold">Usuario:</th>
                <td colspan="3">Nombre del Usuario</td>
            </tr>
            <tr>
                <th class="bold">Inicio:</th>
                <td>Fecha de Inicio</td>
                <th class="bold">Fin:</th>
                <td>Fecha de Fin</td>
            </tr>
            <tr>
                <th class="bold">Modalidad:</th>
                <td>Modalidad</td>
                <th class="bold">Plataforma:</th>
                <td>Plataforma</td>
            </tr>
            <tr>
                <th class="bold">% de Acierto:</th>
                <td>Nota Parcial</td>
                <th class="bold">Duración:</th>
                <td>Duración Total</td>
            </tr>
        </tbody>
    </table>

    <h5>Resumen General</h5>

    <table>
        <thead>
            <tr>
                <th>Tarea</th>
                <th>Total de Errores</th>
                <th>Porcentaje Completado</th>
                <th>Tiempo</th>
                <th>% de Acierto</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Tarea 1</td>
                <td style="text-align:center;">0</td>
                <td style="text-align:center;">100%</td>
                <td style="text-align:center;">00:30:00</td>
                <td style="text-align:center;">100%</td>
            </tr>
            <tr>
                <td>Tarea 2</td>
                <td style="text-align:center;">1</td>
                <td style="text-align:center;">90%</td>
                <td style="text-align:center;">00:45:00</td>
                <td style="text-align:center;">90%</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align:center;">Totales</th>
                <th style="text-align:center;">1</th>
                <th style="text-align:center;">95%</th>
                <th style="text-align:center;">01:15:00</th>
                <th style="text-align:center;">95%</th>
            </tr>
        </tfoot>
    </table>

    <h5>Acciones</h5>
    <table>
        <thead>
            <tr>
                <th>Tarea 1</th>
                <th style="text-align:left;">Descripción</th>
                <th style="text-align:center;">Intentos</th>
                <th style="text-align:center;">Duración</th>
                <th style="text-align:center;">Acumulado</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 30%; font-size:12px;">Acción 1</td>
                <td style="width: 40%; text-align: justify; font-size:12px;">
                    1. Descripción de la acción 1.
                </td>
                <td style="width: 10%; text-align: center; font-size:12px;">1</td>
                <td style="width: 10%; text-align: center; font-size:12px;">00:15:00</td>
                <td style="width: 10%; text-align: center; font-size:12px;">00:15:00</td>
            </tr>
            <tr>
                <td style="width: 30%; font-size:12px;">Acción 2</td>
                <td style="width: 40%; text-align: justify; font-size:12px;">
                    1. Descripción de la acción 2.
                </td>
                <td style="width: 10%; text-align: center; font-size:12px;">2</td>
                <td style="width: 10%; text-align: center; font-size:12px;">00:30:00</td>
                <td style="width: 10%; text-align: center; font-size:12px;">00:45:00</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
