<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInductionWorker extends Model
{
    use HasFactory;

    protected $table = 'detail_induction_workers';

    protected $fillable = [
        'induction_worker_id',
        'case',
        'note',
        'note_reference',
        'report',
        'json',
        'end_date',
        'start_date',
        'end_date',
        'entrenamiento'
    ];

    public function induction_worker()
    {
        return $this->belongsTo(InductionWorker::class, 'id');
    }

    /**
     * Puntuación de un detalle según campos con valor (para elegir entre duplicados).
     */
    public static function dataScore(self $detail): float
    {
        return floatval($detail->identified)
            + floatval($detail->risk_level)
            + floatval($detail->correct_measure);
    }

    /**
     * Si el mismo nombre de caso aparece más de una vez, conserva el registro con datos.
     */
    public static function deduplicateByCaseName($collection)
    {
        return $collection
            ->groupBy(fn ($detail) => trim(mb_strtolower($detail->case ?? '')))
            ->map(function ($group) {
                return $group->sortByDesc(fn ($detail) => [self::dataScore($detail), $detail->id])->first();
            })
            ->sortBy('id')
            ->values();
    }
}
