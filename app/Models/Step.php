<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    //tabla
    protected $table = 'steps';

    //campos
    protected $fillable = [
        'name',
        'duration',
        'workshop_id',
        'created_at',
        'updated_at'
    ];
}
