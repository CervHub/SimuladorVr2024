{% load static %}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General</title>
    <style>
        /* Cambiar la fuente del título h1 */
        body {
            font-family: 'Arial', sans-serif;
        }

        h3 {
            margin-top: 20px;
            /* Agrega un margen superior para evitar el solapamiento con los logos */
        }

        /* Estilo para los logos en las esquinas */
        .corner-logo {
            position: absolute;
            height: 32px;
        }

        /* Logo en la esquina superior izquierda */
        .corner-logo.top-left {
            top: 0;
            left: 0;
        }

        /* Logo en la esquina superior derecha */
        .corner-logo.top-right {
            top: 0;
            right: 0;
        }

        .text-center {
            text-align: center !important;
        }

        /* Border classes */
        .border-top {
            border-top: 2px solid #000;
        }

        .border-bottom {
            border-bottom: 2px solid #000;
        }

        .border-right {
            border-right: 2px solid #000;
        }

        .border-left {
            border-left: 2px solid #000;
        }

        /* Estilos para las columnas */
        .column {
            width: 33.33%;
            float: left;
            padding: 10px;
        }

        .text-danger {
            color: red;
        }

        /* Estilos para la tabla */
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        /* Clase para texto en negrita (bold) */
        .texto-bold {
            font-weight: bold;
        }

        /* Clase para texto subrayado */
        .texto-subrayado {
            text-decoration: underline;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            /* Añade relleno para separar el texto del borde */
            text-align: left;
            padding: 3px;
        }


        .table,
        body {
            font-size: 11px;
        }


        .table th:first-child,
        .table td:first-child {
            width: 220px;
            /* Ancho de la primera columna */
        }

        .table td:nth-child(3) {
            width: 100px;
            /* Ancho de la tercera columna */
        }

        .perfil {
            background-size: cover;
            background-position: center;
            width: 150px;
            margin: 0;
            /* Elimina cualquier margen interior */
            padding: 0;
            /* Elimina cualquier relleno interior */
        }

        .mt-0 {
            margin-top: 0;
        }

        .mt-1 {
            margin-top: 0.25rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .mt-5 {
            margin-top: 3rem;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .mb-5 {
            margin-bottom: 3rem;
        }

        .empty-cell {
            border: 1px solid transparent !important;
        }

        .cell {
            border: 1px solid black !important;
        }

        .empty-cell-fin {
            border-bottom: 1px solid transparent !important;
        }

        .centered-table {
            margin: 0 auto;
        }

        .texto-white {
            color: white !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>

<body>
    <!-- Logo en la esquina superior izquierda -->

    <table class="table">
        <tbody>
            <tr>
                <th rowspan="2" style="width:60px !important;">
                    <img src="{{$logo}}" width="64px" alt="Logo">
                </th>
                <th class="text-center">CONFIPETROL</th>
                <th rowspan="2" style="width:60px !important;">
                    Código: O&M-IMC1-F-3
                    Versión: 2
                    Fecha: 15-11-2019
                    Página 1 de 5
                </th>
            </tr>
            <tr>
                <th class="text-center">REPORTE DE FALLA</th>
            </tr>
        </tbody>
    </table>

    <table class="table mt-4">
        <tbody>
            <tr>
                <td>CONTRATO / CLIENTE</td>
                <td></td>
                <td>FECHA DEL REPORTE</td>
                <td></td>
            </tr>
            <tr>
                <td>PERSONA QUE REPORTA</td>
                <td></td>
                <td>CARGO DE QUIEN REPORTA</td>
                <td></td>
            </tr>
            <tr>
                <td>NOMBRE EVENTO</td>
                <td></td>
                <td colspan="2">
                    FINALIZADO: <input type="checkbox" name="finalizado" value="si"> SI <input type="checkbox"
                        name="finalizado" value="no"> NO
                </td>
            </tr>
        </tbody>
    </table>

    <h3 class="texto-bold texto-subrayado">1. INFORMACIÓN GENERAL</h3>

    <h4 class="texto-bold mb-1">1.1 Ubicación </h4>

    <table class="table">
        <tbody>
            <tr>
                <td>CAMPO</td>
                <td>SISTEMA</td>
                <td>EQUIPO</td>
                <td>COMPONENTE QUE FALLA</td>
            </tr>
            <tr>
                <td>Ubicación Técnica</td>
                <td colspan="3"> Jerarquía en niveles según CMMS (SAP, ELLIPSE, MP9, Etc) Ej: CC-MSEJUYS-CART-CFGT</td>
            </tr>
        </tbody>
    </table>

    <h4 class="texto-bold mb-1">1.2 Fechas </h4>

    <table class="table">
        <tbody>
            <tr>
                <td colspan="2">FECHA Y HORA DEL EVENTO</td>
                <td colspan="2">FECHA Y HORA DE REESTABLECIMIENTO</td>
                <td rowspan="2">HOROMETRO</td>
                <td rowspan="2">No. AVISO/OT EN CMMS</td>
            </tr>
            <tr>
                <td>(DD/MM/AAAA)</td>
                <td>(HH:MM)</td>
                <td>(DD/MM/AAAA)</td>
                <td>(HH:MM)</td>
            </tr>
            <tr>
                <td class="texto-white">asd</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <h4 class="texto-bold mb-1">1.3 Valoración* </h4>

    <table class="table">
        <tbody>
            <tr>
                <td style="width: 10px;"></td>
                <td colspan="5">Severidad</td>
                <td colspan="5">Frecuencia ocurrencia</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;">No.</td>
                <td class="text-center" style="width: 50px;">Personas</td>
                <td class="text-center" style="width: 50px;">Económica</td>
                <td class="text-center" style="width: 50px;">Ambiental</td>
                <td class="text-center" style="width: 50px;">Pérdidas de Producción</td>
                <td class="text-center" style="width: 50px;">Imagen de la empresa</td>
                <td class="text-center" style="width: 50px;">1 Vez cada 5 años o más</td>
                <td class="text-center" style="width: 50px;">1 Vez cada 3 años</td>
                <td class="text-center" style="width: 50px;">1 Vez al Año</td>
                <td class="text-center" style="width: 50px;">1 Vez cada 3 meses</td>
                <td class="text-center" style="width: 50px;">1 Vez al mes</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;">1</td>
                <td class="text-center" style="width: 50px;">Fatalidad</td>
                <td class="text-center" style="width: 50px;">Mayor a 50.000 USD</td>
                <td class="text-center" style="width: 50px;">Mayor (Fuga mayor a 100 Bls)</td>
                <td class="text-center" style="width: 50px;">Mayor a 10%</td>
                <td class="text-center" style="width: 50px;">Internacional</td>
                <td class="text-center" style="width: 50px;">Media</td>
                <td class="text-center" style="width: 50px;">Media</td>
                <td class="text-center" style="width: 50px;">Alta</td>
                <td class="text-center" style="width: 50px;">Alta</td>
                <td class="text-center" style="width: 50px;">Muy Alta</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;">2</td>
                <td class="text-center" style="width: 50px;">Incapacidad Permanente (Total o Parcial)</td>
                <td class="text-center" style="width: 50px;">Entre 25.001 a 50.000 USD</td>
                <td class="text-center" style="width: 50px;">Importante (Fuga entre 10 a 100 Bls) </td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
                <td class="text-center" style="width: 50px;"></td>
            </tr>
            
        </tbody>
    </table>
    <section id="datos_usuario">
        <table style="width: 100%;" class="mt-0">
            <tr>
                <td style="width: 100%;">
                    <h5 class="text-danger mb-1">DATOS DEL USUARIO</h5>
                    <table class="table" style="width: 100%;">
                        <tr>
                            <th>Nombres y Apellidos:</th>
                            <td></td>
                            <td rowspan="7">
                                <img class="perfil" src="" alt="Imagen de usuario">
                            </td>
                        </tr>
                        <tr>
                            <th>Registro:</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Fecha Inicio:</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Fecha Final:</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Tiempo de evaluación:</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Tiempo práctica previo a evaluación:</th>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </section>

    <section id="datos_ejercicio" class="mt-0">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <h5 class="mb-1 mt-0 text-danger">DATOS DEL EJERCICIO</h5>
                    <table class="table" style="width: 100%;">
                        <tr>
                            <th style="width: 120px;">Equipo</th>
                            <td>Romperocas BTI TTX45/BXR85</td>
                        </tr>
                        <tr>
                            <th style="width: 120px;">Modo</th>
                            <td>Realidad virtual</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <h5 class="mb-1 mt-0 text-danger">DATOS DEL EVALUADOR</h5>
                    <table class="table" style="width: 100%;">
                        <tr>
                            <th style="width: 120px;">Nombres y apellidos</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th style="width: 120px;">Registro</th>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </section>

    <section id="resumen_ejercicio">
        <table style="width: 100%;">
            <tr>
                <td style=" vertical-align: top;">
                    <h5 class="mb-1 mt-0 text-danger">RESUMEN DEL EJERCICIO</h5>
                    <table class="table" style="width: 100%;">
                        <tr>
                            <th style="width: 200px;">Descripción</th>
                            <th style="width: 58px; text-align: center;">Tiempo</th>
                            <th style="width: 50px; text-align: center;">Cantidad</th>
                        </tr>
                        {% for resumen_clave in data.resumen %}
                        <tr>
                            <td style="width: 200px;"></td>
                            <td style="width: 58px; text-align: center;"></td>
                            <td style="width: 50px; text-align: center;"></td>
                        </tr>
                        {% endfor %}
                    </table>

                </td>
                <td style=" vertical-align: top;">
                    <h5 class="mb-1 mt-0 text-danger">MÓDULOS DE IMMERSIÓN</h5>
                    <table class="table" style="width: 100%;">
                        <tr>
                            <th style="width: 200px;">Descripción</th>
                            <th style="width: 58px; text-align: center;">Si/No</th>
                            <th style="width: 50px; text-align: center;">Tiempo</th>
                        </tr>
                        <tr>
                            <td style="width: 200px;">Immersión sala de Lubricación</td>
                            <td style="width: 58px; text-align: center;">Si</td>
                            <td style="width: 50px; text-align: center;">00:30:00</td>
                        </tr>
                        <tr>
                            <td style="width: 200px;">Immersión general del equipo</td>
                            <td style="width: 58px; text-align: center;">Si</td>
                            <td style="width: 50px; text-align: center;">00:30:00</td>
                        </tr>
                        <tr>
                            <td style="width: 200px;">Immersión sala de control</td>
                            <td style="width: 58px; text-align: center;">Si</td>
                            <td style="width: 50px; text-align: center;">00:30:00</td>
                        </tr>
                        <tr>
                            <td style="width: 200px;">Immersión bloqueo remoto</td>
                            <td style="width: 58px; text-align: center;">Si</td>
                            <td style="width: 50px; text-align: center;">00:30:00</td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>

        <table style="width: 100%;" class="mt-1">
            <tr>
                <td style="width: 100%;">
                    <table class="table">
                        <tr>
                            <th>Infracción</th>
                            <th style="text-align: center;">Puntaje</th>
                            <th style="text-align: center;">Repetición</th>
                            <th style="text-align: center;">Total Puntos</th>
                        </tr>
                        {% for item in data.errores %}
                        <tr>
                            <td></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                            <td style="text-align: center;"></td>
                        </tr>
                        {% endfor %}
                        <tr>
                            <td class="empty-cell"></td>
                            <td class="empty-cell-fin"></td>
                            <td style="text-align: center;">Sub total:</td>
                            <td style="text-align: center;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </section>

    <section id="resultados">
        <table style="width: 100%;" class="mt-1">
            <tr>
                <td>

                    <table class="table" style="width: 688px;">
                        <tr>
                            <th style="width: 450px;">Caso:</th>
                            <th style="text-align: center; width: 60px;">T.Objetivo</th>
                            <th style="text-align: center; width: 60px;">T Real</th>
                            <th style="text-align: center; width: 60px;">Puntaje</th>
                        </tr>
                        {% for item in data.casos %}
                        <tr>
                            <td></td>
                            <td style="text-align: center; width: 60px;"></td>
                            <td style="text-align: center; width: 60px;"></td>
                            <td style="text-align: center; width: 60px;"></td>
                        </tr>
                        {% endfor %}

                        <tr>
                            <td class="empty-cell"></td>
                            <td class="empty-cell-fin"></td>
                            <td style="width: 60px; text-align:center;">Sub total:</td>
                            <td style="width: 60px; text-align:center;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </section>


</body>

</html>