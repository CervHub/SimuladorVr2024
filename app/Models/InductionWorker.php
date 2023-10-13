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

    public function getPonderadoAttribute()
    {
        $nota = ($this->reference_note != 0) ? (number_format($this->note,0) / $this->reference_note) * 20 : 0;

        return number_format($nota,0) ;
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
}
