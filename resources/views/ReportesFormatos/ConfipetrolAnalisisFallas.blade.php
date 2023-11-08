{% load static %}

<!DOCTYPE html>
<html lang="en"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General</title> <style> /* Cambiar la fuente del título h1 */ body { font-family: 'Arial' ,
    sans-serif; } h3 { margin-top: 20px; /* Agrega un margen superior para evitar el solapamiento con los logos */ } /*
    Estilo para los logos en las esquinas */ .corner-logo { position: absolute; height: 32px; } /* Logo en la esquina
    superior izquierda */ .corner-logo.top-left { top: 0; left: 0; } /* Logo en la esquina superior derecha */
    .corner-logo.top-right { top: 0; right: 0; } .text-center { text-align: center !important; } /* Border classes */
    .border-top { border-top: 2px solid #000; } .border-bottom { border-bottom: 2px solid #000; } .border-right {
    border-right: 2px solid #000; } .border-left { border-left: 2px solid #000; } /* Estilos para las columnas */
    .column { width: 33.33%; float: left; padding: 10px; } .text-danger { color: red; } /* Estilos para la tabla */
    .table { border-collapse: collapse; width: 100%; } /* Clase para texto en negrita (bold) */ .texto-bold {
    font-weight: bold; } /* Clase para texto subrayado */ .texto-subrayado { text-decoration: underline; }
    .text-justify{ text-align: justify; } .table th, .table td { border: 1px solid #000; /* Añade relleno para separar
    el texto del borde */ text-align: left; padding: 3px; } .table, body { font-size: 11px; } .table th:first-child,
    .table td:first-child { width: 220px; /* Ancho de la primera columna */ } .table td:nth-child(3) { width: 100px; /*
    Ancho de la tercera columna */ } .perfil { background-size: cover; background-position: center; width: 150px;
    margin: 0; /* Elimina cualquier margen interior */ padding: 0; /* Elimina cualquier relleno interior */ } .mt-0 {
    margin-top: 0; } .mt-1 { margin-top: 0.25rem; } .mt-2 { margin-top: 0.5rem; } .mt-3 { margin-top: 1rem; } .mt-4 {
    margin-top: 1.5rem; } .mt-5 { margin-top: 3rem; } .mb-0 { margin-bottom: 0; } .mb-1 { margin-bottom: 0.25rem; }
    .mb-2 { margin-bottom: 0.5rem; } .mb-3 { margin-bottom: 1rem; } .mb-4 { margin-bottom: 1.5rem; } .mb-5 {
    margin-bottom: 3rem; } .empty-cell { border: 1px solid transparent !important; } .cell { border: 1px solid black
    !important; } .empty-cell-fin { border-bottom: 1px solid transparent !important; } .centered-table { margin: 0 auto;
    } .texto-white { color: white !important; } </style> <link rel="stylesheet" type="text/css" href="estilos.css">
    </head>

<body> <!-- Logo en la esquina superior izquierda -->

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
                <td class="text-center">CAMPO</td>
                <td class="text-center">SISTEMA</td>
                <td class="text-center">EQUIPO</td>
                <td class="text-center">COMPONENTE QUE FALLA</td>
            </tr>
            <tr>
                <td class="texto-white">as</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>
            <tr>
                <td class="text-center">Ubicación Técnica</td>
                <td class="text-center" colspan="3"> Jerarquía en niveles según CMMS (SAP, ELLIPSE, MP9, Etc) Ej:
                    CC-MSEJUYS-CART-CFGT</td>
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
                <td class="text-center" style="width: 50px;">Importante(Fuga entre 10 a 100 Bls) </td>
                <td class="text-center" style="width: 50px;">Entre 7% y 10% Prod. Diaria</td>
                <td class="text-center" style="width: 50px;">Nacional con afectaciones</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Media</td>
                <td class="text-center" style="width: 50px;">Media</td>
                <td class="text-center" style="width: 50px;">Alta</td>
                <td class="text-center" style="width: 50px;">Alta</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;">3</td>
                <td class="text-center" style="width: 50px;">Incapacidad Temporal</td>
                <td class="text-center" style="width: 50px;">Entre 10.001 a 25.000 USD</td>
                <td class="text-center" style="width: 50px;">Localizada (Fuga entre 1 a 10 Bls)</td>
                <td class="text-center" style="width: 50px;">Entre 3% y 7% Prod. Diaria</td>
                <td class="text-center" style="width: 50px;">Nacional sin afectaciones</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Media</td>
                <td class="text-center" style="width: 50px;">Alta</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;">4</td>
                <td class="text-center" style="width: 50px;">Lesión Menor (Sin Incapacidad)</td>
                <td class="text-center" style="width: 50px;">Entre 2001 a 10.000 USD</td>
                <td class="text-center" style="width: 50px;">Menor (Fuga Entre 0,1 a 1 Bls)</td>
                <td class="text-center" style="width: 50px;">Entre 1% y 3% Prod. Diaria</td>
                <td class="text-center" style="width: 50px;">Nacional y baja importancia</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Media</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;">5</td>
                <td class="text-center" style="width: 50px;">Lesión Leve</td>
                <td class="text-center" style="width: 50px;">Menor a 2000 USD</td>
                <td class="text-center" style="width: 50px;">Leve (Fuga Menor 0,1 Bls)</td>
                <td class="text-center" style="width: 50px;">Menor a 1% Prod. Diaria</td>
                <td class="text-center" style="width: 50px;">Local o baja importancia</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Baja</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;">6</td>
                <td class="text-center" style="width: 50px;">Ninguna</td>
                <td class="text-center" style="width: 50px;">Ninguna</td>
                <td class="text-center" style="width: 50px;">Ninguna</td>
                <td class="text-center" style="width: 50px;">Ninguna</td>
                <td class="text-center" style="width: 50px;">Ninguna</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td class="text-center" style="width: 50px;">A</td>
                <td class="text-center" style="width: 50px;">B</td>
                <td class="text-center" style="width: 50px;">C</td>
                <td class="text-center" style="width: 50px;">D</td>
                <td class="text-center" style="width: 50px;">E</td>
            </tr>
        </tbody>
    </table>

    <section id="datos_ejercicio" class="mt-1">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="3" style="width: 150px;">Valoración de Riesgo Real</td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width:50px;">Descripción</td>
                                <td class="text-center" style="width:50px;">Afectación</td>
                                <td class="text-center" style="width:50px;">Clasificación</td>
                            </tr>
                            @foreach ($json['real'] as $subarray)
                            <tr>
                                @foreach ($subarray as $value)
                                <td class="text-center" style="width:50px;">{{ $value }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="3" style="width: 150px;">Valoración de Riesgo Potencial
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center" style="width:50px;">Descripción</td>
                                <td class="text-center" style="width:50px;">Afectación</td>
                                <td class="text-center" style="width:50px;">Clasificación</td>
                            </tr>
                            @foreach ($json['potencial'] as $subarray)
                            <tr>
                                @foreach ($subarray as $value)
                                <td class="text-center" style="width:50px;">{{ $value }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </section>

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
                    Página 2 de 5
                </th>
            </tr>
            <tr>
                <th class="text-center">REPORTE DE FALLA</th>
            </tr>
        </tbody>
    </table>

    <h3 class="texto-bold texto-subrayado">2. CONTEXTO OPERACIONAL</h3>
    <p class="text-justify">
        {{$json['contexto_operacional']}}

    </p>

    <h3 class="texto-bold texto-subrayado">3. DESCRIPCIÓN DE LA FALLA Y SECUENCIA DE EVENTOS</h3>
    <p class="text-justify">
        {{$json['descripcion_de_falla']}}
    </p>
    <h4 class="texto-bold mb-1">Descripción Falla:</h4>

    <h4 class="texto-bold mb-1">Secuencia Eventos:</h4>
    <table class="table">
        <tbody>
            <tr>
                <td style="width:5px !important;" class="text-center texto-bold">Fecha</td>
                <td style="width:5px !important;" class="text-center texto-bold">Hora</td>
                <td style="width:300px;" class="text-center texto-bold">Descripción Actividad, Suceso, Evento</td>
            </tr>
            <tr>
                <td style="width:5px !important;" class="texto-white text-center">a</td>
                <td style="width:5px !important;" class="text-center"></td>
                <td style="width:300px;" class="text-center"></td>
            </tr>
            <tr>
                <td style="width:5px !important;" class="texto-white text-center">a</td>
                <td style="width:5px !important;" class="text-center"></td>
                <td style="width:300px;" class="text-center"></td>
            </tr>
            <tr>
                <td style="width:5px !important;" class="texto-white text-center">a</td>
                <td style="width:5px !important;" class="text-center"></td>
                <td style="width:300px;" class="text-center"></td>
            </tr>
            <tr>
                <td style="width:5px !important;" class="texto-white text-center">a</td>
                <td style="width:5px !important;" class="text-center"></td>
                <td style="width:300px;" class="text-center"></td>
            </tr>
            <tr>
                <td style="width:5px !important;" class="texto-white text-center">a</td>
                <td style="width:5px !important;" class="text-center"></td>
                <td style="width:300px;" class="text-center"></td>
            </tr>
            <tr>
                <td style="width:5px !important;" class="texto-white text-center">a</td>
                <td style="width:5px !important;" class="text-center"></td>
                <td style="width:300px;" class="text-center"></td>
            </tr>
            <tr>
                <td style="width:5px !important;" class="texto-white text-center">a</td>
                <td style="width:5px !important;" class="text-center"></td>
                <td style="width:300px;" class="text-center"></td>
            </tr>
            <tr>
                <td style="width:5px !important;" class="texto-white text-center">a</td>
                <td style="width:5px !important;" class="text-center"></td>
                <td style="width:300px;" class="text-center"></td>
            </tr>

        </tbody>
    </table>
    <h3 class="texto-bold texto-subrayado">4. ANTECEDENTES Y EVIDENCIAS:</h3>
    <p class="text-justify">
        (Listado de evidencias e historial que sirva como soporte para identificar la causa raíz de las fallas.
        Metodología 4P’s Personas, Papel, Partes, Posición.)
    </p>


    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
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
                    Página 2 de 5
                </th>
            </tr>
            <tr>
                <th class="text-center">REPORTE DE FALLA</th>
            </tr>
        </tbody>
    </table>

    <h3 class="texto-bold texto-subrayado">5. ANÁLISIS DE LA FALLA Y DETERMINACIÓN DE CAUSA RAÍZ</h3>
    <p class="text-justify">
        (Anexar el árbol causal de falla)
    </p>

    <table class="table">
        <tbody>
            <tr>
                <td class="texto-bold">Causa Raíz física:</td>
                <td></td>
            </tr>
            <tr>
                <td class="texto-bold">Causa Raíz Humana:
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="texto-bold">Causa Raíz Sistema/Latente:</td>
                <td></td>
            </tr>
        </tbody>
    </table>


    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
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
                    Página 4 de 5
                </th>
            </tr>
            <tr>
                <th class="text-center">REPORTE DE FALLA</th>
            </tr>
        </tbody>
    </table>

    <h3 class="texto-bold texto-subrayado">6. ACCIONES DE VERIFICACIÓN DE HIPÓTESIS</h3>
    <p class="text-justify">
        (Documente las acciones realizadas para verificar las hipótesis de falla)
    </p>
    <table class="table">
        <tbody>
            <tr>
                <td class="text-center texto-bold" style="width:50px;" rowspan="2">Modo de falla</td>
                <td class="text-center texto-bold" style="width:50px;" rowspan="2">Hipótesis de la falla</td>
                <td class="text-center texto-bold" style="width:50px;" rowspan="2">Acción de Verificación</td>
                <td class="text-center texto-bold" style="width:50px;" rowspan="2">Responsable</td>
                <td class="text-center texto-bold" style="width:50px;" rowspan="2">Fecha</td>
                <td class="text-center texto-bold" style="width:50px;" colspan="2">Resultado</td>
            </tr>
            <tr>
                <td class="text-center texto-bold" style="width:50px;">Descripción</td>
                <td class="text-center texto-bold" style="width:50px;">Status</td>
            </tr>
            <tr>
                <td class="text-center texto-bold texto-white" style="width:50px;">asd</td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
            </tr>
            <tr>
                <td class="text-center texto-bold texto-white" style="width:50px;">asd</td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
            </tr>
            <tr>
                <td class="text-center texto-bold texto-white" style="width:50px;">asd</td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
                <td class="text-center texto-bold" style="width:50px;"></td>
            </tr>

        </tbody>
    </table>

    <h3 class="texto-bold texto-subrayado">7. RECOMENDACIONES PARA ELIMINACIÓN DE CAUSA RAÍCES</h3>
    <p class="text-justify">
        (Documente las recomendaciones para eliminar la recurrencia del evento de falla)
    </p>


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
                <td class="text-center" style="width: 50px;">Importante(Fuga entre 10 a 100 Bls) </td>
                <td class="text-center" style="width: 50px;">Entre 7% y 10% Prod. Diaria</td>
                <td class="text-center" style="width: 50px;">Nacional con afectaciones</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Media</td>
                <td class="text-center" style="width: 50px;">Media</td>
                <td class="text-center" style="width: 50px;">Alta</td>
                <td class="text-center" style="width: 50px;">Alta</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;">3</td>
                <td class="text-center" style="width: 50px;">Incapacidad Temporal</td>
                <td class="text-center" style="width: 50px;">Entre 10.001 a 25.000 USD</td>
                <td class="text-center" style="width: 50px;">Localizada (Fuga entre 1 a 10 Bls)</td>
                <td class="text-center" style="width: 50px;">Entre 3% y 7% Prod. Diaria</td>
                <td class="text-center" style="width: 50px;">Nacional sin afectaciones</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Media</td>
                <td class="text-center" style="width: 50px;">Alta</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;">4</td>
                <td class="text-center" style="width: 50px;">Lesión Menor (Sin Incapacidad)</td>
                <td class="text-center" style="width: 50px;">Entre 2001 a 10.000 USD</td>
                <td class="text-center" style="width: 50px;">Menor (Fuga Entre 0,1 a 1 Bls)</td>
                <td class="text-center" style="width: 50px;">Entre 1% y 3% Prod. Diaria</td>
                <td class="text-center" style="width: 50px;">Nacional y baja importancia</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Media</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;">5</td>
                <td class="text-center" style="width: 50px;">Lesión Leve</td>
                <td class="text-center" style="width: 50px;">Menor a 2000 USD</td>
                <td class="text-center" style="width: 50px;">Leve (Fuga Menor 0,1 Bls)</td>
                <td class="text-center" style="width: 50px;">Menor a 1% Prod. Diaria</td>
                <td class="text-center" style="width: 50px;">Local o baja importancia</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Baja</td>
                <td class="text-center" style="width: 50px;">Baja</td>
            </tr>
            <tr>
                <td class="text-center" style="width: 10px;">6</td>
                <td class="text-center" style="width: 50px;">Ninguna</td>
                <td class="text-center" style="width: 50px;">Ninguna</td>
                <td class="text-center" style="width: 50px;">Ninguna</td>
                <td class="text-center" style="width: 50px;">Ninguna</td>
                <td class="text-center" style="width: 50px;">Ninguna</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
                <td class="text-center" style="width: 50px;">Nula</td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td class="text-center" style="width: 50px;">A</td>
                <td class="text-center" style="width: 50px;">B</td>
                <td class="text-center" style="width: 50px;">C</td>
                <td class="text-center" style="width: 50px;">D</td>
                <td class="text-center" style="width: 50px;">E</td>
            </tr>
        </tbody>
    </table>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br><br><br>
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
                    Página 5 de 5
                </th>
            </tr>
            <tr>
                <th class="text-center">REPORTE DE FALLA</th>
            </tr>
        </tbody>
    </table>

    <h4 class="texto-bold"> Acciones Correctivas</h4>
    <table class="table">
        <tbody>
            <tr>
                <td style="width:50px;" class="text-center texto-bold">Prioridad</td>
                <td style="width:50px;" class="text-center texto-bold">Causa Raíz</td>
                <td style="width:100px;" class="text-center texto-bold">Recomendación</td>
                <td style="width:50px;" class="text-center texto-bold">Responsable</td>
                <td style="width:50px;" class="text-center texto-bold">Empresa</td>
                <td style="width:50px;" class="text-center texto-bold">Fecha</td>
            </tr>
            <tr>
                <td style="width:50px;"></td>
                <td style="width:50px;"></td>
                <td style="width:100px;"></td>
                <td style="width:50px;"></td>
                <td style="width:50px;"></td>
                <td style="width:50px;" class="texto-white">s</td>
            </tr>
        </tbody>
    </table>
    <h4 class="texto-bold"> Acciones de Mejora</h4>
    <table class="table">
        <tbody>
            <tr>
                <td style="width:50px;" class="text-center texto-bold">Prioridad</td>
                <td style="width:50px;" class="text-center texto-bold">Causa Raíz</td>
                <td style="width:100px;" class="text-center texto-bold">Recomendación</td>
                <td style="width:50px;" class="text-center texto-bold">Responsable</td>
                <td style="width:50px;" class="text-center texto-bold">Empresa</td>
                <td style="width:50px;" class="text-center texto-bold">Fecha</td>
            </tr>
            <tr>
                <td style="width:50px;"></td>
                <td style="width:50px;"></td>
                <td style="width:100px;"></td>
                <td style="width:50px;"></td>
                <td style="width:50px;"></td>
                <td style="width:50px;" class="texto-white">s</td>
            </tr>
        </tbody>
    </table>

    </body>

</html>