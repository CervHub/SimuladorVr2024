<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
    initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        body {
            margin: 0;
            /* Márgenes
    en milímetros */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid black;
        }

        .col-1 {
            width: 8.33%;
        }

        .col-2 {
            width: 16.66%;
        }

        .col-3 {
            width: 25%;
        }

        .col-4 {
            width:
                33.33%;
        }

        .col-5 {
            width: 41.66%;
        }

        .col-6 {
            width: 50%;
        }

        .col-7 {
            width: 58.33%;
        }

        .col-8 {
            width: 66.66%;
        }

        .col-9 {
            width: 75%;
        }

        .col-10 {
            width: 83.33%;
        }

        .col-11 {
            width: 91.66%;
        }

        .col-12 {
            width: 100%;
        }

        .logo-container {
            position: relative;
            /* Asegura que las propiedades de posición funcionen */
            z-index: 9999;
            /*
    Coloca el div encima de todo */
            width: 60px;
            /* Ancho del contenedor */
            height: 50px;
            /* Altura del contenedor */
            padding-left: 5px;
            /* Espaciado a la izquierda */
        }

        #usuario {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .col-6 {
            width: 45%;
        }

        .align-left {
            text-align: left;
        }

        .align-top {
            text-align: top;
        }

        .border-0 {
            border: 0;
            border-color: red;
        }

        .text-white {
            color: white;
        }

        .title {
            padding-bottom: 30px;
        }

        .fs-20 {
            font-size: 20px;
        }

        .fs-10 {
            font-size: 10px;
        }

        .fs-12 {
            font-size: 12px;
        }

        .fs-14 {
            font-size: 14px;
        }

        .fs-13 {
            font-size: 13px;
        }

        .fs-15 {
            font-size: 15px;
        }

        .fs-18 {
            font-size: 18px;
        }

        .fs-20 {
            font-size: 20px;
        }

        .fs-30 {
            font-size: 30px;
        }

        .border-0 {
            border: 0;
        }

        .align-left {
            text-align: left;
        }

        .align-top {
            vertical-align: top;
        }

        .title {
            font-weight: bold;
        }

        .line-height-1 {
            line-height: 0.1;
        }

        .line-height-3 {
            line-height: 0.3;
        }

        .line-height-5 {
            line-height: 0.5;
        }

        .line-height-8 {
            line-height: 0.8;
        }

        .line-height-10 {
            line-height: 1;
        }

        .line-height-12 {
            line-height: 1.2;
        }

        .dl-container {
            display: table;
            width: 100%;
        }

        .dl-row {
            display: table-row;
        }

        .dl-term,
        .dl-definition {
            display: table-cell;
        }

        .text-light {
            font-weight: lighter;
        }

        .dl-term {
            width: 150px;
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

        .white-border td,
        .white-border th,
        .white-border tr {
            border-color: red;
        }

        dl {
            margin:
                0;
            padding: 0;
        }

        .mt-3 {
            padding-top: 15px;
        }

        .mb-3 {
            padding-bottom: 15px;
        }

        .mt-2 {
            padding-top: 10px;
        }

        .mb-2 {
            padding-bottom: 10px;
        }

        .bg-light {
            background-color: whitesmoke;
        }

        hr {
            border: 0.1px solid black;
            margin-left:
                5px;
            margin-right: 5px;
        }

        .dl-definition,
        .dl-term-secondary,
        .dl-term {
            padding-top: 3px;
        }

        .dl-term-secondary {
            font-weight: bold;
        }

        .banner {
            background-color: blue;
            width: 100%;
            height: 20px;
            position: absolute;
            left: 10%;
            border-radius: 10px 0px 0px 10px;
            /* Agrega una sombra negra */
        }

        .custom-table {
            border-collapse: collapse;
            margin:
                auto;
            text-align: left;
            /* Añadido para redondear los bordes */
            overflow: hidden;
            /* Añadido para asegurarse de que
    el borde redondeado se vea bien */
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid black;
            padding: 8px;
        }

        .text-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <table class="no-border">
        <tr style="padding:0; margin:0;">
            <td style="width: 120px; padding:0;">
                <div class="">
                    <img src="{{ $logo }}" width="120px" alt="Logo">
                </div>
            </td>
            <td style="padding-right:0;">
                <p class="" style="text-align: left; font-size:18px; font-weight: bold; padding-left:140px;">
                    Reporte de
                    evaluación </p>
            </td>
        </tr>
    </table>

    <hr>
    <section id="usuario">
        <table class="no-border">
            <tr class=" col-12">
                <td class="col-6 align-left align-top">
                    <dl class="dl-container ">
                        <div class="dl-row">
                            <dt class="dl-term title fs-15" style="padding:0; padding-bottom:15px;">Datos del
                                usuario</dt>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Documento de Identidad:</dt>
                            <dd class="dl-definition">{{ $worker->user->doi }}</dd>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Nombre:</dt>
                            <dd class="dl-definition">{{ $worker->nombre }}</dd>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Apellidos:</dt>
                            <dd class="dl-definition">{{ $worker->apellido }}</dd>
                        </div>
                        {{-- <div class="dl-row">
                            <dt class="dl-term-secondary">Fecha:</dt>
                            <dd class="dl-definition">{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</dd>
                        </div> --}}
                    </dl>
                </td>
                <td class="col-4">
                    <div>
                        <div style="padding-left: 60px;">
                            <dl class="dl-container bg-light mt-2 mb-2" style="border-radius: 25px; width: 120px;">
                                <div class="dl-row">
                                    @php $notaPonderada=$nota; @endphp <dt class="dl-term fs-20 line-height-12"
                                        style="font-weight:
                    bold;">
                                        {{ number_format($notaPonderada, 0) }}/{{ $induction_worker->puntaje }}</dt>
                                </div>
                                <div class="dl-row">
                                    <dt class="dl-term fs-20 line-height-12" style="font-weight: bold;">
                                        @if ($notaPonderada > 75)
                                            Aprobado
                                        @else
                                            Desaprobado
                                        @endif
                                    </dt>
                                </div>

                            </dl>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </section>
    <br>
    <hr>
    <section id="evaluacion">
        <table class="no-border">
            <tr class="col-12">
                <td class="col-7 align-left align-top">
                    <dl class="dl-container">
                        <div class="dl-row">
                            <dt class="dl-term title fs-15" style="padding:0; padding-bottom: 10px;">Datos de
                                evaluación</dt>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Taller:</dt>

                            <dd class="dl-definition">{{ strtoupper($induction->alias) }}</dd>
                        </div>
                        @php
                            $fechaInicio = new DateTime($data->start_date);
                            $fechaFin = new DateTime($data->end_date);
                            $diferencia = $fechaInicio->diff($fechaFin);

                            $duracionEnHoras = $diferencia->format('%H:%I:%S');
                        @endphp

                        <div class="dl-row">
                            <dt class="dl-term-secondary">Fecha inicio:</dt>
                            <dd class="dl-definition">{{ $data->start_date }}</dd>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Fecha fin:</dt>
                            <dd class="dl-definition">{{ $data->end_date }}</dd>
                        </div>
                        <div class="dl-row">
                            <dt class="dl-term-secondary">Duración:</dt>
                            <dd class="dl-definition">{{ $duracionEnHoras }} </dd>
                        </div>
                    </dl>
                </td>
                <td class="col-5 align-left align-top" style="text-align: right;">
                    <dl class="dl-container">
                        <div class="dl-row">
                            <img style="border-radius: 25px;"
                                src="{{$logo_taller}}"
                                width="300px" alt="">
                        </div>
                    </dl>
                </td>
            </tr>
        </table>

    </section>
    <hr>
    <section id="detalles" style="padding-left: 5px;padding-right: 5px;">
        <p class="fs-15 title" style="padding:0;">Detalles de evaluación</p>
        <table class="custom-table">
            <tr>
                <th>Descripción</th>
                <th>Nº Errores</th>
                <th>Puntaje</th>
                {{-- <th>Medida correcta</th>
                <th>Tiempo</th>  --}}
            </tr>
            @php
                $sumatoria = 0;
            @endphp

            @foreach ($detail_induction_worker as $key => $data)
                @php
                    $multiplicador = $data->case == 'EPPs' ? 1 : 5;
                    $resultado = round($data->num_errors, 0) * $multiplicador;
                    $sumatoria += $resultado;
                @endphp
                <tr style="height: 20px;">
                    <td style="text-align: left;">{{ $key + 1 }}. {{ $data->case }}</td>
                    <td>{{ round($data->num_errors, 0) }}</td>
                    <td>{{ $resultado }}</td>
                </tr>
            @endforeach

            <tr>
                <th></th>
                <th>TOTAL</th>
                <th>{{ $sumatoria }}</th>
                {{-- <th>{{ $detail_induction_worker->sum('correct_measure') }}</th>
                <th>-</th> --}}
            </tr>
        </table>
        <br>
        <table class="no-border">
            <tr>
                <td style="vertical-align: top; width: 300px; border: none;">
                    <img src="{{ $imagen }}" width="300px" alt="">
                </td>
                <td>
                    @php
                        $total_errores = $sumatoria;
                    @endphp
                    <table style="border-collapse: collapse; border: 1px solid black;">
                        <tr style="border-collapse: collapse; border: 1px solid black;">
                            <td style="border-collapse: collapse; border: 1px solid black;" class="text-bold">Puntaje de
                                Errores:
                            </td>
                            <td style="border-collapse: collapse; border: 1px solid black;">
                                {{ $total_errores }}</td>
                        </tr>
                        <tr style="border-collapse: collapse; border: 1px solid black;">
                            <td style="border-collapse: collapse; border: 1px solid black;" class="text-bold"> Puntaje
                                Inicial:
                            </td>
                            <td style="border-collapse: collapse; border: 1px solid black;">
                                {{ $induction_worker->puntaje }}</td>
                        </tr>
                        <tr style="border-collapse: collapse; border: 1px solid black;">
                            <td style="border-collapse: collapse; border: 1px solid black;" class="text-bold">Puntaje
                                Final:</td>
                            <td style="border-collapse: collapse; border: 1px solid black;">
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
        </table>


    </section>

</body>

</html>
