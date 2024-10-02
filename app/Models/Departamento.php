<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos'; // Nombre de la tabla

    protected $fillable = ['name', 'company_id']; // Campos que se pueden asignar en masa

    public $timestamps = false; // Desactiva los timestamps

    // Definir la relación con el modelo Area
    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
