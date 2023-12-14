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
        if ($trainingValue == 'evaluacion') {
            return $this->hasMany(DetailInductionWorker::class, 'induction_worker_id')
                ->where('report', $reportValue)
                ->where('entrenamiento', '<>', 1);
        } else {
            return $this->hasMany(DetailInductionWorker::class, 'induction_worker_id')
                ->where('report', $reportValue)
                ->where('entrenamiento', 1);
        }
    }
    public function nota()
    {
        $numReport = $this->num_report;
        $ponderado = $this->puntaje;
        $puntos = 10;
        $detailsCount = [];

        for ($i = 1; $i <= $numReport; $i++) {
            $count = $this->detailsByReport($i)->count() * $puntos;
            $total = $this->detailsByReport($i)->sum('identified') * $puntos;
            $detailsCount[$i] = $count != 0 ? $total * $ponderado / $count : 0;
        }

        return !empty($detailsCount) ? strval(intval(max($detailsCount))) : "-";
    }
}
