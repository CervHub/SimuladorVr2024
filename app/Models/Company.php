<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    public function workers()
    {
        return $this->hasMany(Worker::class, 'id_company');
    }
    public function workshops()
    {
        return $this->hasMany(WorkshopCompany::class, 'id_company');
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'id_company');
    }
}
