<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Reporte de Evaluación</title>
    <style>
        body {
            font-size: 0.75em;
            font-family: Calibri, Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #1a1a1a;
        }

        table,
        tr,
        td,
        th {
            border: 1px solid #333;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 6px 8px;
            vertical-align: middle;
        }

        .main__container {
            width: 100%;
            padding: 8px;
        }

        .title {
            text-align: center;
            margin: 0;
            font-size: 1.35em;
            letter-spacing: 0.5px;
        }

        .column__key {
            font-weight: 700;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .meta-date {
            font-size: 0.9em;
            color: #444;
        }

        .table-head {
            background-color: #c9c9c9;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.95em;
        }

        .table-head td {
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .row-alt {
            background-color: #f0f0f0;
        }

        .cell-muted {
            color: #555;
        }

        .footer-note {
            margin-top: 10px;
            font-size: 0.85em;
            color: #666;
            text-align: right;
        }
    </style>
</head>

<body>
    @php
        $logoSrc = $logo_taller ?? null;
        if (!$logoSrc && !empty($logo)) {
            $logoPath = public_path($logo);
            $logoSrc = file_exists($logoPath) ? $logoPath : null;
        }

        $formatValue = function ($value) {
            if ($value === null || $value === '' || $value === '-') {
                return '-';
            }
            return $value;
        };

        $formatDate = function ($value) use ($formatValue) {
            $value = $formatValue($value);
            if ($value === '-') {
                return '-';
            }
            try {
                return \Carbon\Carbon::parse($value)->format('d-m-Y H:i');
            } catch (\Exception $e) {
                return $value;
            }
        };
    @endphp

    <div class="main__container">
        <table style="width: 100%; margin-bottom: 0;">
            <tbody>
                <tr>
                    <td class="text-center" style="width: 18%; border-bottom: none;">
                        @if ($logoSrc)
                            <img src="{{ $logoSrc }}" width="110" alt="Logo" style="max-height: 60px;">
                        @endif
                    </td>
                    <td class="text-center" style="border-bottom: none;">
                        <h3 class="title">REPORTE DE EVALUACIÓN</h3>
                    </td>
                    <td class="text-center meta-date" style="width: 18%; border-bottom: none;">
                        {{ \Carbon\Carbon::now('America/Lima')->format('Y-m-d H:i:s') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; margin-bottom: 8px;">
            <tbody>
                <tr>
                    <td style="width: 18%;"><span class="column__key">Simulador:</span></td>
                    <td colspan="5">{{ $header['taller'] ?? ($induction->alias ?? '-') }}</td>
                </tr>
                <tr>
                    <td><span class="column__key">Instructor:</span></td>
                    <td colspan="2">{{ $header['instructor'] ?? '-' }}</td>
                    <td style="width: 12%;"><span class="column__key">DNI:</span></td>
                    <td colspan="2">{{ $header['instructor_doi'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><span class="column__key">Fecha de Inicio:</span></td>
                    <td colspan="2">{{ $formatDate($header['date_start'] ?? null) }}</td>
                    <td><span class="column__key">Fecha de Fin:</span></td>
                    <td colspan="2">{{ $formatDate($header['date_end'] ?? null) }}</td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%;">
            <tbody>
                <tr class="table-head">
                    <td class="text-center" style="width: 4%;">N°</td>
                    <td class="text-center" style="width: 10%;">DNI</td>
                    <td class="text-center" style="width: 8%;">Licencia</td>
                    <td class="text-center" style="width: 22%;">Nombres y Apellidos</td>
                    <td class="text-center" style="width: 6%;">Intento</td>
                    <td class="text-center" style="width: 16%;">F. Inicio</td>
                    <td class="text-center" style="width: 16%;">F. Fin</td>
                    <td class="text-center" style="width: 8%;">Nota</td>
                </tr>

                @php $counter = 1; @endphp
                @forelse ($newNoteJson as $item)
                    @php
                        $attempts = [];
                        foreach ($item['attempts'] as $i) {
                            if ($i['is_training'] == 0) {
                                $attempts[] = $i;
                            }
                        }
                        $attemptCount = count($attempts);
                        $rowClass = $counter % 2 === 0 ? 'row-alt' : '';
                    @endphp

                    @if ($attemptCount > 0)
                        @foreach ($attempts as $idx => $attempt)
                            <tr class="{{ $rowClass }}">
                                @if ($idx === 0)
                                    <td class="text-center" rowspan="{{ $attemptCount }}">{{ $counter }}</td>
                                    <td class="text-center" rowspan="{{ $attemptCount }}">{{ $formatValue($item['worker']['doi'] ?? null) }}</td>
                                    <td class="text-center" rowspan="{{ $attemptCount }}">{{ $formatValue($item['worker']['license'] ?? null) }}</td>
                                    <td class="text-left" rowspan="{{ $attemptCount }}">{{ $formatValue($item['worker']['nombres'] ?? null) }}</td>
                                @endif
                                <td class="text-center">{{ $formatValue($attempt['attempt'] ?? null) }}</td>
                                <td class="text-center cell-muted">{{ $formatDate($attempt['start_date'] ?? null) }}</td>
                                <td class="text-center cell-muted">{{ $formatDate($attempt['end_date'] ?? null) }}</td>
                                <td class="text-center">{{ $formatValue($attempt['note'] ?? null) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="{{ $rowClass }}">
                            <td class="text-center">{{ $counter }}</td>
                            <td class="text-center">{{ $formatValue($item['worker']['doi'] ?? null) }}</td>
                            <td class="text-center">{{ $formatValue($item['worker']['license'] ?? null) }}</td>
                            <td class="text-left">{{ $formatValue($item['worker']['nombres'] ?? null) }}</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                        </tr>
                    @endif

                    @php $counter++; @endphp
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay datos disponibles</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-note">
            Documento generado por Simulador VR · CERV
        </div>
    </div>
</body>

</html>
