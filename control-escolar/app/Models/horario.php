<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class horario extends Model
{
    protected $fillable = ['user_id', 'materia_id', 'dia', 'hora_inicio', 'hora_fin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materia()
    {
        return $this->belongsTo(materia::class);
    }

    public function grupos()
    {
        return $this->hasMany(grupo::class);
    }
}
