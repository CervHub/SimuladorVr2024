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
        return $this->hasMany(InductionWorker::class, 'id_induction')->where('status', 1);
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

    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company');
    }

    public function header()
    {

        return [
            'taller' => $this->workshop->name ?? '',
            'instructor' => ($this->worker->nombre ?? '') . ' ' . ($this->worker->apellido ?? ''),
            'instructor_doi' => $this->worker->user->doi ?? '',
            'date_start' => ($this->date_start ?? '') . ' ' . ($this->time_start ?? ''),
            'date_end' => ($this->date_end ?? '') . ' ' . ($this->time_end ?? ''),
            'logo_cerv' => 'logo/logo_negro.png',
            'logo' => $this->company->url_image_desktop
        ];
    }

    public function newNoteJson()
    {
        $workers = $this->workers()->get();

        $notes = [];

        foreach ($workers as $worker) {
            $notes[] = $worker->jsonNote();
        }

        return $notes;
    }
}
