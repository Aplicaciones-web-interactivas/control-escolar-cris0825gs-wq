<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = ['user_id', 'materia_id', 'hora_inicio', 'hora_fin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class);
    }
}
