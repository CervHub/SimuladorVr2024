<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company');
    }
    public function service()
    {
        return $this->belongsTo(Company::class, 'id_service');
    }
}
