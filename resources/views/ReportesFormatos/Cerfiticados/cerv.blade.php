<!DOCTYPE html>
<html>

<head>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            color: #333;
            font-family: 'Roboto', sans-serif;
            /* Tipo de letra moderna */
            /* Texto en color gris oscuro */
        }

        body {
            background: url('{{ $photo }}') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            display: table;
            /* Cambiado a table para centrar verticalmente */
            width: 100%;
            text-align: center;
            /* Centrar todo el texto */
        }

        h1,
        h2,
        h3,
        h4 {
            color: #000;
            margin: 0;
            /* Encabezados en color negro */
        }

        .signatures {
            width: 100%;
        }

        .signature {
            width: 25%;
            /* Ajusta este valor según sea necesario */
            /* Hace que las firmas floten a la izquierda, alineándolas en una fila */
            text-align: center;
        }

        .certificado {
            margin-top: 220px;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .lowercase {
            text-transform: lowercase;
        }

        .sentence {
            text-transform: capitalize;
        }

        .bold {
            color: #333333;
            /* Un gris oscuro */
            font-weight: bold;
        }

        .bold_sub {
            color: #000000;
            /* Un gris más claro */
            font-weight: 400;
            /* Semi-negrita */
        }

        .signature p {
            line-height: 1.2;
            margin: 0.5em;
            /* Ajusta este valor según sea necesario */
        }

        .curso {
            color: #083983;
            width: 55%;
            margin: auto;
            font-size: 1.8em;
        }

        .center {
            text-align: center;
        }

        h3 span {
            font-size: 2.5em;
            color: #000000;
            /* Ajusta este valor según sea necesario */
            display: inline-block;
            border-bottom: 4px solid #000000 !important;
            min-width: 500px;
        }

        .mt-2 {
            margin-top: 2em;
        }

        .mt-1 {
            margin-top: 1em;
        }

        .mt-05 {
            margin-top: 0.5em;
        }

        .m-0 {
            margin: 0;
        }

        .mt-3 {
            margin-top: 3em;
        }

        .mt-4 {
            margin-top: 4em;
        }
    </style>
</head>

<body>
    <div class="certificado">
        <h3 class="uppercase bold_sub">Otorga la presente</h3>
        <h1 class="uppercase bold mt-05">Constancia</h1>
        <h3 class="mt-2" style="color: #000000">A: <span>{{ $worker['nombres'] }}</span></h3>
        <p class="bold_sub mt-2">Por haber terminado satisfactoriamente el curso:</p>
        <h2 class="uppercase curso mt-05">{{ $taller }}</h2>
        <p class="mt-2">Como parte de su desarrollo en la Plataforma de Capacitación en Seguridad y Salud.</p>
        <p class="mt-2" style="margin-bottom: 0">{{ $fecha }}</p>

        <div>
            <img src="{{ $firma }}" alt="" style="max-height: 120px;">
        </div>
    </div>
    <img src="{{ $qr }}" alt=""
        style="width: 50px; height: 50px; position: absolute; bottom: 25px; left: 25px;">
</body>

</html>
