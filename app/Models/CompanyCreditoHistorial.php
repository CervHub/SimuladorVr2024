<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCreditoHistorial extends Model
{
    use HasFactory;

    protected $table = 'company_creditos_historial';

    protected $fillable = [
        'id_company',
        'creditos_anteriores',
        'creditos_nuevos',
        'diferencia',
        'tipo',
        'origen',
        'observacion',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company');
    }
}
