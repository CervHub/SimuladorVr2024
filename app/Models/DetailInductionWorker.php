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
}
