<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;
    public function workshops()
    {
        return $this->hasMany(WorkshopCompany::class, 'id_workshop');
    }
    public function induction()
    {
        return $this->hasMany(Induction::class, 'id_workshop');
    }
}
