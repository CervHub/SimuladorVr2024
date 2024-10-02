<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopCompany extends Model
{
    use HasFactory;

    protected $table = 'workshop_companies'; // Indica el nombre de la tabla en la base de datos

    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company');
    }
    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'id_workshop');
    }
}
