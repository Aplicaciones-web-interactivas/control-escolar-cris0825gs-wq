<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = ['grupo_id', 'maestro_id', 'titulo', 'descripcion', 'fecha_entrega'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function maestro()
    {
        return $this->belongsTo(User::class, 'maestro_id');
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }
}
