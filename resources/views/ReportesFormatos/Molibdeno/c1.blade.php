<!DOCTYPE html>
<html>

<head>
    <title>Reporte Molibdeno</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 3px 5px;
            text-align: left;
            font-size: 11px;
            line-height: 1.2;
            vertical-align: middle;
        }

        th {
            background-color: #f4f4f4;
        }

        .header-table td {
            padding: 6px;
            border: none;
        }

        .data-row th,
        .data-row td {
            padding: 2px 5px;
            line-height: 1.1;
        }

        .w-5 { width: 5%; }
        .w-10 { width: 10%; }
        .w-15 { width: 15%; }
        .w-20 { width: 20%; }
        .w-30 { width: 30%; }
        .w-40 { width: 40%; }
        .w-50 { width: 50%; }
        .w-60 { width: 60%; }
        .w-100 { width: 100%; }

        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .font-size-24 { font-size: 24px; }

        .no-border { border: none; }
        .no-margin-padding { margin: 0; padding: 0; }
        .no-margin-left { margin-left: 0; padding-left: 0; }
        .no-margin-right { margin-right: 0; padding-right: 0; }

        .question-text {
            color: #222;
            font-weight: bold;
            font-size: 12px;
        }

        .question-header-ok {
            background-color: #e8f5e9;
        }

        .question-header-fail {
            background-color: #ffebee;
        }

        .question-status-ok {
            color: #1b5e20;
            font-weight: bold;
            font-size: 11px;
        }

        .question-status-fail {
            color: #b71c1c;
            font-weight: bold;
            font-size: 11px;
        }

        .option-correct {
            background-color: #d9d9d9;
        }

        .option-wrong-selected {
            background-color: #ffcdd2;
        }

        .question-block {
            page-break-inside: avoid;
            break-inside: avoid;
            margin-bottom: 6px;
        }

        .question-block table {
            margin-bottom: 0;
        }

        .question-number {
            width: 35px;
            text-align: center;
            font-weight: bold;
            vertical-align: top;
        }

        .option-label {
            width: 28px;
            text-align: center;
            font-weight: bold;
        }

        .scenario-cell {
            width: 30%;
            padding: 0;
            margin: 0;
            vertical-align: top;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 100% 100%;
        }
    </style>
</head>

<body>
    @php
        $isQuiz = !empty($data['is_quiz']);
        $quizQuestions = $data['quiz_questions'] ?? [];
        $json = $data['json'] ?? [];
        function molibdenoFormatNote($value)
        {
            if ($value === null || $value === '' || $value === '-') {
                return $value ?? '-';
            }

            if (!is_numeric($value)) {
                return $value;
            }

            return (int) round((float) $value);
        }

        $note = $data['note'] ?? 0;
        $noteReference = $data['note_reference'] ?? 0;
        $noteFormatted = molibdenoFormatNote($note);
        $noteReferenceFormatted = molibdenoFormatNote($noteReference);
        $quizPct = $noteReference > 0 ? round((float) $note / (float) $noteReference * 100) : 0;
        $aprobado = $quizPct >= 80;

        $startDate = $detail->start_date ?? ($json['startDate'] ?? null);
        $endDate = $detail->end_date ?? ($json['endDate'] ?? null);
        $duration = '-';

        if ($startDate && $endDate) {
            try {
                $duration = \Carbon\Carbon::parse($startDate)->diff(\Carbon\Carbon::parse($endDate))->format('%H:%I:%S');
            } catch (\Exception $e) {
                $duration = '-';
            }
        }

        function molibdenoSecondsToTime($seconds)
        {
            $seconds = str_replace(',', '.', $seconds);

            if (!is_numeric($seconds)) {
                return '00:00:00';
            }

            $seconds = floatval($seconds);
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            $secs = $seconds % 60;

            return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
        }

        $evalTime = $isQuiz
            ? $duration
            : (isset($json['time']) ? molibdenoSecondsToTime($json['time']) : '00:00:00');

        function molibdenoQuizIsCorrect($value): bool
        {
            if (is_bool($value)) {
                return $value;
            }

            if (is_numeric($value)) {
                return (int) $value === 1;
            }

            if (is_string($value)) {
                return in_array(strtolower(trim($value)), ['1', 'true', 'yes', 'si', 'sí'], true);
            }

            return false;
        }

        $totalPasos = $isQuiz ? count($quizQuestions) : ($noteReference ?: '-');
        $pasosRealizados = $isQuiz
            ? collect($quizQuestions)->filter(fn ($q) => molibdenoQuizIsCorrect($q['is_correct'] ?? false))->count()
            : null;
        $scenarioRowspan = $isQuiz ? 7 : 5;
        $scenarioImg = $scenario_image ?? $sinPhoto;
    @endphp

    <table class="header-table w-100">
        <tbody>
            <tr>
                <td class="w-20 text-left">
                    <img src="{{ $logo }}" alt="Logo" style="width: 100px; height: auto;">
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
                <td colspan="3">
                    {{ $header['taller'] ?? '-' }}
                </td>
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
            <tr>
                <th class="font-bold w-20">Intento:</th>
                <td>{{ $intento ?? '-' }}</td>
                <th class="font-bold w-20">Modo:</th>
                <td>{{ $modo ?? '-' }}</td>
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
            <tr class="data-row">
                <th class="font-bold w-20">Nombres y Apellido:</th>
                <td class="w-30">{{ $data['worker']['nombres'] ?? 'N/A' }}</td>
                <td class="w-30 scenario-cell" rowspan="{{ $scenarioRowspan }}" style="background-image: url('{{ $scenarioImg }}');">&nbsp;</td>
            </tr>
            <tr class="data-row">
                <th class="font-bold w-20">DNI:</th>
                <td class="w-30">{{ $data['worker']['doi'] ?? 'N/A' }}</td>
            </tr>
            @if ($isQuiz)
                <tr class="data-row">
                    <th class="font-bold w-20">Total Preguntas:</th>
                    <td class="w-30">{{ $totalPasos }}</td>
                </tr>
                <tr class="data-row">
                    <th class="font-bold w-20">Correctas:</th>
                    <td class="w-30">{{ $pasosRealizados }}</td>
                </tr>
            @endif
            <tr class="data-row">
                <th class="font-bold w-20">Hora Inicio:</th>
                <td class="w-30">{{ $startDate ?? 'N/A' }}</td>
            </tr>
            <tr class="data-row">
                <th class="font-bold w-20">Hora Final:</th>
                <td class="w-30">{{ $endDate ?? 'N/A' }}</td>
            </tr>
            <tr class="data-row">
                <th class="font-bold w-20">Tiempo de Evaluación:</th>
                <td class="w-30">{{ $evalTime }}</td>
            </tr>
        </tbody>
    </table>

    <table class="w-100">
        <tbody>
            @if ($isQuiz)
                <tr>
                    <th class="font-bold w-15">Puntaje obtenido:</th>
                    <td class="w-30">{{ $noteFormatted }}</td>
                    <td class="w-15" rowspan="3" style="text-align: center; font-size: 1.4em; vertical-align: middle;">
                        {{ $noteFormatted }}/{{ $noteReferenceFormatted }}
                    </td>
                </tr>
                <tr>
                    <th class="font-bold w-15">Puntaje máximo:</th>
                    <td class="w-30">{{ $noteReferenceFormatted }}</td>
                </tr>
                <tr>
                    <th class="font-bold w-15">Final:</th>
                    <td class="w-30">{{ $aprobado ? 'Aprobado' : 'Desaprobado' }}</td>
                </tr>
            @else
                <tr>
                    <th class="font-bold w-15">Puntaje Inicial:</th>
                    <td class="w-30">{{ molibdenoFormatNote($json['result']['initialScore'] ?? '-') }}</td>
                    <td class="w-15" rowspan="3" style="text-align: center; font-size: 1.4em; vertical-align: middle;">
                        {{ molibdenoFormatNote($json['result']['finalScore'] ?? '-') }}
                    </td>
                </tr>
                <tr>
                    <th class="font-bold w-15">Descuento:</th>
                    <td class="w-30">{{ molibdenoFormatNote($json['result']['discountScore'] ?? '-') }}</td>
                </tr>
                <tr>
                    <th class="font-bold w-15">Final:</th>
                    <td class="w-30">
                        @if (($json['result']['finalScore'] ?? 0) >= 80)
                            Aprobado
                        @else
                            No Aprobado
                        @endif
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    @if ($isQuiz && count($quizQuestions) > 0)
        <table class="w-100">
            <thead>
                <tr>
                    <th colspan="3" class="text-center">DETALLE DE PREGUNTAS</th>
                </tr>
            </thead>
        </table>

        @foreach ($quizQuestions as $index => $question)
            @php
                $correctKey = strtoupper(trim($question['alternative_ok'] ?? ''));
                $answeredCorrectly = molibdenoQuizIsCorrect($question['is_correct'] ?? false);
                $selectedKey = strtoupper(trim($question['selected'] ?? $question['answer'] ?? $question['alternative_selected'] ?? ''));
                $alternatives = [
                    'A' => $question['alternative_a'] ?? '',
                    'B' => $question['alternative_b'] ?? '',
                    'C' => $question['alternative_c'] ?? '',
                    'D' => $question['alternative_d'] ?? '',
                ];
            @endphp
            <div class="question-block">
                <table class="w-100">
                    <tr class="{{ $answeredCorrectly ? 'question-header-ok' : 'question-header-fail' }}">
                        <td class="question-number">{{ $index + 1 }}</td>
                        <td colspan="2">
                            <span class="question-text">{{ $question['statement'] ?? 'N/A' }}</span>
                            <br>
                            @if ($answeredCorrectly)
                                <span class="question-status-ok">ACERTÓ — seleccionó la alternativa correcta ({{ $correctKey }})</span>
                            @else
                                <span class="question-status-fail">
                                    FALLÓ —
                                    @if ($selectedKey && $selectedKey !== $correctKey)
                                        marcó {{ $selectedKey }}, la correcta era {{ $correctKey ?: '-' }}
                                    @else
                                        la respuesta correcta era {{ $correctKey ?: '-' }}
                                    @endif
                                </span>
                            @endif
                        </td>
                    </tr>
                    @foreach ($alternatives as $key => $text)
                        @php
                            $isCorrectOption = $correctKey === $key;
                            $isWrongSelection = !$answeredCorrectly && $selectedKey === $key && !$isCorrectOption;
                            $cellClass = $isCorrectOption ? 'option-correct' : ($isWrongSelection ? 'option-wrong-selected' : '');
                        @endphp
                        <tr>
                            <td class="option-label {{ $cellClass }}">{{ $key }}</td>
                            <td class="{{ $cellClass }}">{{ $text }}</td>
                            <td style="width: 110px; text-align: center; font-size: 10px;" class="{{ $cellClass }}">
                                @if ($isCorrectOption)
                                    Respuesta correcta
                                @elseif ($isWrongSelection)
                                    Marcó esta
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    @elseif ($json)
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
                            @foreach ($json['tables']['exercise'] ?? [] as $item)
                                <tr>
                                    <th>{{ $item['name'] ?? 'N/A' }}</th>
                                    <td>{{ $item['description'] ?? 'N/A' }}</td>
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
                            @foreach ($json['tables']['vehicleData'] ?? [] as $item)
                                <tr>
                                    <th>{{ $item['name'] ?? 'N/A' }}</th>
                                    <td>{{ $item['description'] ?? 'N/A' }}</td>
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
                            @foreach ($json['tables']['summary'] ?? [] as $item)
                                <tr>
                                    <th>{{ $item['name'] ?? 'N/A' }}</th>
                                    <td>{{ $item['time'] ?? 'N/A' }}</td>
                                    <td>{{ $item['quantity'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td class="no-border no-margin-right" style="width: 50%; vertical-align: top;">
                    <table class="w-100">
                        <tbody>
                            @foreach ($json['tables']['extras'] ?? [] as $item)
                                <tr>
                                    <th>{{ $item['name'] ?? 'N/A' }}</th>
                                    <td>{{ $item['description'] ?? 'N/A' }}</td>
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
                @foreach ($json['tables']['infractions'] ?? [] as $item)
                    <tr>
                        <th>{{ $item['name'] ?? 'N/A' }}</th>
                        <td>{{ molibdenoFormatNote($item['score'] ?? 'N/A') }}</td>
                        <td>{{ $item['repetition'] ?? 'N/A' }}</td>
                        <td>{{ molibdenoFormatNote($item['total'] ?? 'N/A') }}</td>
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
                @foreach ($json['details'] ?? [] as $item)
                    <tr>
                        <th>{{ $item['action'] ?? 'N/A' }}</th>
                        <td>{{ $item['currentTime'] ?? 'N/A' }}</td>
                        <td>{{ $item['eventType'] ?? 'N/A' }}</td>
                        <td>{{ $item['description'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif (!$isQuiz)
        <p>No se encontró data</p>
    @endif
</body>

</html>
