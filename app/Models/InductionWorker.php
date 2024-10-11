<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InductionWorker extends Model
{
    use HasFactory;
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'id_worker');
    }

    public function induction()
    {
        return $this->belongsTo(Induction::class, 'id_induction');
    }

    public function detail()
    {
        return $this->hasMany(DetailInductionWorker::class, 'induction_worker_id');
    }


    //ISEM NOTAS

    public function notaIsemByIntento($intento)
    {
        $details = $this->detailsByReport($intento)->get();

        if ($details->isEmpty()) {
            return [
                'note_reference' => null,
                'identified_sum' => 0,
                'risk_level_sum' => 0,
                'correct_measure_sum' => 0,
                'total_sum' => '-',
                'porcentaje' => 0,
                'categoria' => 'Desconocido',
                'num_report' => $this->num_report,
            ];
        }

        $noteReference = null;
        $identifiedSum = 0;
        $riskLevelSum = 0;
        $correctMeasureSum = 0;

        foreach ($details as $detail) {
            if ($noteReference === null) {
                $noteReference = $detail->note_reference;
            }

            $identifiedSum += $detail->identified;
            $riskLevelSum += $detail->risk_level;
            $correctMeasureSum += $detail->correct_measure;
        }

        $totalSum = $identifiedSum + $riskLevelSum + $correctMeasureSum;

        if ($noteReference != 0) {
            $totalSum = ($totalSum / $noteReference) * 20;
        } else {
            $totalSum = 0;
        }

        $porcentaje = 0;
        $categoria = 'Desconocido';

        if ($totalSum >= 2 && $totalSum <= 6) {
            $porcentaje = 25;
            $categoria = 'Seguimiento';
        } elseif ($totalSum > 6 && $totalSum <= 11) {
            $porcentaje = 59;
            $categoria = 'En Proceso';
        } elseif ($totalSum > 11 && $totalSum <= 16) {
            $porcentaje = 75;
            $categoria = 'Competente';
        } elseif ($totalSum > 16 && $totalSum <= 20) {
            $porcentaje = 100;
            $categoria = 'Muy Competente';
        }

        return [
            'note_reference' => $noteReference,
            'identified_sum' => $identifiedSum,
            'risk_level_sum' => $riskLevelSum,
            'correct_measure_sum' => $correctMeasureSum,
            'total_sum' => round($totalSum),
            'porcentaje' => $porcentaje,
            'categoria' => $categoria,
            'num_report' => $this->num_report,
        ];
    }

    public function notaIsemByAllIntentos()
    {
        $results = [];

        for ($intento = 1; $intento <= $this->num_report; $intento++) {
            $results[$intento] = $this->notaIsemByIntento($intento);
        }

        $maxTotalSum = '-';
        $maxIntentoData = [
            'note_reference' => null,
            'identified_sum' => 0,
            'risk_level_sum' => 0,
            'correct_measure_sum' => 0,
            'total_sum' => '-',
            'porcentaje' => 0,
            'categoria' => 'Desconocido',
            'num_report' => $this->num_report,
        ];
        foreach ($results as $intento => $result) {
            if ($result['total_sum'] !== '-' && ($maxTotalSum === '-' || $result['total_sum'] > $maxTotalSum)) {
                $maxTotalSum = $result['total_sum'];
                $maxIntentoData = $result;
            }
        }

        return $maxIntentoData;
    }

    public function notaConfipetrol()
    {
        $detail = $this->detail()->first();
        return $detail ? intval($detail->note) : '-';
    }

    public function notaIsemDashboard()
    {
        $maxNota = -1; // Inicializar la nota máxima como -1
        for ($i = 1; $i <= $this->num_report; $i++) {
            $nota = $this->notaIsemByIntento($i)['total_sum'];
            if ($nota > $maxNota) {
                $maxNota = $nota; // Actualizar la nota máxima si la nota actual es mayor
            }
        }
        return $maxNota; // Devolver la nota máxima
    }

    public function notaConfipetrolIntento($intento)
    {
        $detail = $this->detailsByReportAndTraining($intento, 'evaluacion')->first();
        return $detail ? intval($detail->note) : '-';
    }
    public function notaConfipetrolMax($intento)
    {
        // Obtén la nota para el intento dado
        $nota = $this->notaConfipetrolIntento($intento);
        $maxNota = $nota != '-' ? $nota : '-';
        $intentoMaxNota = $nota != '-' ? $intento : '-';

        // Obtén los detalles para el intento dado
        $details = $nota != '-' ? $this->detailsByReportAndTraining($intento, 'evaluacion')->get() : collect();

        // Mapea los detalles
        $mappedDetails = $details->map(function ($detail) {
            return [
                'id' => $detail->id,
                'case' => $detail->case,
                'num_errors' => $detail->num_errors,
                'start_date' => $detail->start_date ?? null, // Agrega start_date solo si existe
            ];
        })->toArray(); // Convierte la colección en un array

        // Estructura los detalles en un formato específico
        $structuredDetails = [
            'EPPs' => 0,
            'Equipos de bloqueo' => 0,
            'Aislamiento' => 0,
            'Bloqueo y tarjeteo' => 0,
        ];
        foreach ($mappedDetails as $detail) {
            if (array_key_exists($detail['case'], $structuredDetails)) {
                $structuredDetails[$detail['case']] = $detail['num_errors'];
            }
        }

        // Agrega más información
        $name = $this->worker->nombre . ' ' . $this->worker->apellido;
        $empresa = $this->worker->service->name;
        $codigo = $this->worker->user->doi;
        $cargo = $this->worker->position;
        $id_service = $this->worker->service->id;
        $startDate = $mappedDetails[0]['start_date'] ?? null; // Obtiene start_date del primer detalle si existe

        // Retorna los detalles mapeados, la nota máxima, el intento y la información adicional
        return array_merge(['maxNota' => $maxNota, 'intento' => $intentoMaxNota, 'nombre' => $name, 'empresa' => $empresa, 'codigo' => $codigo, 'cargo' => $cargo, 'start_date' => $startDate, 'id_service' => $id_service], $structuredDetails);
    }
    public function notaConfipetrolAnalisis($intento)
    {
        // Obtén la nota para el intento dado
        $nota = $this->notaConfipetrolIntento($intento);
        $maxNota = $nota != '-' ? $nota : '-';
        $intentoMaxNota = $nota != '-' ? $intento : '-';
        $details = $nota != '-' ? $this->detailsByReportAndTraining($intento, 'evaluacion')->first() : collect();

        // Agrega más información
        $name = $this->worker->nombre . ' ' . $this->worker->apellido;
        $empresa = $this->worker->service->name;
        $codigo = $this->worker->user->doi;
        $cargo = $this->worker->position;
        $id_service = $this->worker->service->id;
        $start_date = isset($details->start_date) ? $details->start_date : null;
        // Retorna la nota máxima, el intento y la información adicional
        return ['maxNota' => $maxNota, 'intento' => $intentoMaxNota, 'nombre' => $name, 'empresa' => $empresa, 'codigo' => $codigo, 'cargo' => $cargo, 'id_service' => $id_service, 'start_date' => $start_date];
    }
    public function notaConfipetrolProcesos($intento)
    {
        // Obtén la nota para el intento dado
        $nota = $this->notaConfipetrolIntento($intento);
        $maxNota = $nota != '-' ? $nota : '-';
        $intentoMaxNota = $nota != '-' ? $intento : '-';

        // Obtén los detalles para el intento dado
        $details = $nota != '-' ? $this->detailsByReportAndTraining($intento, 'evaluacion')->get() : collect();

        // Mapea los detalles
        $mappedDetails = $details->map(function ($detail) {
            return [
                'id' => $detail->id,
                'case' => $detail->case,
                'num_errors' => $detail->num_errors,
                'start_date' => $detail->start_date ?? null, // Agrega start_date solo si existe
            ];
        })->toArray(); // Convierte la colección en un array

        // Estructura los detalles en un formato específico
        $structuredDetails = [
            'EPPs' => 0,
            'Equipos de bloqueo' => 0,
            'Aislamiento' => 0,
            'Bloqueo y tarjeteo' => 0,
            'Derrame de crudo' => 0,
            'Fuga de agua' => 0,
            'Deterioro de tuberías' => 0,
            'Desgaste de estructuras' => 0,
            'Personaje de caída' => 0,
            'Derrame de barriles' => 0,
            'Camión de grua' => 0,
            'Ingreso al tanque' => 0,
        ];

        foreach ($mappedDetails as $detail) {
            if (array_key_exists($detail['case'], $structuredDetails)) {
                $structuredDetails[$detail['case']] = $detail['num_errors'];
            }
        }

        foreach ($structuredDetails as $key => $value) {
            if ($key != 'EPPs') {
                $structuredDetails[$key] = $value * 5;
            }
        }

        // Agrega más información
        $name = $this->worker->nombre . ' ' . $this->worker->apellido;
        $empresa = $this->worker->service->name;
        $codigo = $this->worker->user->doi;
        $cargo = $this->worker->position;
        $id_service = $this->worker->service->id;
        $startDate = $mappedDetails[0]['start_date'] ?? null; // Obtiene start_date del primer detalle si existe

        // Retorna los detalles mapeados, la nota máxima, el intento y la información adicional
        return array_merge(['maxNota' => $maxNota, 'intento' => $intentoMaxNota, 'nombre' => $name, 'empresa' => $empresa, 'codigo' => $codigo, 'cargo' => $cargo, 'start_date' => $startDate, 'id_service' => $id_service], $structuredDetails);
    }

    public function detailsByReport($reportValue)
    {
        return $this->hasMany(DetailInductionWorker::class, 'induction_worker_id')
            ->where('report', $reportValue);
    }

    public function detailsByReportAndTraining($reportValue, $trainingValue)
    {
        if ($trainingValue == 'evaluacion' or $trainingValue == 'Evaluación') {
            return $this->hasMany(DetailInductionWorker::class, 'induction_worker_id')
                ->where('report', $reportValue)
                ->where('entrenamiento', '<>', 1);
        } else {
            return $this->hasMany(DetailInductionWorker::class, 'induction_worker_id')
                ->where('report', $reportValue)
                ->where('entrenamiento', 1);
        }
    }
    public function nota($tiempoObjetivo)
    {
        $numReport = $this->num_report;
        $detailsCount = [];

        for ($i = 1; $i <= $numReport; $i++) {
            // Pasar el tiempo objetivo como parámetro a notaLuzDelSurIntento
            $nota = $this->notaLuzDelSurIntento($i, "evaluacion", $tiempoObjetivo);

            // Ajustar a 0 si la nota es "-"
            $nota = ($nota == '-') ? 0 : intval($nota);

            $detailsCount[$i] = $nota;
        }

        // Obtener la nota máxima de los intentos y convertirla a string
        $maxNota = !empty($detailsCount) ? strval(max($detailsCount)) : "-";

        return $maxNota;
    }


    public function notaLuzDelSur()
    {
        $numReport = $this->num_report;
        $ponderado = $this->puntaje;
        $puntos = 10;
        $detailsCount = [];

        for ($i = 1; $i <= $numReport; $i++) {
            $count = $this->detailsByReportAndTraining($i, 'evaluacion')->count() * $puntos;
            $total = $this->detailsByReportAndTraining($i, 'evaluacion')->sum('identified') * $puntos;
            $detailsCount[$i] = $count != 0 ? $total * $ponderado / $count : 0;
        }

        return !empty($detailsCount) ? strval(intval(max($detailsCount))) : "-";
    }

    public function notaLuzDelSurIntento($i, $modo, $tiempoObjetivo)
    {
        // Obtener el número de reporte y el factor de ponderación
        $numReport = $this->num_report;
        $ponderado = $this->puntaje;

        // Definir los puntos asignados por cada detalle
        $puntosPorDetalle = 10;

        // Obtener la colección de detalles
        $details = $this->detailsByReportAndTraining($i, $modo)->get();

        // Verificar si la colección de detalles está vacía
        if ($details->isEmpty()) {
            return "-";
        }

        // Convertir tiempo objetivo a segundos
        $tiempoObjetivoSegundos = $tiempoObjetivo * 60;

        // Inicializar variables
        $totalPuntos = 0;
        $elementos = 0;
        $note = 0;

        // Iterar sobre los detalles
        foreach ($details as $detail) {
            // Calcular la diferencia de notas
            $note = $detail->note_reference - $detail->note;

            // Verificar si el tiempo del detalle cumple con el objetivo
            if ($detail->time <= $tiempoObjetivoSegundos) {
                $totalPuntos += $puntosPorDetalle;
            }

            // Incrementar el contador de elementos
            $elementos += 1;
        }

        // Calcular el puntaje total y ajustarlo según la diferencia de notas
        $puntajeTotal = ($totalPuntos * $ponderado) / ($elementos * $puntosPorDetalle);
        $puntajeFinal = intval($puntajeTotal - $note);

        return strval($puntajeFinal);
    }

    public function getPonderadoAttribute()
    {
        $nota = 0;

        // Verificar si hay al menos un registro en la relación 'detail'
        if ($this->detail->count() > 0) {
            // Obtener el primer registro de 'detail'
            $primerDetalle = $this->detail->first();

            // Calcular el valor ponderado
            $nota = ($primerDetalle->note_reference != 0) ? (number_format($primerDetalle->note, 0) / $primerDetalle->note_reference) * 20 : 0;
        }

        return number_format($nota, 0);
    }


    public function getPorcentajeAttribute()
    {
        $nota = $this->getPonderadoAttribute();
        if ($nota >= 2 && $nota <= 6) {
            $porcentaje = 25;
        } elseif ($nota >= 7 && $nota <= 11) {
            $porcentaje = 59;
        } elseif ($nota >= 12 && $nota <= 16) {
            $porcentaje = 75;
        } elseif ($nota >= 17 && $nota <= 20) {
            $porcentaje = 100;
        } else {
            $porcentaje = 0; // Otra categoría o porcentaje por defecto si no coincide con ninguna condición
        }
        return $porcentaje;
    }

    public function getCategoriaAttribute()
    {
        $nota = $this->getPonderadoAttribute();
        if ($nota >= 2 && $nota <= 6) {
            $categoria = 'Seguimiento';
        } elseif ($nota >= 7 && $nota <= 11) {
            $categoria = 'En Proceso';
        } elseif ($nota >= 12 && $nota <= 16) {
            $categoria = 'Competente';
        } elseif ($nota >= 17 && $nota <= 20) {
            $categoria = 'Muy Competente';
        } else {
            $categoria = 'Desconocido';
        }
        return $categoria;
    }


    // Nueva función para obtener la nota de un trabajador en un reporte específico

    public function jsonNote()
    {
        $details = $this->detail()->get();
        $notes = [];

        foreach ($details as $detail) {
            $json = json_decode($detail->json, true);
            $notes[] = [
                'attempt' => $detail->report ?? '-',
                'is_training' => $detail->entrenamiento ?? '-',
                'start_date' => $json['startDate'] ?? '-',
                'end_date' => $json['endDate'] ?? '-',
                'note' => $json['note'] ?? '-',
            ];
        }

        $worker = [
            "nombres" => ($this->worker->nombre ?? '-') . ' ' . ($this->worker->apellido ?? '-'),
            "doi" => $this->worker->user->doi ?? '-',
            "license" => $this->worker->license ?? '-',
            "category" => $this->worker->category ?? '-'
        ];

        $data = [
            'worker' => $worker,
            'attempts' => $notes,
        ];
        return $data;
    }
}
