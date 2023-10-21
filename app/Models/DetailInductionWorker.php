<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInductionWorker extends Model
{
    use HasFactory;

    public function induction_worker()
    {
        return $this->belongsTo(InductionWorker::class, 'id');
    }
}
