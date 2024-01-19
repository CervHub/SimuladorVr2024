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

    public function notaConfipetrol()
    {
        $detail = $this->detail()->first();

        return $detail ? intval($detail->note) : '-';
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



}
