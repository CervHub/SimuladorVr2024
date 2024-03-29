<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Induction extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_start', // Agrega otros campos si es necesario
        'date_end',
        'time_start',
        'time_end',
        'id_workshop',
        'nota_referencial',
        'intentos',
        'id_company',
        'status',
        'id_worker',
        'alias',
        'pondered_note',
        'minimum_passing_note',
    ];
    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'id_workshop');
    }
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'id_worker');
    }
    public function workers()
    {
        return $this->hasMany(InductionWorker::class, 'id_induction');
    }
    public function alias()
    {
        return $this->hasMany(InductionWorker::class, 'id_induction');
    }
    public function workersStatus()
    {
        $approved = $this->hasMany(InductionWorker::class, 'id_induction')
            ->where('final_note', '>=', $this->minimum_passing_note ?? 50)
            ->get();

        $disapproved = $this->hasMany(InductionWorker::class, 'id_induction')
            ->where('final_note', '<', $this->minimum_passing_note ?? 50)
            ->get();

        $pending = $this->hasMany(InductionWorker::class, 'id_induction')
            ->whereNull('final_note')
            ->get();

        return [
            'approved' => count($approved),
            'disapproved' => count($disapproved),
            'pending' => count($pending),
        ];
    }
}
