<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function workers()
    {
        return $this->hasMany(Worker::class, 'id_user');
    }

    // Método para obtener un trabajador por su ID
    public function getWorkerById($workerId)
    {
        return $this->workers()->where('id', $workerId)->first();
    }
}
